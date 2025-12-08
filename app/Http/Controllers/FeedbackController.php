<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Guest;
use App\Models\Unit;
use App\Models\Response; // Response Model Included
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class FeedbackController extends Controller
{
    
    public function feedbackform(){
        $units = Unit::all(); 
        return view('fms.feedback', compact('units')); 
    }

    public function feedback(Request $request)
    {
        
        $validatedData = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string|min:10', 
            'is_anonymous' => 'nullable', 
            'guest_email' => 'nullable|email|max:255|unique:guests,email', 
            'guest_name' => 'nullable|string|max:255',
            'guest_type' => 'nullable|in:Student,Teacher,Employee,Other',
        ]);
        
        $isAnonymous = $request->has('is_anonymous');
        $guestId = null; 
        $userId = null; 

        if (!$isAnonymous) {
            
            if (Auth::check()) {
                $userId = Auth::id();
            } elseif ($request->filled('guest_email')) {
                
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
        

        $feedback = Feedback::create([
            'subject' => $validatedData['subject'],
            'unit_id' => $validatedData['unit_id'],
            'body' => $validatedData['body'],
            'is_anonymous' => $isAnonymous,
            'user_id' => $userId,   
            'guest_id' => $guestId, 
        ]);


        $submitted_as = $userId ? 'Registered User (ID: ' . $userId . ')' : 
                                 ($guestId ? 'Guest (ID: ' . $guestId . ')' : 'Anonymous');

        Log::info("Feedback Submitted Successfully.", [
            'feedback_id' => $feedback->id,
            'Submitted_As' => $submitted_as,
            'is_anonymous' => $isAnonymous,
        ]);
        
        return redirect()->back()->with('success', 'Your feedback has been successfully submitted as a ' . $submitted_as . '.');
    }
    
    /**
     * Display a listing of the feedback, filtered by user permission (view-feedback).
     */
    public function index()
    {
        // Requires 'view-feedback' permission
        if (!Auth::user()->can('view-feedback')) {
            abort(403, 'Unauthorized action. You do not have permission to view feedback.');
        }

        $user = Auth::user();
        $query = Feedback::with(['unit', 'user', 'guest'])->latest();

        // 1. System Administrator: View all feedback
        if ($user->hasRole('System Administrator')) {
            // No additional filtering needed
        } 
        // 2. Unit Responder: View only feedback for their assigned unit
        elseif ($user->hasRole('Unit Responder') && $user->unit_id) {
            $query->where('unit_id', $user->unit_id);
        } 
        // 3. Standard Authenticated User (Default): They should not access this view 
        // but if they do, we filter to only their own (non-anonymous) submissions.
        elseif (Auth::check()) {
             $query->where('user_id', $user->id)->where('is_anonymous', false);
        }
        else {
             // For safety, return empty if authentication state is uncertain
             $query->whereRaw('1 = 0');
        }

        $feedbacks = $query->get();

        return view('fms.index', compact('feedbacks'));
    }

    /**
     * Display the specified feedback.
     */
    public function show(Feedback $feedback)
    {
        // Requires 'view-feedback' permission
        if (!Auth::user()->can('view-feedback')) {
            abort(403, 'Unauthorized action. You do not have permission to view feedback.');
        }

        $user = Auth::user();
        
        // Eager load responses and the responder user to display them in the view
        $feedback->load(['responses.responder']); 

        // Authorization logic:
        // 1. Admin can view any feedback.
        if ($user->hasRole('System Administrator')) {
            return view('feedback.show', compact('feedback'));
        }

        // 2. Unit Responder can only view feedback for their unit.
        if (Auth::check() && $user->hasRole('Unit Responder') && $user->unit_id === $feedback->unit_id) {
            return view('feedback.show', compact('feedback'));
        }
        
        // 3. Standard User can only view their own feedback (if not anonymous).
        if (Auth::check() && $user->id === $feedback->user_id && !$feedback->is_anonymous) {
             return view('feedback.show', compact('feedback'));
        }

        // Deny access if user is not authorized
        abort(403, 'Unauthorized action. You do not have permission to view this feedback.');
    }

    /**
     * Show the form for responding to a feedback item.
     * Requires 'respond-feedback' permission.
     */
    public function respond(Feedback $feedback)
    {
        $user = Auth::user();
        
        // Authorization check: Only Admin or the responsible Unit Responder can respond.
        if (!Auth::user()->can('respond-feedback') || (
            !$user->hasRole('System Administrator') && 
            !($user->hasRole('Unit Responder') && $user->unit_id === $feedback->unit_id)
        )) {
            abort(403, 'Unauthorized action. You are not allowed to access the response form.');
        }

        return view('fms.respond', compact('feedback'));
    }
    
    /**
     * Process the feedback response.
     * Saves the response to the polymorphic 'responses' table.
     * Requires 'respond-feedback' permission.
     */
    public function processResponse(Request $request, Feedback $feedback)
    {
        // Authorization check (same as respond method)
        $user = Auth::user();
        if (!Auth::user()->can('respond-feedback') || (
            !$user->hasRole('System Administrator') && 
            !($user->hasRole('Unit Responder') && $user->unit_id === $feedback->unit_id)
        )) {
            abort(403, 'Unauthorized action. You are not authorized to respond.');
        }

        $validated = $request->validate([
            'response_body' => 'required|string|min:20',
        ]);
        
        // --- Feedback Response Logic ---
        
        // 1. Create a new Response record in the polymorphic table
        $response = new Response([
            'response_text' => $validated['response_body'],
            'responder_id' => $user->id,
            'is_public' => true, // Assuming all formal responses are public
            'status_at_response' => 'Responded', // Feedback doesn't typically have a complex status like Complaints
        ]);
        
        // Associate the response with the feedback using the respondable MorphTo relation
        // NOTE: This requires the 'responses' method to be defined in your Feedback model using morphMany.
        $feedback->responses()->save($response);


        // 2. Log the action
        Log::info("Feedback Response Saved to Responses Table.", [
            'feedback_id' => $feedback->id,
            'response_id' => $response->id,
            'user_id' => $user->id,
        ]);

        return redirect()->route('fms.show', $feedback->id)
                         ->with('success', 'Feedback response has been successfully submitted.');
    }
}