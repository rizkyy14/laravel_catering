@extends('layouts.app')

@section('title', 'Riwayat Pemesanan')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-stone-800">Riwayat Pemesanan</h1>
            <p class="text-stone-500 mt-1">Lihat semua pemesanan catering Anda</p>
        </div>
        <a href="{{ route('home') }}#events" class="bg-amber-500 text-white px-6 py-2 rounded-xl hover:bg-amber-600 transition">
            + Pesan Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($pemesanans->isEmpty())
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <div class="text-6xl mb-4">📋</div>
            <h3 class="text-xl font-semibold text-stone-700 mb-2">Belum ada pemesanan</h3>
            <p class="text-stone-500 mb-6">Anda belum melakukan pemesanan catering</p>
            <a href="{{ route('home') }}#events" class="bg-amber-500 text-white px-6 py-2 rounded-xl hover:bg-amber-600 transition">
                Pesan Sekarang
            </a>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Pemesanan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Event</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paket</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tamu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($pemesanans as $p)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $p->no_pemesanan }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $p->tanggal_event->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $p->paket->nama_paket }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $p->jumlah_tamu }} orang</td>
                            <td class="px-6 py-4 text-sm font-semibold text-amber-600">Rp {{ number_format($p->total_biaya, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($p->status == 'selesai') bg-green-100 text-green-800
                                    @elseif($p->status == 'dibatalkan') bg-red-100 text-red-800
                                    @elseif($p->status == 'disetujui') bg-blue-100 text-blue-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ $p->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('pemesanan.show', $p->id) }}" class="text-amber-600 hover:text-amber-800 font-medium">
                                    Detail →
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-6">
            {{ $pemesanans->links() }}
        </div>
    @endif
</div>
@endsection