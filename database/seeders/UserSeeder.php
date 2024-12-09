<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        $roles = Role::pluck('name')->toArray();

        // Create specific users for defined roles
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('Super Administrator');

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('Admin');

        User::create([
            'name' => 'Editor',
            'email' => 'editor@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('Editor');

        User::create([
            'name' => 'Read-Only User',
            'email' => 'readonly@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('Read-Only');

        // Generate 10 fake users and assign random roles
        User::factory(10)->create()->each(function ($user) use ($roles) {
            $user->assignRole($roles[array_rand($roles)]);
        });
    }
}