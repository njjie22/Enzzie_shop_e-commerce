<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        // SUPER ADMIN

        if (!User::where('is_super_admin', true)->exists()) {
            User::create([
                'name' => 'superadmin',
                'email' => 'admin@domain.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_super_admin' => true,
            ]);
        }

  
        // USER BIASA
         
        if (!User::where('role', 'user')->exists()) {
            User::create([
                'name' => 'user1',
                'email' => 'user1@domain.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'is_super_admin' => false,
            ]);
        }
    }
}