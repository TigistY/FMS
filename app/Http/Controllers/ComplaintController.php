<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Unit;
use App\Models\Guest;
use App\Models\Response; // Response Model Included
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class ComplaintController extends Controller
{
    /**
     * Show the form for creating a new complaint.
     */
    public function create()
    {
        // Fetches all units for the dropdown in the submission form
        $units = Unit::all();
        
        return view('complaints.create', compact('units'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string|min:10', 
            'is_anonymous' => 'nullable', 
            'guest_email' => 'nullable|email|max:255', 
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

        $complaint = Complaint::create([
            'subject' => $validatedData['subject'],
            'unit_id' => $validatedData['unit_id'],
            'body' => $validatedData['body'],
            'status' => 'Pending',
            'priority' => 'Medium',
            'is_anonymous' => $isAnonymous,
            'user_id' => $userId,
            'guest_id' => $guestId,
        ]);
        
        $submitted_as = $userId ? 'Registered User (ID: ' . $userId . ')' :
                              ($guestId ? 'Guest (ID: ' . $guestId . ')' : 'Anonymous');

        Log::info("Complaint Submitted Successfully.", [
            'complaint_id' => $complaint->id,
            'Submitted_As' => $submitted_as,
            'is_anonymous' => $isAnonymous,
        ]);

        return redirect()->back()->with('success', 'Your complaint has been successfully submitted.');
    }

    /**
     * Display a listing of the complaints, filtered by user permission.
     */
    public function index()
    {
        $user = Auth::user();
    
        $query = Complaint::with(['unit', 'user', 'guest'])->latest();

        // 1. System Administrator: View all complaints
        if ($user->hasRole('System Administrator')) {
            // No additional filtering needed
        } 
        // 2. Unit Responder: View only complaints for their assigned unit
        // This is the standard responsibility for a unit responder.
        elseif ($user->hasRole('Unit Responder') && $user->unit_id) {
            $query->where('unit_id', $user->unit_id);
        } 
        // 3. Standard Authenticated User (Default): View only their own submissions
        // If the user is not an Admin or Responder, they see only what they submitted.
        else {
            $query->where('user_id', $user->id);
        }

        $complaints = $query->get();

        return view('complaints.index', compact('complaints'));
    }
    
    /**
     * Display the specified complaint.
     */
    public function show(Complaint $complaint)
    {
        $user = Auth::user();

        // Eager load responses and the responder user to display them in the view
        $complaint->load(['responses.responder']); 

        // Authorization logic:
        // 1. Admin can view any complaint.
        if ($user->hasRole('System Administrator')) {
            return view('complaints.show', compact('complaint'));
        }

        // 2. Unit Responder can only view complaints for their unit.
        if (Auth::check() && $user->hasRole('Unit Responder') && $user->unit_id === $complaint->unit_id) {
            return view('complaints.show', compact('complaint'));
        }
        
        // 3. Standard User can only view their own complaint.
        if (Auth::check() && $user->id === $complaint->user_id && !$complaint->is_anonymous) {
             return view('complaints.show', compact('complaint'));
        }

        // Deny access if user is not authorized
        abort(403, 'Unauthorized action. You do not have permission to view this complaint.');
    }

    /**
     * Remove the specified complaint from storage.
     * Accessible only by System Administrator.
     */
    public function destroy(Complaint $complaint)
    {
        // Only System Administrator can delete
        if (!Auth::user()->hasRole('System Administrator')) {
            abort(403, 'Unauthorized action. Only system administrators can delete complaints.');
        }
        
        $complaint->delete();

        return redirect()->route('index')
                         ->with('success', 'Complaint deleted successfully.');
    }
    
    /**
     * Show the form for responding to a complaint.
     */
    public function respond(Complaint $complaint)
    {
        $user = Auth::user();

        // Authorization check: Only Admin or the responsible Unit Responder can respond.
        if (!$user->hasRole('System Administrator') && 
            !($user->hasRole('Unit Responder') && $user->unit_id === $complaint->unit_id)) {
            abort(403, 'Unauthorized action. You are not allowed to access the response form.');
        }

        return view('complaints.respond', compact('complaint'));
    }
    
    /**
     * Process the complaint response and update its status.
     * Saves the response to the polymorphic 'responses' table.
     */
    public function processResponse(Request $request, Complaint $complaint)
    {
        $user = Auth::user();

        // Authorization check (same as respond method)
        if (!$user->hasRole('System Administrator') && 
            !($user->hasRole('Unit Responder') && $user->unit_id === $complaint->unit_id)) {
            abort(403, 'Unauthorized action. You are not authorized to respond.');
        }

        $validated = $request->validate([
            'response_body' => 'required|string|min:20',
            // Allow status update only if the user is authorized (Admin or Responder)
            'status' => ['required', Rule::in(['Pending', 'Assigned', 'In Progress', 'Resolved', 'Closed'])],
        ]);
        
        // --- Complaint Response Logic ---
        
        // 1. Create a new Response record in the polymorphic table
        $response = new Response([
            'response_text' => $validated['response_body'],
            'responder_id' => $user->id,
            'is_public' => true, // Assuming all formal responses are public for this system
            'status_at_response' => $validated['status'],
        ]);
        
        // Associate the response with the complaint using the respondable MorphTo relation
        // NOTE: This requires the 'responses' method to be defined in your Complaint model using morphMany.
        $complaint->responses()->save($response);


        // 2. Update Complaint Status (if different)
        $complaint->status = $validated['status'];
        $complaint->save();
        
        // 3. Log the action
        Log::info("Complaint Response Saved to Responses Table and Complaint Status Updated.", [
            'complaint_id' => $complaint->id,
            'response_id' => $response->id,
            'user_id' => $user->id,
            'new_status' => $validated['status'],
        ]);

        return redirect()->route('show', $complaint->id)
                         ->with('success', 'Complaint response has been successfully submitted and status updated to ' . $validated['status'] . '.');
    }
}