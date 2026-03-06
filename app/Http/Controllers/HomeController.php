<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Menu;
use App\Models\PaketCatering;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil menu untuk masing-masing kategori
        $menuPembuka = Menu::where('kategori', 'pembuka')
                          ->where('is_active', true)
                          ->orderBy('urutan')
                          ->take(3)
                          ->get();
        
        $menuUtama = Menu::where('kategori', 'utama')
                        ->where('is_active', true)
                        ->orderBy('urutan')
                        ->take(3)
                        ->get();
        
        $menuPenutup = Menu::where('kategori', 'penutup')
                          ->where('is_active', true)
                          ->orderBy('urutan')
                          ->take(3)
                          ->get();
        
        // Ambil event yang tersedia
        $events = Event::where('is_active', true)
                      ->orderBy('urutan')
                      ->get();
        
        // Ambil paket catering populer
        $paketPopuler = PaketCatering::with('event')
                                     ->where('is_active', true)
                                     ->where('is_popular', true)
                                     ->orderBy('harga_per_orang')
                                     ->take(4)
                                     ->get();
        
        // Ambil testimoni unggulan
        $testimoni = Testimoni::with('user')
                              ->where('is_approved', true)
                              ->where('is_featured', true)
                              ->orderBy('created_at', 'desc')
                              ->take(3)
                              ->get();
        
        // Statistik
        $totalEvent = Pemesanan::where('status', 'selesai')->count();
        $totalPelanggan = User::where('role', 'pelanggan')->count();
        
        return view('home', compact(
            'menuPembuka',
            'menuUtama', 
            'menuPenutup',
            'events',
            'paketPopuler',
            'testimoni',
            'totalEvent',
            'totalPelanggan'
        ));
    }
    
    public function getQuote(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'event_type' => 'required',
            'tanggal' => 'required|date',
            'jumlah_tamu' => 'required|numeric|min:1',
            'catatan' => 'nullable'
        ]);
        
        // Simpan ke session atau kirim email
        // Bisa juga langsung buat draft pemesanan
        
        return response()->json([
            'success' => true,
            'message' => 'Terima kasih, permintaan Anda akan segera kami proses!'
        ]);
    }
}