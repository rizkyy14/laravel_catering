@extends('layouts.admin')

@section('title', 'Manajemen Menu')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Manajemen Menu</h1>
    <a href="{{ route('admin.menu.create') }}" class="bg-amber-500 text-white px-4 py-2 rounded-lg hover:bg-amber-600">
        + Tambah Menu
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Menu</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($menus as $index => $menu)
            <tr>
                <td class="px-6 py-4 text-sm">{{ $index + 1 }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">{{ $menu->emoji ?? '🍽️' }}</span>
                        <span class="font-medium">{{ $menu->nama_menu }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm">{{ $menu->kategori }}</td>
                <td class="px-6 py-4 text-sm">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full {{ $menu->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $menu->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm">
                    <a href="{{ route('admin.menu.edit', $menu->id) }}" class="text-blue-600 hover:text-blue-800 mr-3">Edit</a>
                    <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection