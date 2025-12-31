<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// 1. ይህንን መስመር መጨመር እንዳትረሳ
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            'College'    => \App\Models\College::class,
            'Department' => \App\Models\Department::class,
            'Directory'  => \App\Models\Directory::class,
        ]);

        Relation::morphMap([
        'Complaint' => \App\Models\Complaint::class,
        'Feedback'  => \App\Models\Feedback::class, 
    ]);
    }
}