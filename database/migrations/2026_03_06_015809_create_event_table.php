<?php
// database/migrations/2024_01_01_000004_create_event_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event', function (Blueprint $table) {
            $table->id();
            $table->string('nama_event');
            $table->string('slug')->unique();
            $table->text('deskripsi');
            $table->enum('tipe_event', ['pernikahan', 'kantor', 'ulang_tahun', 'pribadi', 'lainnya']);
            $table->decimal('harga_min_per_orang', 15, 2);
            $table->decimal('harga_max_per_orang', 15, 2);
            $table->json('fitur')->nullable();
            $table->json('galeri')->nullable();
            $table->string('gambar_utama')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event');
    }
};