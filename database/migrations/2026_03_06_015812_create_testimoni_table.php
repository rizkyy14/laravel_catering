<?php
// database/migrations/2024_01_01_000008_create_testimoni_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimoni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pemesanan_id')->constrained('pemesanan')->onDelete('cascade');
            $table->text('isi_testimoni');
            $table->integer('rating')->default(5);
            $table->string('foto')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            
            $table->unique('pemesanan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimoni');
    }
};