<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    
    protected $fillable = [
        'nama',
        'email',
        'nisn',
        'kelas',
        'no_absen',
    ];

    public static $rules = [
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:siswa',
        'nisn' => 'required|string|unique:siswa|max:20',
        'kelas' => 'required|string|max:50',
        'no_absen' => 'required|integer|min:1',
    ];
}
