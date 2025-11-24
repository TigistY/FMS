<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    
        Role::create(['name' => 'System Administrator', 'description' => 'Full access to the system, including user and unit management.']);
        Role::create(['name' => 'Feedback Responder', 'description' => 'Responsible for handling and responding to Feedback submissions directed to their unit.']);
        Role::create(['name' => 'Complaint Receiver', 'description' => 'Responsible for managing and resolving Complaint submissions directed to their unit.']);
    }
}