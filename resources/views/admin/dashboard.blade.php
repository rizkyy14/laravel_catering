@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="text-3xl mb-2">📋</div>
            <div class="text-2xl font-bold">{{ \App\Models\Pemesanan::count() }}</div>
            <div class="text-stone-500 text-sm">Total Pemesanan</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="text-3xl mb-2">👥</div>
            <div class="text-2xl font-bold">{{ \App\Models\User::where('role', 'pelanggan')->count() }}</div>
            <div class="text-stone-500 text-sm">Pelanggan</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="text-3xl mb-2">💰</div>
            <div class="text-2xl font-bold">Rp {{ number_format(\App\Models\Pemesanan::where('status', 'selesai')->sum('total_biaya'), 0, ',', '.') }}</div>
            <div class="text-stone-500 text-sm">Pendapatan</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="text-3xl mb-2">🍽️</div>
            <div class="text-2xl font-bold">{{ \App\Models\Menu::count() }}</div>
            <div class="text-stone-500 text-sm">Menu</div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Pemesanan Terbaru -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-4 border-b font-semibold">Pemesanan Terbaru</div>
            <div class="p-4">
                @foreach(\App\Models\Pemesanan::with('user')->latest()->limit(5)->get() as $p)
                <div class="flex justify-between items-center py-2 border-b last:border-0">
                    <div>
                        <div class="font-medium">{{ $p->no_pemesanan }}</div>
                        <div class="text-xs text-stone-500">{{ $p->user->nama }}</div>
                    </div>
                    <div>
                        <span class="text-xs px-2 py-1 rounded-full 
                            @if($p->status == 'menunggu') bg-yellow-100 text-yellow-800
                            @elseif($p->status == 'disetujui') bg-blue-100 text-blue-800
                            @elseif($p->status == 'selesai') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $p->status }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Menu Populer -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="p-4 border-b font-semibold">Menu Populer</div>
            <div class="p-4">
                @php
                    $popularMenus = DB::table('detail_pemesanan_menu')
                        ->join('menu', 'menu.id', '=', 'detail_pemesanan_menu.menu_id')
                        ->select('menu.nama_menu', DB::raw('count(*) as total'))
                        ->groupBy('menu.id', 'menu.nama_menu')
                        ->orderBy('total', 'desc')
                        ->limit(5)
                        ->get();
                @endphp
                @foreach($popularMenus as $menu)
                <div class="flex justify-between items-center py-2 border-b last:border-0">
                    <span>{{ $menu->nama_menu }}</span>
                    <span class="text-sm text-amber-600">{{ $menu->total }}x dipesan</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection