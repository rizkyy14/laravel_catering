<?php
// database/seeders/EventSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // DB::table('event')->truncate();
        
        DB::table('event')->insert([
            'nama_event' => 'Pernikahan',
            'slug' => 'pernikahan',
            'deskripsi' => 'Paket catering khusus untuk acara pernikahan dengan berbagai pilihan menu prasmanan atau plated service',
            'tipe_event' => 'pernikahan',
            'harga_min_per_orang' => 75000,
            'harga_max_per_orang' => 250000,
            'fitur' => json_encode([
                'Prasmanan atau Plated Service',
                'Dekorasi booth makanan',
                'Staff pramusaji',
                'Sewa peralatan makan',
                'Kue pengantin'
            ]),
            'galeri' => null,
            'gambar_utama' => null,
            'is_active' => true,
            'urutan' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('event')->insert([
            'nama_event' => 'Rapat Kantor',
            'slug' => 'rapat-kantor',
            'deskripsi' => 'Paket catering untuk rapat kantor dengan menu praktis dan higienis',
            'tipe_event' => 'kantor',
            'harga_min_per_orang' => 35000,
            'harga_max_per_orang' => 85000,
            'fitur' => json_encode([
                'Nasi box atau Tumpeng mini',
                'Snack box',
                'Coffee break',
                'Free delivery untuk area tertentu'
            ]),
            'galeri' => null,
            'gambar_utama' => null,
            'is_active' => true,
            'urutan' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('event')->insert([
            'nama_event' => 'Ulang Tahun',
            'slug' => 'ulang-tahun',
            'deskripsi' => 'Paket spesial untuk perayaan ulang tahun dengan kue dan dekorasi',
            'tipe_event' => 'ulang_tahun',
            'harga_min_per_orang' => 45000,
            'harga_max_per_orang' => 150000,
            'fitur' => json_encode([
                'Kue ulang tahun',
                'Menu prasmanan',
                'Dekorasi tema',
                'Kartu ucapan'
            ]),
            'galeri' => null,
            'gambar_utama' => null,
            'is_active' => true,
            'urutan' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('event')->insert([
            'nama_event' => 'Arisan Bulanan',
            'slug' => 'arisan-bulanan',
            'deskripsi' => 'Paket hemat untuk arisan bulanan dengan menu rumahan',
            'tipe_event' => 'pribadi',
            'harga_min_per_orang' => 25000,
            'harga_max_per_orang' => 50000,
            'fitur' => json_encode([
                'Menu nasi box',
                'Snack tradisional',
                'Minuman segar',
                'Free ongkir minimal order'
            ]),
            'galeri' => null,
            'gambar_utama' => null,
            'is_active' => true,
            'urutan' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('event')->insert([
            'nama_event' => 'Acara Keluarga',
            'slug' => 'acara-keluarga',
            'deskripsi' => 'Paket untuk berbagai acara keluarga seperti syukuran, tahlilan, atau kumpul keluarga',
            'tipe_event' => 'pribadi',
            'harga_min_per_orang' => 30000,
            'harga_max_per_orang' => 75000,
            'fitur' => json_encode([
                'Nasi box atau Berkat',
                'Menu rumahan',
                'Porsi besar',
                'Pengiriman tepat waktu'
            ]),
            'galeri' => null,
            'gambar_utama' => null,
            'is_active' => true,
            'urutan' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}