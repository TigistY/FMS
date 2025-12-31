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
    // 1. ማንነታቸው እንዳይታወቅ (Anonymous) ሆነው የቀረቡ ቅሬታዎች እና ግብረ-መልሶች
    // በዳታቤዝህ Boolean ስለሆነ 'true' ወይም 1 መጠቀም ትችላለህ
    $anonymousComplaints = Complaint::where('is_anonymous', true)->count();
    $anonymousFeedback = Feedback::where('is_anonymous', true)->count();
    
    // ድምር (ማንነታቸው ያልታወቁ ተጠቃሚዎች ያቀረቡት ጠቅላላ ብዛት)
    $totalAnonymousRequests = $anonymousComplaints + $anonymousFeedback;

    // 2. አጠቃላይ ለዳሽቦርዱ የሚያስፈልጉ ቁጥሮች
    $totalComplaints = Complaint::count();
    $totalFeedback = Feedback::count();

    // 3. የተመዘገቡ ተጠቃሚዎችን እና እንግዶችን መቁጠር
    $registeredUsersCount = User::count();
    $guestCount = Guest::count();

    // 4. ጠቅላላ የሲስተም ተጠቃሚዎች (Registered + Guests) ድምር
    $totalUsers = $registeredUsersCount + $guestCount;

    return view('dashboard', compact(
        'totalComplaints', 
        'totalFeedback', 
        'totalUsers', 
        'totalAnonymousRequests'
    ));
}

    public function homesto() {
        return view('logins.home');
    }

    public function help() {
        return view('logins.helpcenter');
    }
}