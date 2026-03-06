<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pemesanans = $user->pemesanan()
                           ->with(['event', 'paket'])
                           ->orderBy('created_at', 'desc')
                           ->take(5)
                           ->get();
        
        return view('profile.index', compact('user', 'pemesanans'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_telepon' => 'nullable',
            'alamat' => 'nullable',
            'kota' => 'nullable',
            'foto_profil' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['nama', 'email', 'no_telepon', 'alamat', 'kota']);

        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('profiles', 'public');
            $data['foto_profil'] = $path;
        }

        $user->update($data);

        return redirect()->route('profile')
                         ->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed'
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai']);
        }

        $user->update([
            'password' => Hash::make($request->password_baru)
        ]);

        return redirect()->route('profile')
                         ->with('success', 'Password berhasil diperbarui');
    }
}