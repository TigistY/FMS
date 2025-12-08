<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Unit; 
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
            UnitSeeder::class, 
        ]);

        
        // (Permission)
        Permission::firstOrCreate(['name' => 'manage-units']);
        
        
        // We use SpatieRole here (the alias)
        $adminRole = SpatieRole::firstOrCreate(['name' => 'System Administrator']);
        $responderRole = SpatieRole::firstOrCreate(['name' => 'Unit Responder']);
        $generalRole = SpatieRole::firstOrCreate(['name' => 'General User']);
        
        // assigne permision
        
        // 1. ለ System Administrator ሚና
        // Administrator ሁሉንም አቅሞች (all permissions) ከ 'RoleSeeder' ስለሚወስድ ይህ መስመር አያስፈልግም
        // ነገር ግን ለምሳሌ ያህል 'manage-units'ን እንዲያገኝ አድርገነዋል
        $adminRole->givePermissionTo('manage-units'); 

        // 2. ለ Unit Responder ሚና አዲስ ፈቃዶችን እንሰጣለን
        // ፈቃዶች አሁን RoleSeeder ውስጥ ተመድበዋል, ነገር ግን ይህንን መስመር ለተሟላነት እንተወዋለን
        $responderRole->givePermissionTo(['view-complaints', 'view-feedback']);


        $adminUnit = Unit::first(); 

        // (email: admintg@gmail.com, pass: tg1234tg)
        $adminUser = User::firstOrCreate(
            ['email' => 'admintg@gmail.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('tg1234tg'), 
                'unit_id' => $adminUnit ? $adminUnit->id : null, 
                'email_verified_at' => now(), 
            ]
        );

        
        if ($adminUser && $adminRole) {
            $adminUser->assignRole($adminRole); 
            Log::info("Admin user '{$adminUser->email}' seeded and assigned '{$adminRole->name}' role via Spatie.");
        } else {
             Log::error("Failed to assign Admin Role: User or Spatie Role not found.");
        }

        // ምሳሌ: የ Responder ተጠቃሚን እንፍጠርና ሚና እንስጥ
        // (email: responder@gmail.com, pass: tg1234tg)
        $responderUser = User::firstOrCreate(
            ['email' => 'responder@gmail.com'],
            [
                'name' => 'Unit Responder',
                'password' => Hash::make('tg1234tg'), 
                'unit_id' => $adminUnit ? $adminUnit->id : null, 
                'email_verified_at' => now(), 
            ]
        );

        if ($responderUser && $responderRole) {
            $responderUser->assignRole($responderRole); 
            Log::info("Responder user '{$responderUser->email}' seeded and assigned '{$responderRole->name}' role via Spatie.");
        }
    }
}