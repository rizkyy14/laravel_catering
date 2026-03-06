<?php
// app/Http/Controllers/MenuController.php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('kategori')
                     ->orderBy('urutan')
                     ->paginate(15);
        
        return view('admin.menu.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|max:255',
            'deskripsi' => 'required',
            'harga' => 'required|numeric|min:0',
            'kategori' => 'required|in:pembuka,utama,penutup,minuman',
            'emoji' => 'nullable',
            'gambar' => 'nullable|image|max:2048',
            'bahan_bahan' => 'nullable',
            'informasi_diet' => 'nullable|array',
            'is_special' => 'boolean',
            'is_active' => 'boolean',
            'urutan' => 'nullable|integer'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->nama_menu);
        
        // Handle bahan_bahan (pisahkan dengan koma)
        if ($request->bahan_bahan) {
            $bahan = explode(',', $request->bahan_bahan);
            $data['bahan_bahan'] = json_encode(array_map('trim', $bahan));
        }
        
        // Handle gambar
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('menu', 'public');
            $data['gambar'] = $path;
        }

        Menu::create($data);

        return redirect()->route('admin.menu.index')
                         ->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama_menu' => 'required|max:255',
            'deskripsi' => 'required',
            'harga' => 'required|numeric|min:0',
            'kategori' => 'required|in:pembuka,utama,penutup,minuman',
            'emoji' => 'nullable',
            'gambar' => 'nullable|image|max:2048',
            'bahan_bahan' => 'nullable',
            'informasi_diet' => 'nullable|array',
            'is_special' => 'boolean',
            'is_active' => 'boolean',
            'urutan' => 'nullable|integer'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->nama_menu);
        
        // Handle bahan_bahan
        if ($request->bahan_bahan) {
            $bahan = explode(',', $request->bahan_bahan);
            $data['bahan_bahan'] = json_encode(array_map('trim', $bahan));
        }
        
        // Handle gambar
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('menu', 'public');
            $data['gambar'] = $path;
        }

        $menu->update($data);

        return redirect()->route('admin.menu.index')
                         ->with('success', 'Menu berhasil diperbarui');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('admin.menu.index')
                         ->with('success', 'Menu berhasil dihapus');
    }

    // API untuk mengambil menu berdasarkan kategori
    public function getByKategori($kategori)
    {
        $menus = Menu::where('kategori', $kategori)
                     ->where('is_active', true)
                     ->orderBy('urutan')
                     ->get();
        
        return response()->json($menus);
    }
}