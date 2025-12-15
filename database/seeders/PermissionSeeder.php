<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Feedback Permissions
            ['name' => 'view-feedback', 'display_name' => 'ግብረመልስ መመልከት', 'guard_name' => 'web'],
            ['name' => 'respond-feedback', 'display_name' => 'ግብረመልስ ምላሽ መስጠት', 'guard_name' => 'web'],
            
            // Complaint Permissions
            ['name' => 'view-complaints', 'display_name' => 'ቅሬታ መመልከት', 'guard_name' => 'web'],
            ['name' => 'respond-complaints', 'display_name' => 'ቅሬታ ምላሽ መስጠት', 'guard_name' => 'web'],
            
            // Admin/User Management Permissions
            ['name' => 'manage-users', 'display_name' => 'ተጠቃሚዎችን ማስተዳደር', 'guard_name' => 'web'],

            // Unit Management Permissions (New Structure)
            ['name' => 'manage colleges', 'display_name' => 'ኮሌጆችንና ዲፓርትመንቶችን ማስተዳደር', 'guard_name' => 'web'],
            ['name' => 'manage directories', 'display_name' => 'ዳይሬክቶሬቶችን ማስተዳደር', 'guard_name' => 'web'],
            
            // Role Management Permission
            ['name' => 'role-management', 'display_name' => 'ሮሎችን ማስተዳደር', 'guard_name' => 'web'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission['name']], $permission);
        }
    }
}