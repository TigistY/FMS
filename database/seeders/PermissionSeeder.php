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
        // 1. የ Spatie ፐርሚሽን ካሽን ማጽዳት
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Foreign key ቼክ ለጊዜው እንዲቆም ማድረግ
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 3. ሰንጠረዦቹን ማጽዳት
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('permissions')->truncate();

        // 4. Foreign key ቼክ እንዲመለስ ማድረግ
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 5. መሰረታዊ ፐርሚሽኖች
        $permissions = [
            ['name' => 'view-feedback', 'display_name' => 'ግብረመልስ መመልከት', 'guard_name' => 'web'],
            ['name' => 'respond-feedback', 'display_name' => 'ግብረመልስ ምላሽ መስጠት', 'guard_name' => 'web'],
            ['name' => 'view-complaints', 'display_name' => 'ቅሬታ መመልከት', 'guard_name' => 'web'],
            ['name' => 'respond-complaints', 'display_name' => 'ቅሬታ ምላሽ መስጠት', 'guard_name' => 'web'],
            ['name' => 'role-management', 'display_name' => 'ሮሎችን ማስተዳደር', 'guard_name' => 'web'],
            ['name' => 'view-unit-reports', 'display_name' => 'የክፍሎችን ሪፖርት መመልከት', 'guard_name' => 'web'],
        ];

        // 6. ለተለያዩ ክፍሎች የሚሆኑ ፐርሚሽኖች
        $units_and_users = [
            'users' => 'ተጠቃሚዎች',
            'colleges' => 'ኮሌጆች',
            'departments' => 'ዲፓርትመንቶች',
            'directories' => 'ዳይሬክቶሬቶች'
        ];
        
        $unit_actions = ['view', 'create', 'edit', 'delete'];

        $action_amharic_map = [
            'view' => 'መመልከት',
            'create' => 'መፍጠር',
            'edit' => 'ማስተካከል',
            'delete' => 'መሰረዝ',
        ];

        foreach ($units_and_users as $unit_en => $unit_am) {
            foreach ($unit_actions as $action_en) {
                $action_am = $action_amharic_map[$action_en];
                $name = $action_en . '-' . $unit_en; 
                $display_name = $unit_am . ' ' . $action_am; 
                
                $permissions[] = [
                    'name' => $name,
                    'display_name' => $display_name,
                    'guard_name' => 'web'
                ];
            }
        }

        // 7. በመጨረሻም ፐርሚሽኖችን መፍጠር
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}