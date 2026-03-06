<?php
// database/seeders/PaketCateringSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaketCateringSeeder extends Seeder
{
    public function run(): void
    {
        
        DB::table('paket_catering')->insert([
            'nama_paket' => 'Paket Pernikahan Silver',
            'slug' => 'paket-pernikahan-silver',
            'deskripsi' => 'Paket pernikahan dengan menu prasmanan 5 menu',
            'event_id' => 1,
            'harga_per_orang' => 85000,
            'min_pax' => 50,
            'max_pax' => 200,
            'menu_items' => json_encode([1, 2, 3, 4, 5]),
            'includes' => json_encode([
                'Nasi Putih',
                'Ayam Goreng',
                'Sambal Goreng Kentang',
                'Pudding',
                'Es Teh Manis',
                'Peralatan makan'
            ]),
            'gambar_utama' => null,
            'is_popular' => true,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('paket_catering')->insert([
            'nama_paket' => 'Paket Pernikahan Gold',
            'slug' => 'paket-pernikahan-gold',
            'deskripsi' => 'Paket pernikahan premium dengan menu lengkap',
            'event_id' => 1,
            'harga_per_orang' => 150000,
            'min_pax' => 100,
            'max_pax' => 500,
            'menu_items' => json_encode([1, 2, 3, 4, 5, 6, 7, 8]),
            'includes' => json_encode([
                'Nasi Putih',
                'Rendang Daging',
                'Sate Lilit',
                'Sambal Goreng Kentang',
                'Pudding Cokelat',
                'Klepon',
                'Es Cendol',
                'Pramusaji'
            ]),
            'gambar_utama' => null,
            'is_popular' => true,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('paket_catering')->insert([
            'nama_paket' => 'Paket Rapat Ekonomis',
            'slug' => 'paket-rapat-ekonomis',
            'deskripsi' => 'Nasi box hemat untuk rapat kantor',
            'event_id' => 2,
            'harga_per_orang' => 35000,
            'min_pax' => 10,
            'max_pax' => 100,
            'menu_items' => json_encode([4, 5, 6]),
            'includes' => json_encode([
                'Nasi Putih',
                'Ayam Goreng',
                'Sambal',
                'Lalapan',
                'Kerupuk',
                'Air Mineral'
            ]),
            'gambar_utama' => null,
            'is_popular' => true,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('paket_catering')->insert([
            'nama_paket' => 'Paket Ulang Tahun Anak',
            'slug' => 'paket-ulang-tahun-anak',
            'deskripsi' => 'Paket spesial untuk ulang tahun anak-anak',
            'event_id' => 3,
            'harga_per_orang' => 45000,
            'min_pax' => 20,
            'max_pax' => 100,
            'menu_items' => json_encode([4, 7, 8]),
            'includes' => json_encode([
                'Nasi Goreng',
                'Sosis Goreng',
                'Kentang Goreng',
                'Pudding Cokelat',
                'Es Teh Manis',
                'Goodie bag'
            ]),
            'gambar_utama' => null,
            'is_popular' => true,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('paket_catering')->insert([
            'nama_paket' => 'Paket Arisan Bulanan',
            'slug' => 'paket-arisan-bulanan',
            'deskripsi' => 'Paket hemat untuk arisan ibu-ibu',
            'event_id' => 4,
            'harga_per_orang' => 35000,
            'min_pax' => 15,
            'max_pax' => 50,
            'menu_items' => json_encode([2, 4, 8]),
            'includes' => json_encode([
                'Nasi Putih',
                'Pastel Tutup',
                'Ayam Goreng',
                'Klepon',
                'Es Teh Manis'
            ]),
            'gambar_utama' => null,
            'is_popular' => true,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}