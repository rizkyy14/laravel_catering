<?php
// app/Models/Pemesanan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';
    
    protected $fillable = [
        'no_pemesanan',
        'user_id',
        'event_id',
        'paket_id',
        'status',
        'tanggal_event',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi_event',
        'kota_event',
        'jumlah_tamu',
        'harga_per_orang',
        'subtotal',
        'pajak',
        'biaya_layanan',
        'total_biaya',
        'dp_dibayar',
        'batas_bayar_dp',
        'catatan',
        'permintaan_khusus',
        'menu_tambahan',
        'alasan_batal',
    ];

    protected $casts = [
        'permintaan_khusus' => 'array',
        'menu_tambahan' => 'array',
        'tanggal_event' => 'date',
        'batas_bayar_dp' => 'date',
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'harga_per_orang' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'pajak' => 'decimal:2',
        'biaya_layanan' => 'decimal:2',
        'total_biaya' => 'decimal:2',
        'dp_dibayar' => 'decimal:2',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke event
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    // Relasi ke paket
    public function paket()
    {
        return $this->belongsTo(PaketCatering::class, 'paket_id');
    }

    // Relasi ke detail pemesanan menu
    public function detailMenu()
    {
        return $this->hasMany(DetailPemesananMenu::class, 'pemesanan_id');
    }

    // Relasi ke jadwal
    public function jadwal()
    {
        return $this->hasOne(JadwalCatering::class, 'pemesanan_id');
    }

    // Relasi ke testimoni
    public function testimoni()
    {
        return $this->hasOne(Testimoni::class, 'pemesanan_id');
    }

    // Generate nomor pemesanan otomatis
    public static function generateNoPemesanan()
    {
        $tahun = date('Y');
        $bulan = date('m');
        $terakhir = self::whereYear('created_at', $tahun)
                        ->whereMonth('created_at', $bulan)
                        ->count();
        
        $nomor = $terakhir + 1;
        return 'LUM/' . $tahun . '/' . $bulan . '/' . str_pad($nomor, 4, '0', STR_PAD_LEFT);
    }

    // Scope berdasarkan status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk pemesanan aktif (belum selesai/dibatalkan)
    public function scopeAktif($query)
    {
        return $query->whereNotIn('status', ['selesai', 'dibatalkan']);
    }
}