<?php
// database/seeders/PermissionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        Permission::findOrCreate('manage user');
        Permission::findOrCreate('manage roles&permission');


        // Create role
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->givePermissionTo(['manage user', 'manage roles&permission']);

        // Assign role to first user
        $user = User::first();
        if ($user) {
            $user->assignRole('Admin');
        }
    }
}
