<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        
    ];

/*
    public function boot(): void
    {
        Gate::define('manage-units', function (User $user) {
            
            return $user->roles()
                        ->where('name', 'System Administrator')
                        ->exists();
        });
    }
    */
}