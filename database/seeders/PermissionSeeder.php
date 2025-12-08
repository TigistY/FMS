<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    
    public function run(): void
    {
        $permissions = [
    
            ['name' => 'view-feedback', 'display_name' => 'ቅሬታ/ምላሽ መመልከት', 'guard_name' => 'web'],
            ['name' => 'respond-feedback', 'display_name' => 'ቅሬታ/ምላሽ ምላሽ መስጠት', 'guard_name' => 'web'],
            
            ['name' => 'view-complaints', 'display_name' => 'ጥፋት መመልከት', 'guard_name' => 'web'],
            ['name' => 'respond-complaints', 'display_name' => 'ጥፋት ምላሽ መስጠት', 'guard_name' => 'web'],
            
            ['name' => 'manage-users', 'display_name' => 'ተጠቃሚዎችን ማስተዳደር', 'guard_name' => 'web'],
            ['name' => 'manage-units', 'display_name' => 'ዩኒቶችን ማስተዳደር', 'guard_name' => 'web'],
        ];

        foreach ($permissions as $permission) {
           
            Permission::firstOrCreate(['name' => $permission['name']], $permission);
        }
    }
}