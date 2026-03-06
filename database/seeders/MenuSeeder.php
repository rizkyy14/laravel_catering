<?php
// database/seeders/MenuSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // DB::table('menu')->truncate();
        
        // Makanan Pembuka
        DB::table('menu')->insert([
            'nama_menu' => 'Risoles Mayo',
            'slug' => 'risoles-mayo',
            'deskripsi' => 'Risoles isi mayones, telur, dan sayuran segar',
            'harga' => 15000,
            'kategori' => 'pembuka',
            'emoji' => '🥟',
            'gambar' => null,
            'bahan_bahan' => json_encode(['Kulit risoles', 'Mayones', 'Telur', 'Wortel', 'Kentang']),
            'informasi_diet' => json_encode(['non_halal' => false, 'vegetarian' => false]),
            'is_special' => false,
            'is_active' => true,
            'urutan' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('menu')->insert([
            'nama_menu' => 'Pastel Tutup',
            'slug' => 'pastel-tutup',
            'deskripsi' => 'Pastel tutup khas Betawi dengan isian daging ayam',
            'harga' => 18000,
            'kategori' => 'pembuka',
            'emoji' => '🥧',
            'gambar' => null,
            'bahan_bahan' => json_encode(['Kulit pastel', 'Daging ayam', 'Kentang', 'Wortel', 'Bumbu rempah']),
            'informasi_diet' => json_encode(['non_halal' => false, 'vegetarian' => false]),
            'is_special' => false,
            'is_active' => true,
            'urutan' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('menu')->insert([
            'nama_menu' => 'Lumpia Semarang',
            'slug' => 'lumpia-semarang',
            'deskripsi' => 'Lumpia khas Semarang dengan isian rebung dan ayam',
            'harga' => 20000,
            'kategori' => 'pembuka',
            'emoji' => '🥠',
            'gambar' => null,
            'bahan_bahan' => json_encode(['Kulit lumpia', 'Rebung', 'Ayam', 'Telur', 'Bawang putih']),
            'informasi_diet' => json_encode(['non_halal' => false, 'vegetarian' => false]),
            'is_special' => false,
            'is_active' => true,
            'urutan' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Makanan Utama
        DB::table('menu')->insert([
            'nama_menu' => 'Nasi Tumpeng Mini',
            'slug' => 'nasi-tumpeng-mini',
            'deskripsi' => 'Nasi tumpeng mini dengan lauk pauk lengkap',
            'harga' => 35000,
            'kategori' => 'utama',
            'emoji' => '🍚',
            'gambar' => null,
            'bahan_bahan' => json_encode(['Nasi kuning', 'Ayam goreng', 'Telur balado', 'Tempe orek', 'Sambal goreng kentang']),
            'informasi_diet' => json_encode(['non_halal' => false, 'vegetarian' => false]),
            'is_special' => true,
            'is_active' => true,
            'urutan' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('menu')->insert([
            'nama_menu' => 'Sate Lilit Ayam',
            'slug' => 'sate-lilit-ayam',
            'deskripsi' => 'Sate lilit khas Bali dengan daging ayam cincang',
            'harga' => 28000,
            'kategori' => 'utama',
            'emoji' => '🍢',
            'gambar' => null,
            'bahan_bahan' => json_encode(['Daging ayam', 'Kelapa parut', 'Bumbu base genep', 'Batang serai']),
            'informasi_diet' => json_encode(['non_halal' => false, 'vegetarian' => false]),
            'is_special' => true,
            'is_active' => true,
            'urutan' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('menu')->insert([
            'nama_menu' => 'Rendang Daging',
            'slug' => 'rendang-daging',
            'deskripsi' => 'Rendang daging sapi khas Padang yang empuk',
            'harga' => 40000,
            'kategori' => 'utama',
            'emoji' => '🥩',
            'gambar' => null,
            'bahan_bahan' => json_encode(['Daging sapi', 'Santan', 'Bumbu rendang', 'Serai', 'Daun jeruk']),
            'informasi_diet' => json_encode(['non_halal' => false, 'vegetarian' => false]),
            'is_special' => true,
            'is_active' => true,
            'urutan' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Makanan Penutup
        DB::table('menu')->insert([
            'nama_menu' => 'Pudding Cokelat',
            'slug' => 'pudding-cokelat',
            'deskripsi' => 'Pudding cokelat dengan saus vanilla',
            'harga' => 12000,
            'kategori' => 'penutup',
            'emoji' => '🍮',
            'gambar' => null,
            'bahan_bahan' => json_encode(['Cokelat', 'Susu', 'Gula', 'Agar-agar', 'Vanilla']),
            'informasi_diet' => json_encode(['non_halal' => false, 'vegetarian' => true]),
            'is_special' => false,
            'is_active' => true,
            'urutan' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('menu')->insert([
            'nama_menu' => 'Klepon',
            'slug' => 'klepon',
            'deskripsi' => 'Kue tradisional dengan isi gula merah',
            'harga' => 10000,
            'kategori' => 'penutup',
            'emoji' => '🍡',
            'gambar' => null,
            'bahan_bahan' => json_encode(['Tepung ketan', 'Gula merah', 'Kelapa parut', 'Daun pandan']),
            'informasi_diet' => json_encode(['non_halal' => false, 'vegetarian' => true]),
            'is_special' => false,
            'is_active' => true,
            'urutan' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Minuman
        DB::table('menu')->insert([
            'nama_menu' => 'Es Teh Tarik',
            'slug' => 'es-teh-tarik',
            'deskripsi' => 'Es teh tarik dengan rasa creamy',
            'harga' => 8000,
            'kategori' => 'minuman',
            'emoji' => '🥛',
            'gambar' => null,
            'bahan_bahan' => json_encode(['Teh', 'Susu', 'Gula', 'Es batu']),
            'informasi_diet' => json_encode(['non_halal' => false, 'vegetarian' => true]),
            'is_special' => false,
            'is_active' => true,
            'urutan' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('menu')->insert([
            'nama_menu' => 'Es Cendol',
            'slug' => 'es-cendol',
            'deskripsi' => 'Es cendol dengan santan dan gula merah',
            'harga' => 12000,
            'kategori' => 'minuman',
            'emoji' => '🥤',
            'gambar' => null,
            'bahan_bahan' => json_encode(['Cendol', 'Santan', 'Gula merah', 'Es batu']),
            'informasi_diet' => json_encode(['non_halal' => false, 'vegetarian' => true]),
            'is_special' => false,
            'is_active' => true,
            'urutan' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}