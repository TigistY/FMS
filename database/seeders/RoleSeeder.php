<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $adminRole = Role::firstOrCreate(['name' => 'System Administrator'], [
            'name' => 'System Administrator',
            'guard_name' => 'web'
        ]);
        
        $unitResponderRole = Role::firstOrCreate(['name' => 'Unit Responder'], [
            'name' => 'Unit Responder',
            'guard_name' => 'web'
        ]);

        $userRole = Role::firstOrCreate(['name' => 'General User'], [
            'name' => 'General User',
            'guard_name' => 'web'
        ]);

    
        
        // to 'System Administrator' assign all permission 
        $allPermissions = Permission::pluck('name')->toArray();
        $adminRole->syncPermissions($allPermissions);

        // 'Unit Responder' permissions: view and respond to feedback and complaints
        $unitResponderPermissions = [
            'view-feedback', 
            'respond-feedback', 
            'view-complaints', 
            'respond-complaints'
        ];
        $unitResponderRole->syncPermissions($unitResponderPermissions);

        // 'Regular User' has no permissions initially
        $userRole->syncPermissions([]);
    }
}