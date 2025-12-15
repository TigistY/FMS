<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\College; // አዲስ ሞዴሎች ጨምሩ
use App\Models\Directory;
use App\Models\Department;
use App\Models\Guest;
use App\Models\Response; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class ComplaintController extends Controller
{
    /**
     * Show the form for creating a new complaint.
     * አሁን ኮሌጆች ለ dependent dropdown ያስፈልጋሉ
     */
    public function create()
    {
        // ኮሌጆችን ለ Dependent Dropdown እንልካለን
        $colleges = College::all(['id', 'name_en']);
        
        return view('complaints.create', compact('colleges'));
    }

    /**
     * Store a newly created complaint in storage.
     */
    public function store(Request $request)
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
        
        // --- 1. Recipient Validation ---
        $recipientModel = app($validatedData['recipient_type']);
        if (!$recipientModel::where('id', $validatedData['recipient_id'])->exists()) {
             return redirect()->back()->withInput()->withErrors(['recipient_id' => 'የተመረጠው የመድረሻ አካል ትክክል አይደለም።']);
        }

        // --- 2. Reporter Identification Logic ---
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
        } 

        // --- 3. Create Complaint Record ---
        $complaint = Complaint::create([
            'subject' => $validatedData['subject'],
            'body' => $validatedData['body'],
            'status' => 'Pending',
            'priority' => 'Medium',
            'is_anonymous' => $isAnonymous,
            'user_id' => $userId,
            'guest_id' => $guestId,
            
            // 🆕 Polymorphic Keys
            'recipient_id' => $validatedData['recipient_id'],
            'recipient_type' => $validatedData['recipient_type'],
        ]);
        
        $submitted_as = $userId ? 'Registered User (ID: ' . $userId . ')' :
                                 ($guestId ? 'Guest (ID: ' . $guestId . ')' : 'Anonymous');

        Log::info("Complaint Submitted Successfully.", [
            'complaint_id' => $complaint->id,
            'Submitted_As' => $submitted_as,
            'Recipient' => $validatedData['recipient_type'] . '/' . $validatedData['recipient_id'],
        ]);

        return redirect()->back()->with('success', 'Your complaint has been successfully submitted.');
    }

    /**
     * Display a listing of the complaints, filtered by user permission.
     * Authorization Logic Updated.
     */
    public function index()
    {
        $user = Auth::user();
        
        $query = Complaint::with(['recipient', 'user', 'guest'])->latest();

        // 1. System Administrator: View all complaints
        if ($user->hasRole('System Administrator')) {
            // No additional filtering needed
        } 
        // 2. Unit Responder: View only complaints for their assigned units (College/Dept/Directory)
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
        // 3. Standard Authenticated User: View only their own submissions
        else {
            $query->where('user_id', $user->id);
        }

        $complaints = $query->get();

        return view('complaints.index', compact('complaints'));
    }
    
    /**
     * Display the specified complaint.
     * Authorization Logic Updated.
     */
    public function show(Complaint $complaint)
    {
        $user = Auth::user();

        $complaint->load(['responses.responder', 'recipient']); 

        // 1. Admin can view any complaint.
        if ($user->hasRole('System Administrator')) {
            return view('complaints.show', compact('complaint'));
        }

        // 2. Unit Responder can only view complaints for their assigned recipient.
        $isResponder = $this->isUserResponsibleForRecipient($user, $complaint->recipient_type, $complaint->recipient_id);

        if ($user->hasRole('Unit Responder') && $isResponder) {
            return view('complaints.show', compact('complaint'));
        }
        
        // 3. Standard User can only view their own complaint (if not anonymous).
        if ($user->id === $complaint->user_id && !$complaint->is_anonymous) {
             return view('complaints.show', compact('complaint'));
        }

        // Deny access if user is not authorized
        abort(403, 'Unauthorized action. You do not have permission to view this complaint.');
    }

    // ... (destroy method remains largely the same, removed for brevity)
    // ... (respond method authorization logic updated using isUserResponsibleForRecipient)

    /**
     * Process the complaint response and update its status.
     * Authorization Logic Updated.
     */
    public function processResponse(Request $request, Complaint $complaint)
    {
        $user = Auth::user();

        // Authorization check (same as respond method)
        $isResponder = $this->isUserResponsibleForRecipient($user, $complaint->recipient_type, $complaint->recipient_id);
        
        if (!$user->hasRole('System Administrator') && 
            !($user->hasRole('Unit Responder') && $isResponder)) {
            abort(403, 'Unauthorized action. You are not authorized to respond.');
        }

        $validated = $request->validate([
            'response_body' => 'required|string|min:20',
            'status' => ['required', Rule::in(['Pending', 'Assigned', 'In Progress', 'Resolved', 'Closed'])],
        ]);
        
        // --- Complaint Response Logic ---
        
        $response = new Response([
            'response_text' => $validated['response_body'],
            'responder_id' => $user->id,
            'is_public' => true, 
            'status_at_response' => $validated['status'],
        ]);
        
        $complaint->responses()->save($response);

        // Update Complaint Status
        $complaint->status = $validated['status'];
        $complaint->save();
        
        Log::info("Complaint Response Saved to Responses Table and Complaint Status Updated.", [
            'complaint_id' => $complaint->id,
            'response_id' => $response->id,
            'user_id' => $user->id,
            'new_status' => $validated['status'],
        ]);

        return redirect()->route('complaints.show', $complaint->id)
                         ->with('success', 'Complaint response has been successfully submitted and status updated to ' . $validated['status'] . '.');
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