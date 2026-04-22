<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    public function index()
    {
        $pemesanans = Pemesanan::with(['user', 'event', 'paket'])
                               ->orderBy('created_at', 'desc')
                               ->paginate(20);
        
        return view('admin.pemesanan.index', compact('pemesanans'));
    }

    public function show($id)
    {
        $pemesanan = Pemesanan::with(['user', 'event', 'paket'])
                              ->findOrFail($id);
        
        return view('admin.pemesanan.show', compact('pemesanan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:menunggu,diproses,disetujui,selesai,dibatalkan'
        ]);
        
        $pemesanan->update(['status' => $request->status]);
        
        return response()->json([
            'success' => true,
            'message' => 'Status pemesanan berhasil diupdate'
        ]);
    }
}