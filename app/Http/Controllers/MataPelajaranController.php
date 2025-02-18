<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataPelajaran;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class MataPelajaranController extends Controller
{
    // Menampilkan semua data mata pelajaran

    /**
     * Menampilkan semua data mata pelajaran
     */
    public function index()
    {
        try {
            $mataPelajaran = MataPelajaran::all();
            return view('Admin.dashboard_admin_2', compact('mataPelajaran'));
        } catch (\Exception $e) {
            Log::error('Error pada halaman index mata pelajaran: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data.');
        }
    }

    /**
     * Menyimpan data mata pelajaran baru
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'nama_mapel' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'bobot' => 'required|numeric|min:0|max:100',
            ], [
                'nama_mapel.required' => 'Nama mata pelajaran wajib diisi.',
                'nama_mapel.max' => 'Nama mata pelajaran maksimal 255 karakter.',
                'bobot.required' => 'Bobot wajib diisi.',
                'bobot.numeric' => 'Bobot harus berupa angka.',
                'bobot.min' => 'Bobot minimal 0.',
                'bobot.max' => 'Bobot maksimal 100.',
            ]);

            // Simpan data
            MataPelajaran::create([
                'nama_mapel' => $validated['nama_mapel'],
                'deskripsi' => $validated['deskripsi'] ?? 'Tidak ada deskripsi',
                'bobot' => $validated['bobot'],
            ]);

            return redirect()->route('mata-pelajaran.index')
                ->with('success', 'Data mata pelajaran berhasil ditambahkan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Gagal menambahkan data. Periksa kembali input Anda.');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan mata pelajaran: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    /**
     * Mengupdate data mata pelajaran
     */
    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'nama_mapel' => 'required|string|max:255',
                'bobot' => 'required|numeric|min:0|max:100',
                'deskripsi' => 'nullable|string',
            ], [
                'nama_mapel.required' => 'Nama mata pelajaran wajib diisi.',
                'nama_mapel.max' => 'Nama mata pelajaran maksimal 255 karakter.',
                'bobot.required' => 'Bobot wajib diisi.',
                'bobot.numeric' => 'Bobot harus berupa angka.',
                'bobot.min' => 'Bobot minimal 0.',
                'bobot.max' => 'Bobot maksimal 100.',
            ]);

            // Cari dan update data
            $mataPelajaran = MataPelajaran::findOrFail($id);
            $mataPelajaran->update([
                'nama_mapel' => $validated['nama_mapel'],
                'bobot' => $validated['bobot'],
                'deskripsi' => $validated['deskripsi'] ?? $mataPelajaran->deskripsi,
            ]);

            return redirect()->route('mata-pelajaran.index')
                ->with('success', 'Data mata pelajaran berhasil diperbarui!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()
                ->with('error', 'Data mata pelajaran tidak ditemukan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Gagal memperbarui data. Periksa kembali input Anda.');
        } catch (\Exception $e) {
            Log::error('Error saat mengupdate mata pelajaran: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    /**
     * Menghapus data mata pelajaran
     */
    public function destroy($id)
    {
        try {
            $mataPelajaran = MataPelajaran::findOrFail($id);
            $mataPelajaran->delete();

            return redirect()->route('mata-pelajaran.index')
                ->with('success', 'Data mata pelajaran berhasil dihapus!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()
                ->with('error', 'Data mata pelajaran tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error saat menghapus mata pelajaran: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
