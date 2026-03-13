<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name'     => 'System Admin',
                'username' => 'sysadmin',
                'email'    => 'admin1@gmail.com',
                'password' => Hash::make('systemadmin091302'),
                'role'     => 'admin',
            ]
        );
    }
}