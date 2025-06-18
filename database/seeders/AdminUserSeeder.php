<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@awbit.test', // Ganti dengan email admin Anda
            'password' => Hash::make('password'), // Ganti dengan password yang aman
            'role_id' => 1, // ID 1 untuk 'admin'
            'status' => 'active',
        ]);
    }
}