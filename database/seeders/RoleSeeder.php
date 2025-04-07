<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Add Customer role if it doesn't exist
        Role::create(['name' => 'Customer', 'guard_name' => 'web']);
    }
}