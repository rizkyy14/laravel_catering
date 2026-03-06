<?php
// database/seeders/KategoriMenuSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriMenuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori_menu')->truncate();
        
        DB::table('kategori_menu')->insert([
            'nama_kategori' => 'Makanan Pembuka',
            'slug' => 'makanan-pembuka',
            'deskripsi' => 'Hidangan pembuka yang menggugah selera',
            'icon' => '🥗',
            'gambar' => null,
            'urutan' => 1,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('kategori_menu')->insert([
            'nama_kategori' => 'Makanan Utama',
            'slug' => 'makanan-utama',
            'deskripsi' => 'Hidangan utama yang mengenyangkan',
            'icon' => '🍛',
            'gambar' => null,
            'urutan' => 2,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('kategori_menu')->insert([
            'nama_kategori' => 'Makanan Penutup',
            'slug' => 'makanan-penutup',
            'deskripsi' => 'Hidangan penutup yang manis',
            'icon' => '🍰',
            'gambar' => null,
            'urutan' => 3,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('kategori_menu')->insert([
            'nama_kategori' => 'Minuman',
            'slug' => 'minuman',
            'deskripsi' => 'Berbagai pilihan minuman segar',
            'icon' => '🥤',
            'gambar' => null,
            'urutan' => 4,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}