<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Guest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    
    public function feedbackform(){
        return view('fms.feedback');
    }

    public function feedback(Request $request)
    {
        // 1. የማረጋገጫ ህጎች (Validation Rules)
        // ቪዲኤሽን ካልተሳካ, Laravel በራስ-ሰር ይመልሳል (redirects back with errors)
        $validatedData = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string|min:10', 
            'is_anonymous' => 'nullable', // ቼክቦክስ ስለሆነ nullable ብቻ ይበቃል
            
            // Guest Email ልዩ (unique) መሆን አለበት
            'guest_email' => 'nullable|email|max:255|unique:guests,email', 
            'guest_name' => 'nullable|string|max:255',
            'guest_type' => 'nullable|in:Student,Teacher,Employee,Other',
        ]);
        
        // 2. ተለዋዋጮችን ያስጀምሩ
        // $request->has('is_anonymous') ቼክቦክሱ መላኩን ያረጋግጣል (checked = true, unchecked = false)
        $isAnonymous = $request->has('is_anonymous');
        $guestId = null; 
        $userId = null; 

        // 3. ማንነትን መወሰን እና ID መመደብ (ያለ try/catch)
        if (!$isAnonymous) {
            // ስም-አልባ አይደለም
            if (Auth::check()) {
                // ሀ. የተመዘገበ ተጠቃሚ ከሆነ
                $userId = Auth::id();
            } elseif ($request->filled('guest_email')) {
                // ለ. ያልተመዘገበ እንግዳ (Guest) ከሆነ
                
                // Guest ሠንጠረዥ ውስጥ ያስገቡ ወይም ነባሩን ያግኙ (firstOrCreate)
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
        
        // 4. ውሂብ ወደ Feedback ሠንጠረዥ ያስገቡ (ያለ try/catch)

        $feedback = Feedback::create([
            'subject' => $validatedData['subject'],
            'unit_id' => $validatedData['unit_id'],
            'body' => $validatedData['body'],
            // የ is_anonymous ቼክቦክስ ዋጋ ወደ boolean (true/false) ለመቀየር $request->has() በቂ ነው።
            'is_anonymous' => $isAnonymous,
            'user_id' => $userId,   
            'guest_id' => $guestId, 
        ]);

        // በተሳካ ሁኔታ ሲገባ ወደ ሎግ ይመዘግቡ እና መልዕክት ይላኩ 
        //ለሲስተሙ ለመንከባከብ (Maintainability)፣ ለደህንነት (Accountability) እና ለማረጋገጫ (Verifiability) በጣም አስፈላጊ ነው።
        $submitted_as = $userId ? 'Registered User (ID: ' . $userId . ')' : 
                        ($guestId ? 'Guest (ID: ' . $guestId . ')' : 'Anonymous');

        Log::info("Feedback Submitted Successfully.", [
            'feedback_id' => $feedback->id,//በኋላ ላይ በዚህ ግብረመልስ ላይ ችግር ቢፈጠር፣ (ለምሳሌ፣ ሪፖርት ሲያመነጭ)፣ ሎጉን በመመልከት በትክክል የየትኛው ሪከርድ እንደሆነ በቀጥታ ማወቅ ይችላሉ።
            'Submitted_As' => $submitted_as,//ግብረመልሱ የመጣው ከተመዘገበ ሰው ነው ወይስ ከእንግዳ ወይም ደግሞ ስም-አልባ መሆኑን በግልጽ ይመዘግባል፣ ይህም የኦዲት (Audit) ፍላጎቶችን ለማሟላት ይረዳል።
            'is_anonymous' => $isAnonymous,
        ]);
        
        // በተሳካ ሁኔታ ሲገባ መልሰው ወደ ቅጹ በመመለስ የስኬት መልዕክት ያስተላልፉ
        return redirect()->back()->with('success', 'Your feedback has been successfully submitted as a ' . $submitted_as . '.');
    }
}