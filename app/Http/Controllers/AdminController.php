<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\User;
use App\Models\Menu;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Statistik hari ini
        $pemesananHariIni = Pemesanan::whereDate('created_at', today())->count();
        $pendapatanHariIni = Pemesanan::whereDate('created_at', today())
                                      ->where('status', 'selesai')
                                      ->sum('total_biaya');
        
        // Statistik bulan ini
        $pemesananBulanIni = Pemesanan::whereMonth('created_at', now()->month)
                                      ->whereYear('created_at', now()->year)
                                      ->count();
        
        $pendapatanBulanIni = Pemesanan::whereMonth('created_at', now()->month)
                                       ->whereYear('created_at', now()->year)
                                       ->where('status', 'selesai')
                                       ->sum('total_biaya');
        
        // Pemesanan pending
        $pendingOrders = Pemesanan::with(['user', 'event'])
                                  ->where('status', 'menunggu')
                                  ->orderBy('created_at', 'desc')
                                  ->take(5)
                                  ->get();
        
        // Jadwal hari ini
        $jadwalHariIni = JadwalCatering::with(['pemesanan.user'])
                                       ->whereDate('tanggal', today())
                                       ->orderBy('waktu_mulai')
                                       ->get();
        
        // Menu populer
        $menuPopuler = DB::table('detail_pemesanan_menu')
                        ->select('menu_id', DB::raw('count(*) as total'))
                        ->join('menu', 'menu.id', '=', 'detail_pemesanan_menu.menu_id')
                        ->whereMonth('detail_pemesanan_menu.created_at', now()->month)
                        ->groupBy('menu_id')
                        ->orderBy('total', 'desc')
                        ->limit(5)
                        ->get();
        
        return view('admin.dashboard', compact(
            'pemesananHariIni',
            'pendapatanHariIni',
            'pemesananBulanIni',
            'pendapatanBulanIni',
            'pendingOrders',
            'jadwalHariIni',
            'menuPopuler'
        ));
    }
    
    public function updateStatusPemesanan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:draft,menunggu,diproses,disetujui,selesai,dibatalkan'
        ]);
        
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->update(['status' => $request->status]);
        
        // Jika status disetujui, buat jadwal
        if ($request->status == 'disetujui') {
            JadwalCatering::create([
                'pemesanan_id' => $pemesanan->id,
                'tanggal' => $pemesanan->tanggal_event,
                'waktu_mulai' => $pemesanan->waktu_mulai,
                'waktu_selesai' => $pemesanan->waktu_mulai->addHours(3),
                'status' => 'dijadwalkan'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Status pemesanan berhasil diupdate'
        ]);
    }
}