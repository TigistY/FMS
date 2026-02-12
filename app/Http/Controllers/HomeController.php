<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Feedback;
use App\Models\User;
use App\Models\Guest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function welcomepage() {
        return view('welcome');
    }

    public function dashBoard()
    {
        $user = Auth::user();
        
        $totalComplaints = Complaint::count();
        $totalFeedback = Feedback::count();
        $totalUsers = User::count() + Guest::count();
        $totalAnonymousRequests = Complaint::where('is_anonymous', true)->count() + Feedback::where('is_anonymous', true)->count();

        $sentimentStats = Feedback::select('feedback_type', DB::raw('count(*) as total'))
            ->groupBy('feedback_type')
            ->pluck('total', 'feedback_type')
            ->toArray();

        $userComplaints = Complaint::where('user_id', $user->id)->with(['responses.responder'])->latest()->get();
        $userFeedbacks = Feedback::where('user_id', $user->id)->with(['responses.responder'])->latest()->get();

        $allSubmissions = $userComplaints->concat($userFeedbacks)->sortByDesc('created_at')->take(10);
        
        if ($user->hasRole('System Administrator')) {
            $pendingComplaints = Complaint::where('status', 'Pending')->count();
            $newFeedback = Feedback::where('status', 'Pending')->count();
        } elseif ($user->hasRole('Unit Responder')) {
            $unitId = $user->college_id ?: ($user->department_id ?: $user->directory_id);
            $unitType = $user->college_id ? 'College' : ($user->department_id ? 'Department' : 'Directory');

            $pendingComplaints = Complaint::where('recipient_type', $unitType)->where('recipient_id', $unitId)->where('status', 'Pending')->count();
            $newFeedback = Feedback::where('recipient_type', $unitType)->where('recipient_id', $unitId)->where('status', 'Pending')->count();
        } else {
            $pendingComplaints = 0;
            $newFeedback = 0;
        }

        return view('dashboard', compact('totalComplaints', 'totalFeedback', 'totalUsers', 'totalAnonymousRequests', 'pendingComplaints', 'newFeedback', 'sentimentStats', 'allSubmissions'));
    }

    public function homesto() {
        return view('logins.home');
    }

    public function help() {
        return view('logins.helpcenter');
    }
}