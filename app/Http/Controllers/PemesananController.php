<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\PaketCatering;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $paketId = $request->query('paket');
        
        if (!$paketId) {
            return redirect()->route('home')->with('error', 'Pilih paket catering terlebih dahulu');
        }
        
        $paket = PaketCatering::with('event')->findOrFail($paketId);
        $events = Event::where('is_active', true)->get();
        
        return view('pemesanan.create', compact('paket', 'events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paket_id' => 'required|exists:paket_catering,id',
            'tanggal_event' => 'required|date|after:today',
            'waktu_mulai' => 'required',
            'lokasi_event' => 'required|string|max:255',
            'kota_event' => 'required|string|max:255',
            'jumlah_tamu' => 'required|integer|min:10',
            'catatan' => 'nullable|string'
        ]);

        $paket = PaketCatering::find($request->paket_id);
        
        // Hitung total biaya
        $subtotal = $paket->harga_per_orang * $request->jumlah_tamu;
        $pajak = $subtotal * 0.11; // PPN 11%
        $total = $subtotal + $pajak;

        $pemesanan = Pemesanan::create([
            'no_pemesanan' => $this->generateNoPemesanan(),
            'user_id' => Auth::id(),
            'event_id' => $paket->event_id,
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
        ]);

        return redirect()->route('pemesanan.show', $pemesanan->id)
                        ->with('success', 'Pemesanan berhasil dibuat! Silakan lakukan pembayaran DP.');
    }

    public function show($id)
    {
        $pemesanan = Pemesanan::with(['user', 'event', 'paket'])
                              ->where('user_id', Auth::id())
                              ->findOrFail($id);
        
        return view('pemesanan.show', compact('pemesanan'));
    }

    public function batal($id, Request $request)
    {
        $pemesanan = Pemesanan::where('user_id', Auth::id())->findOrFail($id);
        
        $request->validate([
            'alasan_batal' => 'required|string|min:10'
        ]);
        
        $pemesanan->update([
            'status' => 'dibatalkan',
            'alasan_batal' => $request->alasan_batal
        ]);
        
        return redirect()->route('pemesanan.index')
                        ->with('success', 'Pemesanan telah dibatalkan');
    }

    private function generateNoPemesanan()
    {
        $tahun = date('Y');
        $bulan = date('m');
        $last = Pemesanan::whereYear('created_at', $tahun)
                         ->whereMonth('created_at', $bulan)
                         ->count();
        
        $no = str_pad($last + 1, 4, '0', STR_PAD_LEFT);
        return 'LUM/' . $tahun . '/' . $bulan . '/' . $no;
    }
}