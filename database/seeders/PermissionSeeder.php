<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // መሰረታዊ ፐርሚሽኖች በግሩፕ ተከፋፍለዋል
        $permissions = [
            ['name' => 'view-feedback', 'display_name' => 'ግብረመልስ መመልከት', 'group' => 'Feedback', 'guard_name' => 'web'],
            ['name' => 'respond-feedback', 'display_name' => 'ግብረመልስ ምላሽ መስጠት', 'group' => 'Feedback', 'guard_name' => 'web'],
            ['name' => 'view-complaints', 'display_name' => 'ቅሬታ መመልከት', 'group' => 'Complaints', 'guard_name' => 'web'],
            ['name' => 'respond-complaints', 'display_name' => 'ቅሬታ ምላሽ መስጠት', 'group' => 'Complaints', 'guard_name' => 'web'],
            ['name' => 'role-management', 'display_name' => 'ሮሎችን ማስተዳደር', 'group' => 'System', 'guard_name' => 'web'],
            ['name' => 'view-unit-reports', 'display_name' => 'የክፍሎችን ሪፖርት መመልከት', 'group' => 'Reports', 'guard_name' => 'web'],
        ];

        $units = [
            'users' => 'ተጠቃሚዎች',
            'colleges' => 'ኮሌጆች',
            'departments' => 'ዲፓርትመንቶች',
            'directories' => 'ዳይሬክቶሬቶች'
        ];
        
        $actions = ['view' => 'መመልከት', 'create' => 'መፍጠር', 'edit' => 'ማስተካከል', 'delete' => 'መሰረዝ'];

        foreach ($units as $unit_en => $unit_am) {
            foreach ($actions as $action_en => $action_am) {
                $permissions[] = [
                    'name' => $action_en . '-' . $unit_en,
                    'display_name' => $unit_am . ' ' . $action_am,
                    'group' => ucfirst($unit_en), // የግሩፕ ስሙን እንደ ዩኒቱ ስም ሰጠነው
                    'guard_name' => 'web'
                ];
            }
        }

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}