<?php
// app/Http/Controllers/LaporanController.php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function harian(Request $request)
    {
        $tanggal = $request->tanggal ?? today();
        
        $pemesanans = Pemesanan::with(['user', 'paket'])
                               ->whereDate('tanggal_event', $tanggal)
                               ->where('status', 'selesai')
                               ->get();
        
        $totalPemesanan = $pemesanans->count();
        $totalPendapatan = $pemesanans->sum('total_biaya');
        $rataPemesanan = $pemesanans->avg('jumlah_tamu');
        
        // Perhitungan per event type
        $perEvent = Pemesanan::join('event', 'pemesanan.event_id', '=', 'event.id')
                             ->whereDate('pemesanan.tanggal_event', $tanggal)
                             ->where('pemesanan.status', 'selesai')
                             ->select('event.nama_event', DB::raw('count(*) as total'), DB::raw('sum(pemesanan.total_biaya) as pendapatan'))
                             ->groupBy('event.nama_event')
                             ->get();
        
        return view('admin.laporan.harian', compact(
            'tanggal', 'pemesanans', 'totalPemesanan', 'totalPendapatan', 'rataPemesanan', 'perEvent'
        ));
    }

    public function bulanan(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;
        
        $pemesanans = Pemesanan::with(['user', 'paket'])
                               ->whereMonth('tanggal_event', $bulan)
                               ->whereYear('tanggal_event', $tahun)
                               ->where('status', 'selesai')
                               ->orderBy('tanggal_event')
                               ->get();
        
        $totalPemesanan = $pemesanans->count();
        $totalPendapatan = $pemesanans->sum('total_biaya');
        $totalTamu = $pemesanans->sum('jumlah_tamu');
        
        // Grafik per hari
        $grafik = Pemesanan::whereMonth('tanggal_event', $bulan)
                           ->whereYear('tanggal_event', $tahun)
                           ->where('status', 'selesai')
                           ->select(
                               DB::raw('DATE(tanggal_event) as tanggal'),
                               DB::raw('count(*) as total'),
                               DB::raw('sum(total_biaya) as pendapatan')
                           )
                           ->groupBy('tanggal')
                           ->orderBy('tanggal')
                           ->get();
        
        // Top menu bulan ini
        $topMenu = DB::table('detail_pemesanan_menu')
                     ->join('menu', 'menu.id', '=', 'detail_pemesanan_menu.menu_id')
                     ->join('pemesanan', 'pemesanan.id', '=', 'detail_pemesanan_menu.pemesanan_id')
                     ->whereMonth('pemesanan.tanggal_event', $bulan)
                     ->whereYear('pemesanan.tanggal_event', $tahun)
                     ->where('pemesanan.status', 'selesai')
                     ->select(
                         'menu.nama_menu',
                         DB::raw('count(detail_pemesanan_menu.menu_id) as total_dipesan'),
                         DB::raw('sum(detail_pemesanan_menu.jumlah) as total_porsi')
                     )
                     ->groupBy('menu.id', 'menu.nama_menu')
                     ->orderBy('total_dipesan', 'desc')
                     ->limit(5)
                     ->get();
        
        return view('admin.laporan.bulanan', compact(
            'bulan', 'tahun', 'pemesanans', 'totalPemesanan', 'totalPendapatan', 
            'totalTamu', 'grafik', 'topMenu'
        ));
    }

    public function tahunan(Request $request)
    {
        $tahun = $request->tahun ?? now()->year;
        
        $pemesanans = Pemesanan::whereYear('tanggal_event', $tahun)
                               ->where('status', 'selesai')
                               ->get();
        
        $totalPemesanan = $pemesanans->count();
        $totalPendapatan = $pemesanans->sum('total_biaya');
        $totalTamu = $pemesanans->sum('jumlah_tamu');
        
        // Grafik per bulan
        $grafik = Pemesanan::whereYear('tanggal_event', $tahun)
                           ->where('status', 'selesai')
                           ->select(
                               DB::raw('MONTH(tanggal_event) as bulan'),
                               DB::raw('count(*) as total'),
                               DB::raw('sum(total_biaya) as pendapatan')
                           )
                           ->groupBy('bulan')
                           ->orderBy('bulan')
                           ->get();
        
        // Perbandingan dengan tahun lalu
        $tahunLalu = $tahun - 1;
        $pendapatanTahunIni = $totalPendapatan;
        $pendapatanTahunLalu = Pemesanan::whereYear('tanggal_event', $tahunLalu)
                                        ->where('status', 'selesai')
                                        ->sum('total_biaya');
        
        $pertumbuhan = $pendapatanTahunLalu > 0 
                      ? (($pendapatanTahunIni - $pendapatanTahunLalu) / $pendapatanTahunLalu) * 100 
                      : 100;
        
        return view('admin.laporan.tahunan', compact(
            'tahun', 'pemesanans', 'totalPemesanan', 'totalPendapatan', 
            'totalTamu', 'grafik', 'pertumbuhan', 'pendapatanTahunLalu'
        ));
    }

    public function export(Request $request)
    {
        $type = $request->type; // harian/bulanan/tahunan
        $format = $request->format(pdf); // pdf/excel
        
        // Logika export berdasarkan type dan format
        // Bisa menggunakan package seperti maatwebsite/excel atau dompdf
        
        return redirect()->back()->with('success', 'Laporan berhasil diexport');
    }
}