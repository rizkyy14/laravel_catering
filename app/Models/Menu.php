<?php
// app/Models/Menu.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    
    protected $fillable = [
        'nama_menu',
        'slug',
        'deskripsi',
        'harga',
        'kategori',
        'emoji',
        'gambar',
        'bahan_bahan',
        'informasi_diet',
        'is_special',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'bahan_bahan' => 'array',
        'informasi_diet' => 'array',
        'is_special' => 'boolean',
        'is_active' => 'boolean',
        'harga' => 'decimal:2',
    ];

    // Relasi ke detail pemesanan
    public function detailPemesanan()
    {
        return $this->hasMany(DetailPemesananMenu::class, 'menu_id');
    }

    // Scope untuk menu aktif
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    // Scope berdasarkan kategori
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}