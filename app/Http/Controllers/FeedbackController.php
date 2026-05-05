<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Guest;
use App\Models\College; 
use App\Models\Directory;
use App\Models\Department;
use App\Models\Response; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;//for email
use App\Mail\ResponseNotification;//for email

class FeedbackController extends Controller
{
    public function feedbackform()
    {
        $colleges = College::all(['id', 'name_en']); 
        
        return view('fms.feedback', compact('colleges')); 
    }

    public function feedback(Request $request)
{

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
        'feedback_type' => ['required', Rule::in(['Positive', 'Negative', 'Neutral'])],
    ]);

    $modelClass = $typeMapping[$validatedData['recipient_type']];
    if (!$modelClass::where('id', $validatedData['recipient_id'])->exists()) {
         return redirect()->back()->withInput()->withErrors(['recipient_id' => 'apsent selected unit']);
    }

    $isAnonymous = $request->has('is_anonymous');
    $guestId = null; 
    $userId = Auth::id(); 

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

    $feedback = Feedback::create([
        'subject'        => $validatedData['subject'],
        'body'           => $validatedData['body'],
        'is_anonymous'   => $isAnonymous,
        'user_id'        => $userId,
        'guest_id'       => $guestId,
        'recipient_id'   => $validatedData['recipient_id'],
        'recipient_type' => $validatedData['recipient_type'], 
        'status'         => 'New',
        'feedback_type' => $validatedData['feedback_type'],
    ]);

    return redirect()->back()->with('success', 'Your feedback has been successfully submitted.');
}

    
public function index(Request $request)
{
    $user = Auth::user();
    $query = Feedback::with(['recipient', 'user', 'guest']);

    if ($user->hasRole('System Administrator')) {
        if ($request->filled('unit_type') && $request->filled('unit_id')) {
            $query->where('recipient_type', $request->unit_type)
                  ->where('recipient_id', $request->unit_id);
            
            if ($request->filled('feedback_type')) {
                $query->where('feedback_type', $request->feedback_type);
            }
        } else {
            $query->whereRaw('1 = 0'); 
        }
    } else {
        if ($user->college_id) {
            $query->where('recipient_type', 'College')->where('recipient_id', $user->college_id);
        } elseif ($user->directory_id) {
            $query->where('recipient_type', 'Directory')->where('recipient_id', $user->directory_id);
        } elseif ($user->department_id) {
            $query->where('recipient_type', 'Department')->where('recipient_id', $user->department_id);
        }

        if ($request->filled('feedback_type')) {
            $query->where('feedback_type', $request->feedback_type);
        }
    }

    $statsData = (clone $query)->select('feedback_type', \DB::raw('count(*) as total'))
        ->groupBy('feedback_type')
        ->pluck('total', 'feedback_type')
        ->toArray();

    $stats = [
        'Positive' => $statsData['Positive'] ?? 0,
        'Negative' => $statsData['Negative'] ?? 0,
        'Neutral'  => $statsData['Neutral'] ?? 0,
    ];

    $feedbacks = $query->latest()->get();
    $colleges = \App\Models\College::all();
    
    return view('fms.index', compact('feedbacks', 'stats', 'colleges'));
}
public function show(Feedback $feedback)
{
    $user = Auth::user();

  if ($user->id === $feedback->user_id) {
    \App\Models\Response::where('respondable_type', 'Feedback') 
        ->where('respondable_id', $feedback->id)
        ->where('is_seen', false)
        ->update(['is_seen' => true]);
}

    $feedback->load(['responses.responder', 'recipient']); 
    $isResponder = $this->isUserResponsibleForRecipient($user, $feedback->recipient_type, $feedback->recipient_id);

    if ($user->hasRole('System Administrator') || ($user->hasRole('Unit Responder') && $isResponder)) {
        if ($user->hasRole('Unit Responder') && $isResponder) {
            if (in_array($feedback->status, ['New', 'Forwarded'])) {
                $feedback->update(['status' => 'Viewed']);
            }
        }
        return view('fms.show', compact('feedback'));
    }

    if ($user->id === $feedback->user_id && !$feedback->is_anonymous) {
         return view('fms.show', compact('feedback'));
    }

    abort(403, 'Unauthorized action.');
}
public function destroy(Feedback $feedback) 
{
    
    $feedback->delete();

    return redirect()->route('feedback.index')
                     ->with('success', 'Feedback deleted successfully.');
}

    
    public function respond(Feedback $feedback)
    {
        $user = Auth::user();
  
        $isResponder = $this->isUserResponsibleForRecipient($user, $feedback->recipient_type, $feedback->recipient_id);

        if (Gate::denies('respond-feedback') || (
            !$user->hasRole('System Administrator') && 
            !($user->hasRole('Unit Responder') && $isResponder)
        )) {
            abort(403, 'Unauthorized action. You are not allowed to access the response form.');
        }

        return view('fms.respond', compact('feedback'));
    }
    
public function processResponse(Request $request, Feedback $feedback)
{
    $user = Auth::user();
    $validated = $request->validate([
        'response_body' => 'required|string|min:5',
    ]);
    
    //for register response 
    $response = new Response([
        'response_text' => $validated['response_body'],
        'responder_id' => $user->id,
        'is_public' => true, 
        'status_at_response' => 'Responded',
    ]);
    
    $feedback->responses()->save($response);
    $feedback->update(['status' => 'Responded']);

   
    if (!$feedback->is_anonymous) {
        
        $recipientEmail = $feedback->user->email ?? $feedback->guest->email ?? null;

        if ($recipientEmail) {
            try {
        
                \Illuminate\Support\Facades\Mail::to($recipientEmail)
                    ->send(new \App\Mail\ResponseNotification($feedback, $validated['response_body']));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Feedback Email failed: " . $e->getMessage());
            }
        }
    }

    return redirect()->route('feedback.show', $feedback->id)
                     ->with('success', 'Response submitted and notification email sent!');
}
public function forward(Request $request, Feedback $feedback)
{
    $validated = $request->validate([
        'recipient_type' => 'required|in:College,Department,Directory',
        'recipient_id'   => 'required|integer',
        'forward_note'   => 'nullable|string|',
    ]);

    $feedback->update([
        'recipient_type'         => $validated['recipient_type'],
        'recipient_id'           => $validated['recipient_id'],
        'forwarded_from_user_id' => Auth::id(),
        'forward_note'           => $validated['forward_note'],
        'status'                 => 'Forwarded',
        
    ]);
    
    if (Auth::user()->hasRole('General User')) {
        return redirect()->route('dashboard')->with('success', 'Complaint forwarded successfully!');
    }

    return redirect()->route('feedback.index')->with('success', 'Feedback forwarded successfully!');
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