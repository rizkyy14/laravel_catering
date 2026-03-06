<?php
// database/migrations/2024_01_01_000006_create_pemesanan_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->string('no_pemesanan')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('event_id')->constrained('event');
            $table->foreignId('paket_id')->constrained('paket_catering');
            $table->enum('status', [
                'draft', 
                'menunggu', 
                'diproses', 
                'disetujui', 
                'selesai', 
                'dibatalkan'
            ])->default('draft');
            $table->date('tanggal_event');
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();
            $table->string('lokasi_event');
            $table->string('kota_event');
            $table->integer('jumlah_tamu');
            $table->decimal('harga_per_orang', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->decimal('pajak', 15, 2)->default(0);
            $table->decimal('biaya_layanan', 15, 2)->default(0);
            $table->decimal('total_biaya', 15, 2);
            $table->decimal('dp_dibayar', 15, 2)->nullable();
            $table->date('batas_bayar_dp')->nullable();
            $table->text('catatan')->nullable();
            $table->json('permintaan_khusus')->nullable();
            $table->json('menu_tambahan')->nullable();
            $table->string('alasan_batal')->nullable();
            $table->timestamps();
            
            $table->index('no_pemesanan');
            $table->index('status');
            $table->index('tanggal_event');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};