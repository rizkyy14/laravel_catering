<?php
// app/Http/Controllers/EventController.php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('urutan')->paginate(10);
        return view('admin.event.index', compact('events'));
    }

    public function create()
    {
        return view('admin.event.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_event' => 'required|max:255',
            'deskripsi' => 'required',
            'tipe_event' => 'required|in:pernikahan,kantor,ulang_tahun,pribadi,lainnya',
            'harga_min_per_orang' => 'required|numeric|min:0',
            'harga_max_per_orang' => 'required|numeric|min:0|gte:harga_min_per_orang',
            'fitur' => 'nullable|array',
            'gambar_utama' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'urutan' => 'nullable|integer'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->nama_event);

        if ($request->hasFile('gambar_utama')) {
            $path = $request->file('gambar_utama')->store('events', 'public');
            $data['gambar_utama'] = $path;
        }

        Event::create($data);

        return redirect()->route('admin.event.index')
                         ->with('success', 'Event berhasil ditambahkan');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.event.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'nama_event' => 'required|max:255',
            'deskripsi' => 'required',
            'tipe_event' => 'required|in:pernikahan,kantor,ulang_tahun,pribadi,lainnya',
            'harga_min_per_orang' => 'required|numeric|min:0',
            'harga_max_per_orang' => 'required|numeric|min:0|gte:harga_min_per_orang',
            'fitur' => 'nullable|array',
            'gambar_utama' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'urutan' => 'nullable|integer'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->nama_event);

        if ($request->hasFile('gambar_utama')) {
            $path = $request->file('gambar_utama')->store('events', 'public');
            $data['gambar_utama'] = $path;
        }

        $event->update($data);

        return redirect()->route('admin.event.index')
                         ->with('success', 'Event berhasil diperbarui');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.event.index')
                         ->with('success', 'Event berhasil dihapus');
    }
}