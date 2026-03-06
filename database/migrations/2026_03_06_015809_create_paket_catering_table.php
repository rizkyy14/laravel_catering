<?php
// database/migrations/2024_01_01_000005_create_paket_catering_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paket_catering', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->string('slug')->unique();
            $table->text('deskripsi');
            $table->foreignId('event_id')->constrained('event')->onDelete('cascade');
            $table->decimal('harga_per_orang', 15, 2);
            $table->integer('min_pax')->default(10);
            $table->integer('max_pax')->nullable();
            $table->json('menu_items')->nullable(); // Menyimpan ID menu yang termasuk
            $table->json('includes')->nullable();
            $table->string('gambar_utama')->nullable();
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paket_catering');
    }
};