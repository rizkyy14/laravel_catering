<?php
// app/Http/Controllers/ApiController.php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\PaketCatering;
use App\Models\Event;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    // Get menu by kategori (untuk tab switching)
    public function getMenu($kategori)
    {
        $menus = Menu::where('kategori', $kategori)
                     ->where('is_active', true)
                     ->orderBy('urutan')
                     ->get()
                     ->map(function($menu) {
                         return [
                             'id' => $menu->id,
                             'nama' => $menu->nama_menu,
                             'deskripsi' => $menu->deskripsi,
                             'harga' => $menu->harga,
                             'harga_format' => 'Rp ' . number_format($menu->harga, 0, ',', '.'),
                             'emoji' => $menu->emoji,
                             'gambar' => $menu->gambar ? asset('storage/' . $menu->gambar) : null,
                             'is_special' => $menu->is_special
                         ];
                     });
        
        return response()->json($menus);
    }

    // Get paket by event
    public function getPaketByEvent($eventId)
    {
        $pakets = PaketCatering::where('event_id', $eventId)
                                ->where('is_active', true)
                                ->orderBy('harga_per_orang')
                                ->get()
                                ->map(function($paket) {
                                    return [
                                        'id' => $paket->id,
                                        'nama' => $paket->nama_paket,
                                        'deskripsi' => $paket->deskripsi,
                                        'harga' => $paket->harga_per_orang,
                                        'harga_format' => 'Rp ' . number_format($paket->harga_per_orang, 0, ',', '.'),
                                        'min_pax' => $paket->min_pax,
                                        'max_pax' => $paket->max_pax,
                                        'includes' => $paket->includes,
                                        'is_popular' => $paket->is_popular
                                    ];
                                });
        
        return response()->json($pakets);
    }

    // Cek ketersediaan tanggal
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kota' => 'required'
        ]);

        // Logika cek apakah tanggal sudah penuh
        $pemesananHariItu = Pemesanan::whereDate('tanggal_event', $request->tanggal)
                                      ->where('kota_event', $request->kota)
                                      ->whereIn('status', ['disetujui', 'diproses'])
                                      ->count();

        $maxPerHari = 5; // Maksimal 5 event per hari per kota

        return response()->json([
            'available' => $pemesananHariItu < $maxPerHari,
            'total_event' => $pemesananHariItu,
            'max_event' => $maxPerHari,
            'message' => $pemesananHariItu < $maxPerHari 
                        ? 'Tanggal tersedia' 
                        : 'Maaf, tanggal sudah penuh'
        ]);
    }

    // Hitung estimasi biaya
    public function calculatePrice(Request $request)
    {
        $request->validate([
            'paket_id' => 'required|exists:paket_catering,id',
            'jumlah_tamu' => 'required|integer|min:1'
        ]);

        $paket = PaketCatering::find($request->paket_id);
        
        $subtotal = $paket->harga_per_orang * $request->jumlah_tamu;
        $pajak = $subtotal * 0.11; // PPN 11%
        $total = $subtotal + $pajak;
        $dp = $total * 0.3; // DP 30%

        return response()->json([
            'subtotal' => $subtotal,
            'subtotal_format' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
            'pajak' => $pajak,
            'pajak_format' => 'Rp ' . number_format($pajak, 0, ',', '.'),
            'total' => $total,
            'total_format' => 'Rp ' . number_format($total, 0, ',', '.'),
            'dp' => $dp,
            'dp_format' => 'Rp ' . number_format($dp, 0, ',', '.'),
            'harga_per_orang' => $paket->harga_per_orang,
            'harga_per_orang_format' => 'Rp ' . number_format($paket->harga_per_orang, 0, ',', '.')
        ]);
    }

    // Get testimoni terbaru
    public function getTestimonials()
    {
        $testimonis = Testimoni::with('user')
                                ->where('is_approved', true)
                                ->orderBy('created_at', 'desc')
                                ->take(6)
                                ->get()
                                ->map(function($testimoni) {
                                    return [
                                        'id' => $testimoni->id,
                                        'nama' => $testimoni->user->nama,
                                        'isi' => $testimoni->isi_testimoni,
                                        'rating' => $testimoni->rating,
                                        'foto' => $testimoni->foto ? asset('storage/' . $testimoni->foto) : null,
                                        'tanggal' => $testimoni->created_at->format('d M Y')
                                    ];
                                });
        
        return response()->json($testimonis);
    }
}