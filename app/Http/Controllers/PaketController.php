<?php
// app/Http/Controllers/PaketController.php

namespace App\Http\Controllers;

use App\Models\PaketCatering;
use App\Models\Event;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = PaketCatering::with('event')
                               ->orderBy('harga_per_orang')
                               ->paginate(10);
        
        return view('admin.paket.index', compact('pakets'));
    }

    public function create()
    {
        $events = Event::where('is_active', true)->get();
        $menus = Menu::where('is_active', true)->orderBy('kategori')->get();
        
        return view('admin.paket.create', compact('events', 'menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|max:255',
            'deskripsi' => 'required',
            'event_id' => 'required|exists:event,id',
            'harga_per_orang' => 'required|numeric|min:0',
            'min_pax' => 'required|integer|min:1',
            'max_pax' => 'nullable|integer|gte:min_pax',
            'menu_items' => 'required|array',
            'includes' => 'nullable|array',
            'gambar_utama' => 'nullable|image|max:2048',
            'is_popular' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->nama_paket);

        if ($request->hasFile('gambar_utama')) {
            $path = $request->file('gambar_utama')->store('paket', 'public');
            $data['gambar_utama'] = $path;
        }

        PaketCatering::create($data);

        return redirect()->route('admin.paket.index')
                         ->with('success', 'Paket catering berhasil ditambahkan');
    }

    public function edit($id)
    {
        $paket = PaketCatering::findOrFail($id);
        $events = Event::where('is_active', true)->get();
        $menus = Menu::where('is_active', true)->orderBy('kategori')->get();
        
        return view('admin.paket.edit', compact('paket', 'events', 'menus'));
    }

    public function update(Request $request, $id)
    {
        $paket = PaketCatering::findOrFail($id);

        $request->validate([
            'nama_paket' => 'required|max:255',
            'deskripsi' => 'required',
            'event_id' => 'required|exists:event,id',
            'harga_per_orang' => 'required|numeric|min:0',
            'min_pax' => 'required|integer|min:1',
            'max_pax' => 'nullable|integer|gte:min_pax',
            'menu_items' => 'required|array',
            'includes' => 'nullable|array',
            'gambar_utama' => 'nullable|image|max:2048',
            'is_popular' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->nama_paket);

        if ($request->hasFile('gambar_utama')) {
            $path = $request->file('gambar_utama')->store('paket', 'public');
            $data['gambar_utama'] = $path;
        }

        $paket->update($data);

        return redirect()->route('admin.paket.index')
                         ->with('success', 'Paket catering berhasil diperbarui');
    }

    public function destroy($id)
    {
        $paket = PaketCatering::findOrFail($id);
        $paket->delete();

        return redirect()->route('admin.paket.index')
                         ->with('success', 'Paket catering berhasil dihapus');
    }
}