<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MataPelajaran;

class AdminController extends Controller
{
    public function index()
    {
        // Mengambil data untuk ditampilkan di dashboard
        $totalGuru = User::where('role', 'guru')->count();
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalMapel = MataPelajaran::count();

        return view('admin.dashboard_admin_2', compact('totalGuru', 'totalSiswa', 'totalMapel'));
    }
}