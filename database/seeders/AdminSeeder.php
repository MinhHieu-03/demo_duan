<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'ducvandoan299@gmail.com',
            'password' => bcrypt('123'), // Mật khẩu cho admin
            'role' => 'admin',
        ]);
    }
}

