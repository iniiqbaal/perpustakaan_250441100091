<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // // 1. Akun Admin
        // $admin = User::firstOrCreate(
        //     ['email' => 'admin@perpustakaan.com'],
        //     [
        //         'name' => 'Iqbal Hasan (Admin)',
        //         'password' => Hash::make('password123'),
        //     ]
        // );
        // $admin->syncRoles(['admin']);


        // SOAL 5c: Mengganti password bawaan seeder
    $admin = User::updateOrCreate(
        ['email' => 'admin@perpustakaan.com'],
        [
            'name' => 'Iqbal Hasan (Admin)',
            'password' => Hash::make('AdminIqbal#250441100091'),
        ]
    );
    $admin->syncRoles(['admin']);



        // 2. Akun Petugas
        $petugas = User::firstOrCreate(
            ['email' => 'petugas@perpustakaan.com'],
            [
                'name' => 'Petugas Perpustakaan',
                'password' => Hash::make('password123'),
            ]
        );
        $petugas->syncRoles(['petugas']);

        // 3. Akun Siswa 1
        $siswa1 = User::firstOrCreate(
            ['email' => 'siswa@perpustakaan.com'],
            [
                'name' => 'Siswa Iqbal',
                'password' => Hash::make('password123'),
            ]
        );
        $siswa1->syncRoles(['siswa']);

        $anggota1 = Anggota::firstOrCreate(
            ['email' => $siswa1->email],
            ['nama' => $siswa1->name, 'no_telepon' => '081234567891']
        );

        // 4. Akun Siswa
        $siswa2 = User::firstOrCreate(
            ['email' => 'siswa2@perpustakaan.com'],
            [
                'name' => 'Siswa Kedua',
                'password' => Hash::make('password123'),
            ]
        );
        $siswa2->syncRoles(['siswa']);

        $anggota2 = Anggota::firstOrCreate(
            ['email' => $siswa2->email],
            ['nama' => $siswa2->name, 'no_telepon' => '085678901234']
        );

        $bukuSample = Buku::first();
        if ($bukuSample) {
            Peminjaman::firstOrCreate([
                'anggota_id' => $anggota1->id,
                'buku_id' => $bukuSample->id,
                'tanggal_pinjam' => now()->subDays(2)->toDateString(),
            ], [
                'tanggal_kembali' => null,
            ]);

            Peminjaman::firstOrCreate([
                'anggota_id' => $anggota2->id,
                'buku_id' => $bukuSample->id,
                'tanggal_pinjam' => now()->subDays(6)->toDateString(),
            ], [
                'tanggal_kembali' => now()->subDay()->toDateString(),
            ]);
        }
    }
}