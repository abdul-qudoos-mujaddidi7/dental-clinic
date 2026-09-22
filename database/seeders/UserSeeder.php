<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            [
                User::COLUMN_EMAIL => 'admin@gmail.com',
            ],
            [
                User::COLUMN_FIRST_NAME => 'Admin',
                User::COLUMN_LAST_NAME => 'User',
                User::COLUMN_PHONE => '0700000000',
                User::COLUMN_PASSWORD => Hash::make('password123'),
                User::COLUMN_STATUS => true,
                User::COLUMN_PROFILE_PICTURE => null,
            ]
        );

        $user->assignRole('Admin');
    }
}