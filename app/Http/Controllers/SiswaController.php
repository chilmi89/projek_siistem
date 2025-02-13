<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar siswa.
     */
    public function index()
    {
        $siswas = Siswa::all();
        return view('data_siswa', compact('siswas')); // Tidak dalam folder siswa
    }

    /**
     * Menampilkan form untuk menambahkan data siswa.
     */
    public function create()
    {
        return view('data_siswa'); // Pastikan file ini ada di resources/views/
    }

    /**
     * Menyimpan data siswa yang baru dibuat ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:siswa,email',
            'nisn' => 'required|string|unique:siswa,nisn',
            'kelas' => 'required|string|max:255',
            'no_absen' => 'required|integer',
        ]);

        // Simpan data siswa ke database
        Siswa::create($validated);

        // Redirect ke halaman daftar siswa dengan pesan sukses
        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }
}
