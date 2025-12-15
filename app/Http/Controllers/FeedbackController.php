<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Guest;
use App\Models\College; // አዲስ ሞዴሎች ጨምሩ
use App\Models\Directory;
use App\Models\Department;
use App\Models\Response; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class FeedbackController extends Controller
{
    // ... (ከዚህ በፊት የነበሩ ሌሎች use statements)

    /**
     * Show the form for creating a new feedback.
     * አሁን ኮሌጆች ለ dependent dropdown ያስፈልጋሉ
     */
    public function feedbackform()
    {
        // ኮሌጆችን ለ Dependent Dropdown እንልካለን
        $colleges = College::all(['id', 'name_en']); 
        
        return view('fms.feedback', compact('colleges')); 
    }

    /**
     * Store a newly created feedback in storage.
     */
    public function feedback(Request $request)
    {
        // Polymorphic Type Validation
        $validRecipientTypes = [
            'App\\Models\\College',
            'App\\Models\\Department',
            'App\\Models\\Directory',
        ];
        
        $validatedData = $request->validate([
            // 🆕 አዲሶቹ የመድረሻ አካል (Recipient) መስኮች
            'recipient_type' => ['required', 'string', Rule::in($validRecipientTypes)],
            'recipient_id' => 'required|integer', 
            
            // ሪፖርተር ዳታ
            'subject' => 'required|string|max:255',
            'body' => 'required|string|min:10', 
            'is_anonymous' => 'nullable', 
            'guest_email' => 'nullable|email|max:255|unique:guests,email', 
            'guest_name' => 'nullable|string|max:255',
            'guest_type' => 'nullable|in:Student,Teacher,Employee,Other',
            'college_id' => 'nullable|exists:colleges,id', // ለ Department ምርጫ ብቻ
        ]);
        
        // --- 1. Recipient Validation (Recipient ID በትክክል መኖሩን ማረጋገጥ) ---
        $recipientModel = app($validatedData['recipient_type']);
        if (!$recipientModel::where('id', $validatedData['recipient_id'])->exists()) {
             return redirect()->back()->withInput()->withErrors(['recipient_id' => 'የተመረጠው የመድረሻ አካል ትክክል አይደለም።']);
        }
        
        // --- 2. Reporter Identification Logic (Unchanged but using new validation) ---
        $isAnonymous = $request->has('is_anonymous');
        $guestId = null; 
        $userId = null; 

        if (!$isAnonymous) {
            if (Auth::check()) {
                $userId = Auth::id();
            } elseif ($request->filled('guest_email')) {
                // Find or create guest record
                $guest = Guest::firstOrCreate(
                    ['email' => $validatedData['guest_email']],
                    [
                        'name' => $validatedData['guest_name'] ?? null,
                        'guest_type' => $validatedData['guest_type'] ?? null,
                    ]
                );
                $guestId = $guest->id;
            } 
            // NOTE: If neither user nor guest email is present, and it's not anonymous, the submission is invalid.
        } 
        
        // --- 3. Create Feedback Record ---
        $feedback = Feedback::create([
            'subject' => $validatedData['subject'],
            'body' => $validatedData['body'],
            'is_anonymous' => $isAnonymous,
            'user_id' => $userId,  
            'guest_id' => $guestId, 
            
            // 🆕 Polymorphic Keys
            'recipient_id' => $validatedData['recipient_id'],
            'recipient_type' => $validatedData['recipient_type'],
        ]);

        $submitted_as = $userId ? 'Registered User (ID: ' . $userId . ')' : 
                                 ($guestId ? 'Guest (ID: ' . $guestId . ')' : 'Anonymous');

        Log::info("Feedback Submitted Successfully.", [
            'feedback_id' => $feedback->id,
            'Submitted_As' => $submitted_as,
            'Recipient' => $validatedData['recipient_type'] . '/' . $validatedData['recipient_id'],
        ]);
        
        return redirect()->back()->with('success', 'Your feedback has been successfully submitted as a ' . $submitted_as . '.');
    }

    /**
     * Display a listing of the feedback, filtered by user permission.
     * Authorization Logic Updated to use the new Recipient Model structure.
     */
    public function index()
    {
        // 🚨 Gate Authorization: 'view-feedback' ፐርሚሽን የሚጠቀሙት ሰዎች ብቻ እንዲገቡ
        if (Gate::denies('view-feedback')) {
            abort(403, 'Unauthorized action. You do not have permission to view feedback.');
        }

        $user = Auth::user();
        $query = Feedback::with(['recipient', 'user', 'guest'])->latest();

        // 1. System Administrator: View all feedback
        if ($user->hasRole('System Administrator')) {
            // No additional filtering needed
        } 
        // 2. Unit Responder: View only feedback for their assigned units (College/Dept/Directory)
        // 🚨 NOTE: 'Unit Responder' must have College/Department/Directory IDs on the User model.
        elseif ($user->hasRole('Unit Responder')) {
            $query->where(function ($q) use ($user) {
                // If user is a College Responder
                if ($user->college_id) {
                    $q->orWhere(function($q) use ($user) {
                        $q->where('recipient_type', College::class)
                          ->where('recipient_id', $user->college_id);
                    });
                }
                // If user is a Department Responder
                if ($user->department_id) {
                    $q->orWhere(function($q) use ($user) {
                        $q->where('recipient_type', Department::class)
                          ->where('recipient_id', $user->department_id);
                    });
                }
                // If user is a Directory Responder
                if ($user->directory_id) {
                    $q->orWhere(function($q) use ($user) {
                        $q->where('recipient_type', Directory::class)
                          ->where('recipient_id', $user->directory_id);
                    });
                }
            });
        }
        // 3. Standard Authenticated User: View only their own submissions (non-anonymous).
        elseif (Auth::check()) {
            $query->where('user_id', $user->id)->where('is_anonymous', false);
        }
        else {
             // For safety, return empty if authentication state is uncertain/unauthorized
             $query->whereRaw('1 = 0');
        }

        $feedbacks = $query->get();

        return view('fms.index', compact('feedbacks'));
    }

    /**
     * Display the specified feedback.
     * Authorization Logic Updated.
     */
    public function show(Feedback $feedback)
    {
        // 🚨 Gate Authorization
        if (Gate::denies('view-feedback')) {
            abort(403, 'Unauthorized action. You do not have permission to view feedback.');
        }

        $user = Auth::user();
        
        $feedback->load(['responses.responder', 'recipient']); 

        // 1. Admin can view any feedback.
        if ($user->hasRole('System Administrator')) {
            return view('feedback.show', compact('feedback'));
        }

        // 2. Unit Responder can only view feedback for their assigned recipient.
        $isResponder = $this->isUserResponsibleForRecipient($user, $feedback->recipient_type, $feedback->recipient_id);

        if ($user->hasRole('Unit Responder') && $isResponder) {
            return view('feedback.show', compact('feedback'));
        }
        
        // 3. Standard User can only view their own feedback (if not anonymous).
        if ($user->id === $feedback->user_id && !$feedback->is_anonymous) {
             return view('feedback.show', compact('feedback'));
        }

        // Deny access if user is not authorized
        abort(403, 'Unauthorized action. You do not have permission to view this feedback.');
    }

    /**
     * Show the form for responding to a feedback item.
     * Requires 'respond-feedback' permission.
     * Authorization Logic Updated.
     */
    public function respond(Feedback $feedback)
    {
        $user = Auth::user();
        
        // Authorization check: Only Admin or the responsible Unit Responder can respond.
        $isResponder = $this->isUserResponsibleForRecipient($user, $feedback->recipient_type, $feedback->recipient_id);

        if (Gate::denies('respond-feedback') || (
            !$user->hasRole('System Administrator') && 
            !($user->hasRole('Unit Responder') && $isResponder)
        )) {
            abort(403, 'Unauthorized action. You are not allowed to access the response form.');
        }

        return view('fms.respond', compact('feedback'));
    }
    
    /**
     * Process the feedback response.
     * Saves the response to the polymorphic 'responses' table.
     * Requires 'respond-feedback' permission.
     * Authorization Logic Updated.
     */
    public function processResponse(Request $request, Feedback $feedback)
    {
        $user = Auth::user();

        // Authorization check (same as respond method)
        $isResponder = $this->isUserResponsibleForRecipient($user, $feedback->recipient_type, $feedback->recipient_id);

        if (Gate::denies('respond-feedback') || (
            !$user->hasRole('System Administrator') && 
            !($user->hasRole('Unit Responder') && $isResponder)
        )) {
            abort(403, 'Unauthorized action. You are not authorized to respond.');
        }

        $validated = $request->validate([
            'response_body' => 'required|string|min:20',
        ]);
        
        // --- Feedback Response Logic ---
        
        $response = new Response([
            'response_text' => $validated['response_body'],
            'responder_id' => $user->id,
            'is_public' => true, 
            'status_at_response' => 'Responded', 
        ]);
        
        $feedback->responses()->save($response);


        Log::info("Feedback Response Saved to Responses Table.", [
            'feedback_id' => $feedback->id,
            'response_id' => $response->id,
            'user_id' => $user->id,
        ]);

        return redirect()->route('fms.show', $feedback->id)
                         ->with('success', 'Feedback response has been successfully submitted.');
    }

    /**
     * Helper method to check if a Unit Responder is responsible for the recipient.
     * @param \App\Models\User $user
     * @param string $recipientType (e.g., App\Models\College)
     * @param int $recipientId
     * @return bool
     */
    protected function isUserResponsibleForRecipient($user, $recipientType, $recipientId): bool
    {
        if ($recipientType === College::class && $user->college_id === $recipientId) {
            return true;
        }
        if ($recipientType === Department::class && $user->department_id === $recipientId) {
            return true;
        }
        if ($recipientType === Directory::class && $user->directory_id === $recipientId) {
            return true;
        }
        return false;
    }
}