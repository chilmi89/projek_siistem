<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ✅ Buat roles jika belum ada
        $roleSiswa = Role::firstOrCreate(['name' => 'siswa'], ['guard_name' => 'web']);
        $roleGuru = Role::firstOrCreate(['name' => 'guru'], ['guard_name' => 'web']);

        // ✅ Buat permissions jika belum ada
        $permissions = [
            'register',
            'regis-data-input-nilai',
            'tambah mata pelajaran',
            'edit mata pelajaran',
            'hapus mata pelajaran',
            'kontrol dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission], ['guard_name' => 'web']);
        }

        // ✅ Assign permissions ke roles
        $roleSiswa->syncPermissions(['register', 'regis-data-input-nilai']);
        $roleGuru->syncPermissions([
            'tambah mata pelajaran',
            'edit mata pelajaran',
            'hapus mata pelajaran',
            'kontrol dashboard'
        ]);
    }
}
