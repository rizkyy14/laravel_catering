<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'no_telepon' => 'nullable',
            'alamat' => 'nullable',
            'kota' => 'nullable',
            'role' => 'required|in:admin,staff,pelanggan',
            'foto_profil' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('profiles', 'public');
            $data['foto_profil'] = $path;
        }

        User::create($data);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'no_telepon' => 'nullable',
            'alamat' => 'nullable',
            'kota' => 'nullable',
            'role' => 'required|in:admin,staff,pelanggan',
            'foto_profil' => 'nullable|image|max:2048'
        ]);

        $data = $request->except('password');
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('profiles', 'public');
            $data['foto_profil'] = $path;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Cegah hapus admin utama
        if ($user->email === 'admin@lumina.com') {
            return redirect()->back()->with('error', 'Tidak dapat menghapus admin utama');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil dihapus');
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role' => 'required|in:admin,staff,pelanggan'
        ]);

        $user->update(['role' => $request->role]);

        return response()->json([
            'success' => true,
            'message' => 'Role user berhasil diperbarui'
        ]);
    }
}