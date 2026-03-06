<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Hapus data dengan urutan yang benar (dari anak ke induk)
        DB::table('jadwal_catering')->delete();
        DB::table('testimoni')->delete();
        DB::table('detail_pemesanan_menu')->delete();
        DB::table('pemesanan')->delete();
        DB::table('paket_catering')->delete();
        DB::table('menu')->delete();
        DB::table('event')->delete();
        DB::table('kategori_menu')->delete();
        DB::table('users')->delete();
        
        // Reset auto increment
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE kategori_menu AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE menu AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE event AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE paket_catering AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE pemesanan AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE detail_pemesanan_menu AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE testimoni AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE jadwal_catering AUTO_INCREMENT = 1');
        
        // Aktifkan kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        // Jalankan semua seeder
        $this->call([
            UserSeeder::class,
            KategoriMenuSeeder::class,
            MenuSeeder::class,
            EventSeeder::class,
            PaketCateringSeeder::class,
        ]);
    }
}