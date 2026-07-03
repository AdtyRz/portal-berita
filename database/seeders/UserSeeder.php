<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@school.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'status' => true,
        ]);
        $superAdmin->assignRole('super-admin');

        // Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@school.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'status' => true,
        ]);
        $admin->assignRole('admin');
    }
}
