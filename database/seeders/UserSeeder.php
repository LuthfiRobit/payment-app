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
                'password' => '$2y$10$CYCgj76/fJ7SP68febUhv.PplwdqhUMCMBhBLCJ/pe3zvK1ZxTA66',
                'role' => 'developer',
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
