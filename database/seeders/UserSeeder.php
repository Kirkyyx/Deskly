<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'     => 'System Admin',
                'email'    => 'admin@example.com',
                'password' => 'admin123',
                'role'     => 'admin',
            ],
            [
                'name'     => 'Maria Santos (IT Staff #1042)',
                'email'    => 'staff@example.com',
                'password' => 'staff123',
                'role'     => 'staff',
            ],
            [
                'name'     => 'Juan dela Cruz (IT Staff #1087)',
                'email'    => 'tech@example.com',
                'password' => 'password',
                'role'     => 'staff',
            ],
            [
                'name'     => 'Regular User',
                'email'    => 'user@example.com',
                'password' => 'user123',
                'role'     => 'user',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name'     => $userData['name'],
                    'password' => Hash::make($userData['password']),
                    'role'     => strtolower($userData['role']),
                ]
            );
        }
    }
}