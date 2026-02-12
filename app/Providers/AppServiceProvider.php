<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Complaint;
use App\Models\Feedback;
use App\Models\Response;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // MorphMap - የሞዴል ትስስር ስሞች
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
                $pendingCount = 0;
                $newFeedCount = 0;
                $userResponseCount = 0;

                // 1. ለSystem Administrator
                if ($user->hasRole('System Administrator')) {
                    $pendingCount = 0; 
                    $newFeedCount = 0;
                } 
                // 2. ለክፍል ተወካዮች (Unit Responders)
                elseif ($user->hasRole('Unit Responder')) {
                    $unitType = null;
                    $unitId = null;

                    if ($user->college_id) { $unitType = 'College'; $unitId = $user->college_id; }
                    elseif ($user->department_id) { $unitType = 'Department'; $unitId = $user->department_id; }
                    elseif ($user->directory_id) { $unitType = 'Directory'; $unitId = $user->directory_id; }

                    if ($unitType && $unitId) {
                        $pendingCount = Complaint::where('recipient_type', $unitType)
                            ->where('recipient_id', $unitId)
                            ->whereIn('status', ['Pending', 'Forwarded'])->count();
                        
                        $newFeedCount = Feedback::where('recipient_type', $unitType)
                            ->where('recipient_id', $unitId)
                            ->whereIn('status', ['New', 'Forwarded'])->count();
                    }
                } 
                // 3. ለተራ ተጠቃሚ (Normal User)
                else {
                    $userResponseCount = Response::where('is_seen', false)
                        ->where('responder_id', '!=', $user->id)
                        ->where(function ($query) use ($user) {
                            // እዚህ ጋር በክላስ ፋንታ በ MorphMap ስማቸው ተክተናል
                            $query->whereHasMorph('respondable', ['Complaint'], function ($q) use ($user) {
                                $q->where('user_id', $user->id);
                            })
                            ->orWhereHasMorph('respondable', ['Feedback'], function ($q) use ($user) {
                                $q->where('user_id', $user->id);
                            });
                        })
                        ->count();
                }

                $view->with('globalNotificationCount', $pendingCount + $newFeedCount + $userResponseCount);
            } else {
                $view->with('globalNotificationCount', 0);
            }
        });
    }
}