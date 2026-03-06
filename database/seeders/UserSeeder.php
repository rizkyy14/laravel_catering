<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        
        DB::table('users')->insert([
            'nama' => 'Admin Lumina',
            'email' => 'admin@lumina.com',
            'password' => Hash::make('password'),
            'no_telepon' => '081234567890',
            'alamat' => null,
            'kota' => null,
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('users')->insert([
            'nama' => 'Staff Catering',
            'email' => 'staff@lumina.com',
            'password' => Hash::make('password'),
            'no_telepon' => '081234567891',
            'alamat' => null,
            'kota' => null,
            'role' => 'staff',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('users')->insert([
            'nama' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'no_telepon' => '081234567892',
            'alamat' => 'Jl. Sudirman No. 123',
            'kota' => 'Jakarta',
            'role' => 'pelanggan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('users')->insert([
            'nama' => 'Siti Rahayu',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password'),
            'no_telepon' => '081234567893',
            'alamat' => 'Jl. Gatot Subroto No. 45',
            'kota' => 'Bandung',
            'role' => 'pelanggan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('users')->insert([
            'nama' => 'Ahmad Hidayat',
            'email' => 'ahmad@gmail.com',
            'password' => Hash::make('password'),
            'no_telepon' => '081234567894',
            'alamat' => 'Jl. Diponegoro No. 67',
            'kota' => 'Surabaya',
            'role' => 'pelanggan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}