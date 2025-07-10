<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Admin Role
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // Create User Role
        $userRole = Role::firstOrCreate(['name' => 'User']);

        // Example of creating a permission and assigning it to admin (optional for now)
        // $manageUsersPermission = Permission::firstOrCreate(['name' => 'manage users']);
        // $adminRole->givePermissionTo($manageUsersPermission);
    }
}
