<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // CRUD actions for use in the dynamic loop
        $unit_actions = ['view', 'create', 'edit', 'delete'];

        $permissions = [
            // Feedback Permissions
            ['name' => 'view-feedback', 'display_name' => 'ግብረመልስ መመልከት', 'guard_name' => 'web'],
            ['name' => 'respond-feedback', 'display_name' => 'ግብረመልስ ምላሽ መስጠት', 'guard_name' => 'web'],
            
            // Complaint Permissions
            ['name' => 'view-complaints', 'display_name' => 'ቅሬታ መመልከት', 'guard_name' => 'web'],
            ['name' => 'respond-complaints', 'display_name' => 'ቅሬታ ምላሽ መስጠት', 'guard_name' => 'web'],
            
            // Role Management Permission (Kept as single, broad permission)
            ['name' => 'role-management', 'display_name' => 'ሮሎችን ማስተዳደር', 'guard_name' => 'web'],
        ];

        // =======================================================
        // 💥 Granular CRUD Permissions for ALL Units and Users 💥
        // =======================================================
        $units_and_users = [
            'users' => 'ተጠቃሚዎች',
            'colleges' => 'ኮሌጆች',
            'departments' => 'ዲፓርትመንቶች',
            'directories' => 'ዳይሬክቶሬቶች'
        ];
        
        $action_amharic_map = [
            'view' => 'መመልከት',
            'create' => 'መፍጠር',
            'edit' => 'ማስተካከል',
            'delete' => 'መሰረዝ',
        ];

        foreach ($units_and_users as $unit_en => $unit_am) {
            foreach ($unit_actions as $action_en) {
                
                $action_am = $action_amharic_map[$action_en];
                
                $name = $action_en . ' ' . $unit_en; // Example: 'create users'
                $display_name = $unit_am . ' ' . $action_am; // Example: 'ተጠቃሚዎች መፍጠር'
                
                $permissions[] = [
                    'name' => $name,
                    'display_name' => $display_name,
                    'guard_name' => 'web'
                ];
            }
        }
        // =======================================================

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission['name']], $permission);
        }
    }
}