<?php
// app/Models/KategoriMenu.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriMenu extends Model
{
    use HasFactory;

    protected $table = 'kategori_menu';
    
    protected $fillable = [
        'nama_kategori',
        'slug',
        'deskripsi',
        'icon',
        'gambar',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relasi ke menu
    public function menu()
    {
        return $this->hasMany(Menu::class, 'kategori_menu_id');
    }
}