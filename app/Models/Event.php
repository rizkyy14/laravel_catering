<?php
// app/Models/Event.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'event';
    
    protected $fillable = [
        'nama_event',
        'slug',
        'deskripsi',
        'tipe_event',
        'harga_min_per_orang',
        'harga_max_per_orang',
        'fitur',
        'galeri',
        'gambar_utama',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'fitur' => 'array',
        'galeri' => 'array',
        'is_active' => 'boolean',
        'harga_min_per_orang' => 'decimal:2',
        'harga_max_per_orang' => 'decimal:2',
    ];

    // Relasi ke paket catering
    public function paketCatering()
    {
        return $this->hasMany(PaketCatering::class, 'event_id');
    }

    // Relasi ke pemesanan
    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'event_id');
    }

    // Scope untuk event aktif
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }
}