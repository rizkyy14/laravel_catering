<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    
    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_telepon',
        'alamat',
        'kota',
        'role',
        'foto_profil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_terverifikasi_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi ke pemesanan
    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'user_id');
    }

    // Relasi ke testimoni
    public function testimoni()
    {
        return $this->hasMany(Testimoni::class, 'user_id');
    }

    // Cek role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function isPelanggan()
    {
        return $this->role === 'pelanggan';
    }
}