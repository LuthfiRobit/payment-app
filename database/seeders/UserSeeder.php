<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id_user' => Str::uuid(),
                'name' => 'Developer',
                'email' => 'luthfialid@gmail.com',
                'password' => Hash::make('lnh545471'),
                'role' => 'developer',
            ],
            [
                'id_user' => Str::uuid(),
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'role' => 'admin',
            ],
            [
                'id_user' => Str::uuid(),
                'name' => 'Kepsek',
                'email' => 'kepsek@gmail.com',
                'password' => Hash::make('kepsek'),
                'role' => 'kepsek',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
