<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Complaint;
use App\Models\Feedback;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // MorphMap ለሁለቱም (Recipient እና Respondable) አስፈላጊ ነው
        Relation::morphMap([
            'College'    => \App\Models\College::class,
            'Department' => \App\Models\Department::class,
            'Directory'  => \App\Models\Directory::class,
            'Complaint'  => \App\Models\Complaint::class,
            'Feedback'   => \App\Models\Feedback::class, 
        ]);

        View::composer('*', function ($view) {
    if (Auth::check()) {
        $user = Auth::user();
        
        if ($user->hasRole('System Administrator')) {
            // አድሚን ሁሉንም ያያል
            $pendingCount = Complaint::whereIn('status', ['Pending', 'Forwarded'])->count();
            $newFeedCount = Feedback::whereIn('status', ['New', 'Forwarded'])->count();
        } else {
            $unitType = null;
            $unitId = null;

            if ($user->college_id) { $unitType = 'College'; $unitId = $user->college_id; }
            elseif ($user->department_id) { $unitType = 'Department'; $unitId = $user->department_id; }
            elseif ($user->directory_id) { $unitType = 'Directory'; $unitId = $user->directory_id; }

            if ($unitType && $unitId) {
                // እዚህ ጋር በ 'whereIn' ስታተሱ Pending ወይም Forwarded የሆኑትን እንዲቆጥር ተደረገ
                $pendingCount = Complaint::where('recipient_type', $unitType)
                    ->where('recipient_id', $unitId)
                    ->whereIn('status', ['Pending', 'Forwarded'])->count();
                
                $newFeedCount = Feedback::where('recipient_type', $unitType)
                    ->where('recipient_id', $unitId)
                    ->whereIn('status', ['New', 'Forwarded'])->count();
            } else {
                $pendingCount = 0; $newFeedCount = 0;
            }
        }
        $view->with('globalNotificationCount', $pendingCount + $newFeedCount);
    } else {
        $view->with('globalNotificationCount', 0);
    }
});
    }
}