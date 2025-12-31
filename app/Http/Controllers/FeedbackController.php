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
    // 1. መጀመሪያ አይነቶቹን በአጭር ስም እንመድባለን
    $typeMapping = [
        'College'    => \App\Models\College::class,
        'Department' => \App\Models\Department::class,
        'Directory'  => \App\Models\Directory::class,
    ];

    $validatedData = $request->validate([
        'recipient_type' => ['required', 'string', Rule::in(array_keys($typeMapping))],
        'recipient_id'   => 'required|integer', 
        'subject'        => 'required|string|max:255',
        'body'           => 'required|string|min:10', 
        'is_anonymous'   => 'nullable', 
        'guest_email'    => [
            Rule::requiredIf(fn() => !Auth::check() && !$request->has('is_anonymous')),
            'nullable', 'email', 'max:255'
        ],
        'guest_name'     => 'nullable|string|max:255',
        'guest_type'     => 'nullable|in:Student,Teacher,Employee,Other',
    ]);

    // 2. Recipient Validation
    $modelClass = $typeMapping[$validatedData['recipient_type']];
    if (!$modelClass::where('id', $validatedData['recipient_id'])->exists()) {
         return redirect()->back()->withInput()->withErrors(['recipient_id' => 'የተመረጠው ክፍል አልተገኘም።']);
    }

    // 3. Reporter Identification
    $isAnonymous = $request->has('is_anonymous');
    $guestId = null; 
    $userId = Auth::id(); // ሎጊን ካደረገ ይይዛል፣ ካልሆነ null ይሆናል

    if (!$isAnonymous && !Auth::check() && $request->filled('guest_email')) {
        $guest = Guest::firstOrCreate(
            ['email' => $validatedData['guest_email']],
            [
                'name' => $validatedData['guest_name'],
                'guest_type' => $validatedData['guest_type'],
            ]
        );
        $guestId = $guest->id;
    }

    // 4. Save Feedback
    $feedback = Feedback::create([
        'subject'        => $validatedData['subject'],
        'body'           => $validatedData['body'],
        'is_anonymous'   => $isAnonymous,
        'user_id'        => $userId,
        'guest_id'       => $guestId,
        'recipient_id'   => $validatedData['recipient_id'],
        'recipient_type' => $validatedData['recipient_type'], // አጭር ስም (ለምሳሌ 'College')
    ]);

    return redirect()->back()->with('success', 'Your feedback has been successfully submitted.');
}

    /**
     * Display a listing of the feedback, filtered by user permission.
     * Authorization Logic Updated to use the new Recipient Model structure.
     */
    public function index()
{
    if (Gate::denies('view-feedback')) {
        abort(403, 'Unauthorized action.');
    }

    $user = Auth::user();
    $query = Feedback::with(['recipient', 'user', 'guest'])->latest();

    if ($user->hasRole('System Administrator')) {
        // ሁሉንም ያያል
    } 
    elseif ($user->hasRole('Unit Responder')) {
        $query->where(function ($q) use ($user) {
            // እዚህ ጋር በ 'College::class' ፋንታ 'College' የሚለውን አጭር ስም ተጠቀም
            if ($user->college_id) {
                $q->orWhere(function($sq) use ($user) {
                    $sq->where('recipient_type', 'College') 
                       ->where('recipient_id', $user->college_id);
                });
            }
            
            if ($user->department_id) {
                $q->orWhere(function($sq) use ($user) {
                    $sq->where('recipient_type', 'Department')
                       ->where('recipient_id', $user->department_id);
                });
            }

            if ($user->directory_id) {
                $q->orWhere(function($sq) use ($user) {
                    $sq->where('recipient_type', 'Directory')
                       ->where('recipient_id', $user->directory_id);
                });
            }
        });
    } 
    elseif (Auth::check()) {
        $query->where('user_id', $user->id)->where('is_anonymous', false);
    }

    $feedbacks = $query->paginate(10);
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
            return view('fms.show', compact('feedback'));
        }

        // 2. Unit Responder can only view feedback for their assigned recipient.
        $isResponder = $this->isUserResponsibleForRecipient($user, $feedback->recipient_type, $feedback->recipient_id);

        if ($user->hasRole('Unit Responder') && $isResponder) {
            return view('fms.show', compact('feedback'));
        }
        
        // 3. Standard User can only view their own feedback (if not anonymous).
        if ($user->id === $feedback->user_id && !$feedback->is_anonymous) {
             return view('fms.show', compact('feedback'));
        }

        // Deny access if user is not authorized
        abort(403, 'Unauthorized action. You do not have permission to view this feedback.');
    }

   /**
 * DELETE Feedback - System Admin Only.
 */
public function destroy(Feedback $feedback) // እዚህ ጋር Complaint የነበረውን ወደ Feedback ቀይረው
{
    // Admin መሆኑን ማረጋገጥ
    if (!Auth::user()->hasRole('System Administrator')) {
        abort(403, 'Only admins can delete feedback.');
    }

    $feedback->delete();

    return redirect()->route('feedback.index')
                     ->with('success', 'Feedback deleted successfully.');
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
    
    // ሪስፖንደር መሆኑን ማረጋገጥ
    $isResponder = $this->isUserResponsibleForRecipient($user, $feedback->recipient_type, $feedback->recipient_id);
    
    if (!$user->hasRole('System Administrator') && !($user->hasRole('Unit Responder') && $isResponder)) {
        abort(403, 'Unauthorized to respond.');
    }

    $validated = $request->validate([
        'response_body' => 'required|string|min:10',
    ]);
    
    // አዲስ Response መፍጠር
    $response = new Response([
        'response_text' => $validated['response_body'],
        'responder_id' => $user->id,
        'is_public' => true, 
        'status_at_response' => 'Feedback Processed', // ለ Feedback የሚሆን ስም
    ]);
    
    // በ Polymorphic relationship ሴቭ ማድረግ
    $feedback->responses()->save($response);

    return redirect()->route('feedback.show', $feedback->id)
                     ->with('success', 'Feedback response submitted successfully.');
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
    // MorphMap ከተጠቀምክ $recipientType የሚመጣው 'College' በሚል አጭር ስም ነው
    if ($recipientType === 'College' && $user->college_id === $recipientId) {
        return true;
    }
    if ($recipientType === 'Department' && $user->department_id === $recipientId) {
        return true;
    }
    if ($recipientType === 'Directory' && $user->directory_id === $recipientId) {
        return true;
    }
    return false;
}
}