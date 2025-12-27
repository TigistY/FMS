<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role as SpatieRole; 
use Spatie\Permission\Models\Permission;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            
        ]);
        
        // Roles are already defined and synced in RoleSeeder
        $adminRole = SpatieRole::where('name', 'System Administrator')->first();
        $responderRole = SpatieRole::where('name', 'Unit Responder')->first();
        
        // 1. Create System Admin User
        $adminUser = User::firstOrCreate(
            ['email' => 'admintg@gmail.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('tg1234tg'), 
                'email_verified_at' => now(), 
            ]
        );

        if ($adminUser && $adminRole) {
            $adminUser->assignRole($adminRole); 
            Log::info("Admin user '{$adminUser->email}' seeded and assigned '{$adminRole->name}' role.");
        } 

        // 2. Create Unit Responder User
        $responderUser = User::firstOrCreate(
            ['email' => 'responder@gmail.com'],
            [
                'name' => 'Unit Responder',
                'password' => Hash::make('tg1234tg'), 
                'email_verified_at' => now(), 
            ]
        );

        if ($responderUser && $responderRole) {
            $responderUser->assignRole($responderRole); 
            Log::info("Responder user '{$responderUser->email}' seeded and assigned '{$responderRole->name}' role.");
        }
    }
}