<?php
// app/Models/DetailPemesananMenu.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPemesananMenu extends Model
{
    use HasFactory;

    protected $table = 'detail_pemesanan_menu';
    
    protected $fillable = [
        'pemesanan_id',
        'menu_id',
        'jenis_hidangan',
        'jumlah',
        'harga_saat_pesan',
        'catatan_khusus',
    ];

    protected $casts = [
        'harga_saat_pesan' => 'decimal:2',
    ];

    // Relasi ke pemesanan
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    // Relasi ke menu
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}