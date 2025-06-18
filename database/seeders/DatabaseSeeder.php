<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder lain dalam urutan yang benar.
        // Laravel akan menjalankan RoleSeeder terlebih dahulu, lalu AdminUserSeeder.
        $this->call([
            RoleSeeder::class,      // WAJIB PERTAMA, untuk mengisi tabel roles
            AdminUserSeeder::class, // Baru panggil ini setelah roles ada
        ]);
    }
}