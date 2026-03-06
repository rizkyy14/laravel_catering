<?php
// app/Models/Testimoni.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    use HasFactory;

    protected $table = 'testimoni';
    
    protected $fillable = [
        'user_id',
        'pemesanan_id',
        'isi_testimoni',
        'rating',
        'foto',
        'is_approved',
        'is_featured',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke pemesanan
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    // Scope untuk testimoni yang disetujui
    public function scopeDisetujui($query)
    {
        return $query->where('is_approved', true);
    }

    // Scope untuk testimoni unggulan
    public function scopeUnggulan($query)
    {
        return $query->where('is_featured', true);
    }
}