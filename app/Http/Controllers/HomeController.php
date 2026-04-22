<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Event;
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
                          ->get();
        
        $menuUtama = Menu::where('kategori', 'utama')
                        ->where('is_active', true)
                        ->orderBy('urutan')
                        ->get();
        
        $menuPenutup = Menu::where('kategori', 'penutup')
                          ->where('is_active', true)
                          ->orderBy('urutan')
                          ->get();
        
        // Ambil event
        $events = Event::where('is_active', true)
                      ->orderBy('urutan')
                      ->get();
        
        // Ambil paket populer
        $paketPopuler = PaketCatering::with('event')
                                     ->where('is_active', true)
                                     ->where('is_popular', true)
                                     ->limit(4)
                                     ->get();
        
        // Ambil testimoni
        $testimonis = Testimoni::with('user')
                               ->where('is_approved', true)
                               ->orderBy('created_at', 'desc')
                               ->limit(3)
                               ->get();
        
        return view('home', compact(
            'menuPembuka',
            'menuUtama',
            'menuPenutup',
            'events',
            'paketPopuler',
            'testimonis'
        ));
    }

    public function menu()
    {
        $menus = Menu::where('is_active', true)
                     ->orderBy('kategori')
                     ->orderBy('urutan')
                     ->get()
                     ->groupBy('kategori');
        
        return view('menu', compact('menus'));
    }

    public function event()
    {
        $events = Event::with('paketCatering')
                       ->where('is_active', true)
                       ->orderBy('urutan')
                       ->get();
        
        return view('event', compact('events'));
    }

    public function kontak()
    {
        return view('kontak');
    }

    public function getQuote(Request $request)
{
    // Cek login
    if (!auth()->check()) {
        return response()->json([
            'success' => false,
            'message' => 'Silakan login terlebih dahulu'
        ], 401);
    }

    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'event_type' => 'required|string',
        'tanggal' => 'required|date|after:today',
        'jumlah_tamu' => 'required|numeric|min:1',
        'catatan' => 'nullable|string'
    ]);

    // Simpan ke session atau database sementara
    session()->flash('quote_data', $request->all());

    return response()->json([
        'success' => true,
        'message' => 'Terima kasih! Kami akan segera menghubungi Anda.'
    ]);
}
}