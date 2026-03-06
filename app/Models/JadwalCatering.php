<?php
// app/Models/JadwalCatering.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalCatering extends Model
{
    use HasFactory;

    protected $table = 'jadwal_catering';
    
    protected $fillable = [
        'pemesanan_id',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'status',
        'tim_staff',
        'catatan_khusus',
    ];

    protected $casts = [
        'tim_staff' => 'array',
        'tanggal' => 'date',
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    // Relasi ke pemesanan
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    // Scope untuk jadwal hari ini
    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal', today());
    }

    // Scope untuk jadwal minggu ini
    public function scopeMingguIni($query)
    {
        return $query->whereBetween('tanggal', [now()->startOfWeek(), now()->endOfWeek()]);
    }
}