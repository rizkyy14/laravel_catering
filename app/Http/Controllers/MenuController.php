<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('kategori')->orderBy('urutan')->get();
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
            'is_active' => 'boolean',
            'urutan' => 'nullable|integer'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->nama_menu);

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
            'is_active' => 'boolean',
            'urutan' => 'nullable|integer'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->nama_menu);

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
}