<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Gestionnaire',
            'email' => 'gestionnaire@isiburger.com',
            'password' => Hash::make('password'),
            'role' => 'gestionnaire'
        ]);
    }
} 