<?php
// database/seeders/TestimoniSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimoniSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('testimoni')->insert([
            [
                'user_id' => 3, // Budi Santoso
                'pemesanan_id' => 1,
                'isi_testimoni' => 'Catering untuk pernikahan anak saya sangat memuaskan. Makanan enak, pelayanan ramah, dan tepat waktu. Terima kasih Lumina!',
                'rating' => 5,
                'is_approved' => true,
                'is_featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4, // Siti Rahayu
                'pemesanan_id' => 2,
                'isi_testimoni' => 'Paket untuk arisan bulanan kemarin enak-enak. Tamu pada suka semua. Next order lagi ya.',
                'rating' => 4,
                'is_approved' => true,
                'is_featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5, // Ahmad Hidayat
                'pemesanan_id' => 3,
                'isi_testimoni' => 'Rapat kantor jadi lebih semangat karena cateringnya enak. Porsi pas, datang tepat waktu. Recomended!',
                'rating' => 5,
                'is_approved' => true,
                'is_featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}