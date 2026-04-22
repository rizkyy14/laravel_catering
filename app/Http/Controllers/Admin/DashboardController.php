<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // HAPUS constructor middleware, karena kita pakai di routes
    
    public function index()
    {
        // Cek apakah user admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak');
        }
        
        return view('admin.dashboard');
    }
}