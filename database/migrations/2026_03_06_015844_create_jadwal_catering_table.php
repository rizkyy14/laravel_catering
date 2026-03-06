<?php
// database/migrations/2024_01_01_000009_create_jadwal_catering_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_catering', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->constrained('pemesanan')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->enum('status', ['dijadwalkan', 'persiapan', 'dalam_perjalanan', 'selesai', 'dibatalkan'])
                  ->default('dijadwalkan');
            $table->json('tim_staff')->nullable();
            $table->text('catatan_khusus')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_catering');
    }
};