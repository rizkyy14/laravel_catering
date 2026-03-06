<?php
// app/Models/PaketCatering.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaketCatering extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'paket_catering';
    
    protected $fillable = [
        'nama_paket',
        'slug',
        'deskripsi',
        'event_id',
        'harga_per_orang',
        'min_pax',
        'max_pax',
        'menu_items',
        'includes',
        'gambar_utama',
        'is_popular',
        'is_active',
    ];

    protected $casts = [
        'menu_items' => 'array',
        'includes' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'harga_per_orang' => 'decimal:2',
    ];

    // Relasi ke event
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    // Relasi ke pemesanan
    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'paket_id');
    }

    // Scope untuk paket aktif
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk paket populer
    public function scopePopuler($query)
    {
        return $query->where('is_popular', true);
    }
}