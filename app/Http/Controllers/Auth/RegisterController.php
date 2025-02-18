<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return response()
            ->view('register')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Pastikan role sudah ada
        $roleSiswa = Role::where('name', 'siswa')->first();
        if (!$roleSiswa) {
            return back()->withErrors(['role' => 'Role siswa belum tersedia. Jalankan seeder terlebih dahulu!']);
        }

        // Assign role siswa
        $user->assignRole($roleSiswa);

        // Assign permission siswa (opsional)
        $user->givePermissionTo(['register', 'regis-data-input-nilai']);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
