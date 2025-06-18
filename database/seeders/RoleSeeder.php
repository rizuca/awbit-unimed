<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('roles')->truncate();
        DB::table('roles')->insert([
            ['name' => 'admin'],      // Akan mendapat ID 1
            ['name' => 'dosen'],      // Akan mendapat ID 2
            ['name' => 'mahasiswa'],  // Akan mendapat ID 3
        ]);
        Schema::enableForeignKeyConstraints();
    }
}