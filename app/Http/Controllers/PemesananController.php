<?php
// app/Http/Controllers/PemesananController.php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\PaketCatering;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    public function index()
    {
        $pemesanans = Pemesanan::with(['event', 'paket'])
                               ->where('user_id', Auth::id())
                               ->orderBy('created_at', 'desc')
                               ->paginate(10);
        
        return view('pemesanan.index', compact('pemesanans'));
    }
    
    public function create(Request $request)
    {
        $paket = PaketCatering::with('event')->findOrFail($request->paket_id);
        $events = Event::where('is_active', true)->get();
        
        return view('pemesanan.create', compact('paket', 'events'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:event,id',
            'paket_id' => 'required|exists:paket_catering,id',
            'tanggal_event' => 'required|date|after:today',
            'waktu_mulai' => 'required',
            'lokasi_event' => 'required',
            'kota_event' => 'required',
            'jumlah_tamu' => 'required|numeric|min:1',
            'catatan' => 'nullable'
        ]);
        
        $paket = PaketCatering::find($request->paket_id);
        
        // Hitung total biaya
        $subtotal = $paket->harga_per_orang * $request->jumlah_tamu;
        $pajak = $subtotal * 0.11; // PPN 11%
        $total = $subtotal + $pajak;
        
        $pemesanan = Pemesanan::create([
            'no_pemesanan' => Pemesanan::generateNoPemesanan(),
            'user_id' => Auth::id(),
            'event_id' => $request->event_id,
            'paket_id' => $request->paket_id,
            'status' => 'menunggu',
            'tanggal_event' => $request->tanggal_event,
            'waktu_mulai' => $request->waktu_mulai,
            'lokasi_event' => $request->lokasi_event,
            'kota_event' => $request->kota_event,
            'jumlah_tamu' => $request->jumlah_tamu,
            'harga_per_orang' => $paket->harga_per_orang,
            'subtotal' => $subtotal,
            'pajak' => $pajak,
            'total_biaya' => $total,
            'catatan' => $request->catatan,
            'permintaan_khusus' => $request->permintaan_khusus
        ]);
        
        // Hitung DP (30%)
        $dp = $total * 0.3;
        $pemesanan->dp_dibayar = $dp;
        $pemesanan->batas_bayar_dp = now()->addDays(3);
        $pemesanan->save();
        
        return redirect()->route('pemesanan.show', $pemesanan->id)
                        ->with('success', 'Pemesanan berhasil dibuat!');
    }
    
    public function show($id)
    {
        $pemesanan = Pemesanan::with(['user', 'event', 'paket', 'detailMenu.menu'])
                              ->findOrFail($id);
        
        // Cek kepemilikan
        if ($pemesanan->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        
        return view('pemesanan.show', compact('pemesanan'));
    }
    
    public function batal($id, Request $request)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        
        $request->validate([
            'alasan_batal' => 'required'
        ]);
        
        $pemesanan->update([
            'status' => 'dibatalkan',
            'alasan_batal' => $request->alasan_batal
        ]);
        
        return redirect()->back()->with('success', 'Pemesanan dibatalkan');
    }
    
    public function konfirmasiPembayaran(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        
        // Logika upload bukti pembayaran
        if ($request->hasFile('bukti_pembayaran')) {
            $path = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');
            // Simpan path ke database
        }
        
        return redirect()->back()->with('success', 'Bukti pembayaran terkirim');
    }
}