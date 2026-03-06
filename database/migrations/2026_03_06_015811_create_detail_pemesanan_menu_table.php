<?php
// database/migrations/2024_01_01_000007_create_detail_pemesanan_menu_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pemesanan_menu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->constrained('pemesanan')->onDelete('cascade');
            $table->foreignId('menu_id')->constrained('menu');
            $table->enum('jenis_hidangan', ['pembuka', 'utama', 'penutup', 'minuman']);
            $table->integer('jumlah')->default(1);
            $table->decimal('harga_saat_pesan', 15, 2);
            $table->text('catatan_khusus')->nullable();
            $table->timestamps();
            
            $table->unique(['pemesanan_id', 'menu_id'], 'pemesanan_menu_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pemesanan_menu');
    }
};