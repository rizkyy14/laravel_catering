<?php
// database/migrations/2024_01_01_000003_create_menu_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('nama_menu');
            $table->string('slug')->unique();
            $table->text('deskripsi');
            $table->decimal('harga', 15, 2);
            $table->string('kategori');
            $table->string('emoji')->nullable();
            $table->string('gambar')->nullable();
            $table->json('bahan_bahan')->nullable();
            $table->json('informasi_diet')->nullable();
            $table->boolean('is_special')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};