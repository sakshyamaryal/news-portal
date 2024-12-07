<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create permissions
        $permissions = [
            'view articles',
            'create articles',
            'edit articles',
            'delete articles',
            'manage users',
            'manage roles',
            'manage category',
            'manage advertisements',
            'manage sidebar',
            'dashboard'
        ];

        // Create each permission
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Read-Only Role
        $readOnlyRole = Role::firstOrCreate(['name' => 'Read-Only']);
        $readOnlyRole->givePermissionTo('view articles');

        // Admin Role
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->givePermissionTo([
            'view articles',
            'create articles',
            'edit articles',
            'delete articles',
            'manage users',
            'dashboard',
            'manage category',
            'manage advertisements',
            'manage sidebar',
        ]);

        // Super Administrator Role
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Administrator']);
        $superAdminRole->givePermissionTo(Permission::all()); 
    }
}
