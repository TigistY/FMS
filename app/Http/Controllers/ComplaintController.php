<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\College;
use App\Models\Directory;
use App\Models\Department;
use App\Models\Guest;
use App\Models\Response; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ComplaintController extends Controller
{
    public function create()
    {
        $colleges = College::all(['id', 'name_en']);
        return view('complaints.create', compact('colleges'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'recipient_type' => ['required', 'string', Rule::in(['College', 'Department', 'Directory'])],
            'recipient_id'   => 'required|integer', 
            'subject'        => 'required|string|max:255',
            'body'           => 'required|string|min:10', 
            'is_anonymous'   => 'nullable', 
            'guest_email'    => [
                Rule::requiredIf(fn() => !Auth::check() && !$request->has('is_anonymous')),
                'nullable', 'email', 'max:255'
            ],
            'guest_name'     => 'nullable|string|max:255',
            'guest_type'     => [
                Rule::requiredIf(fn() => !Auth::check() && !$request->has('is_anonymous')),
                'nullable', 'in:Student,Teacher,Employee,Other'
            ],
        ]);

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

        $complaint = Complaint::create([
            'subject'        => $validatedData['subject'],
            'body'           => $validatedData['body'],
            'status'         => 'Pending',
            'priority'       => 'Medium',
            'is_anonymous'   => $isAnonymous,
            'user_id'        => $userId,
            'guest_id'       => $guestId,
            'recipient_id'   => $validatedData['recipient_id'],
            'recipient_type' => $validatedData['recipient_type'], 
        ]);

        Log::info("New Complaint Submitted", ['id' => $complaint->id]);

        return redirect()->back()->with('success', 'Your complaint has been successfully submitted');
    }

    public function index()
{
    $user = Auth::user();
    $query = Complaint::with(['recipient', 'user', 'guest'])->latest();

    if ($user->hasRole('System Administrator')) {

    } elseif ($user->hasRole('Unit Responder')) {
        $query->where(function ($q) use ($user) {

            if ($user->college_id) {
                $q->orWhere(fn($sq) => $sq->where('recipient_type', 'College')->where('recipient_id', $user->college_id));
            }
            if ($user->department_id) {
                $q->orWhere(fn($sq) => $sq->where('recipient_type', 'Department')->where('recipient_id', $user->department_id));
            }
            if ($user->directory_id) {
                $q->orWhere(fn($sq) => $sq->where('recipient_type', 'Directory')->where('recipient_id', $user->directory_id));
            }
        });
    } else {
        
        $query->where('user_id', $user->id);
    }

    $complaints = $query->paginate(10); 
    return view('complaints.index', compact('complaints'));
}

    public function show(Complaint $complaint)
    {
        $user = Auth::user();
        $complaint->load(['responses.responder', 'recipient']); 

        $isResponder = $this->isUserResponsibleForRecipient($user, $complaint->recipient_type, $complaint->recipient_id);

        if ($user->hasRole('System Administrator') || 
           ($user->hasRole('Unit Responder') && $isResponder) || 
           ($user->id === $complaint->user_id && !$complaint->is_anonymous)) {
            
            return view('complaints.show', compact('complaint'));
        }

        abort(403, 'Unauthorized access.');
    }

    public function processResponse(Request $request, Complaint $complaint)
    {
        $user = Auth::user();
        $isResponder = $this->isUserResponsibleForRecipient($user, $complaint->recipient_type, $complaint->recipient_id);
        
        if (!$user->hasRole('System Administrator') && !($user->hasRole('Unit Responder') && $isResponder)) {
            abort(403, 'Unauthorized to respond.');
        }

        $validated = $request->validate([
            'response_body' => 'required|string|min:10',
            'status'        => ['required', Rule::in(['In Progress', 'Resolved', 'Closed'])],
            'priority'      => ['required', Rule::in(['Low', 'Medium', 'High'])], 
        ]);
        
        $response = new Response([
            'response_text'      => $validated['response_body'],
            'responder_id'       => $user->id,
            'is_public'          => true, 
            'status_at_response' => $validated['status'],
        ]);
        
        $complaint->responses()->save($response);

        $complaint->update([
            'status'   => $validated['status'],
            'priority' => $validated['priority'],
        ]);

        return redirect()->route('show', $complaint->id)
                         ->with('success', 'Response submitted. Case updated to ' . $validated['status'] . ' with ' . $validated['priority'] . ' priority.');
    }

    
    public function destroy(Complaint $complaint)
    {
        if (!Auth::user()->hasRole('System Administrator')) {
            abort(403, 'Only admins can delete complaints.');
        }

        $complaint->delete();
        return redirect()->route('index')->with('success', 'Complaint deleted successfully.');
    }

    
    protected function isUserResponsibleForRecipient($user, $type, $id): bool
{
    
    return match($type) {
        'College'    => $user->college_id == $id,
        'Department' => $user->department_id == $id,
        'Directory'  => $user->directory_id == $id,
        default      => false,
    };
}

    // --- AJAX Methods ---
    public function getDepartmentsByCollege(Request $request)
    {
        $departments = Department::where('college_id', $request->college_id)->get(['id', 'name_en']);
        return response()->json($departments);
    }

    public function getDirectoriesByRecipientType()
    {
        return response()->json(Directory::all(['id', 'name_en']));
    }
}