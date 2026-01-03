<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// ሞዴሎቹን እዚህ ጋር መጥራት እንዳትረሳ
use App\Models\Complaint;
use App\Models\Feedback;
use App\Models\User;
use App\Models\Guest;

class HomeController extends Controller
{
    public function welcomepage() {
        return view('welcome');
    }

public function dashBoard()
{
    $user = auth()->user();
    
    // 1. ለአጠቃላይ ዳሽቦርድ ካርዶች (ያሉህ ኮዶች)
    $totalComplaints = Complaint::count();
    $totalFeedback = Feedback::count();
    $totalUsers = User::count() + Guest::count();
    $totalAnonymousRequests = Complaint::where('is_anonymous', true)->count() + Feedback::where('is_anonymous', true)->count();

    // 2. ለኖቲፊኬሽን ባጅ (Badges) የሚሆኑ ቁጥሮች
    if ($user->hasRole('System Administrator')) {
        // አድሚን በሲስተሙ ያሉትን በሙሉ ያያል
        $pendingComplaints = Complaint::where('status', 'Pending')->count();
        $newFeedback = Feedback::doesntHave('responses')->count();
    } elseif ($user->hasRole('Unit Responder')) {
        // Responder የራሱን ዩኒት ብቻ ያያል
        $pendingComplaints = Complaint::where('recipient_type', $user->managed_unit_type)
            ->where('recipient_id', $user->managed_unit_id)
            ->where('status', 'Pending')->count();
            
        $newFeedback = Feedback::where('recipient_type', $user->managed_unit_type)
            ->where('recipient_id', $user->managed_unit_id)
            ->doesntHave('responses')->count();
    } else {
        $pendingComplaints = 0;
        $newFeedback = 0;
    }

    return view('dashboard', compact(
        'totalComplaints', 'totalFeedback', 'totalUsers', 'totalAnonymousRequests',
        'pendingComplaints', 'newFeedback'
    ));
}
    public function homesto() {
        return view('logins.home');
    }

    public function help() {
        return view('logins.helpcenter');
    }
}