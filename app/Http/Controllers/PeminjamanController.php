<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Support\Facades\Gate;

class PeminjamanController extends Controller
{
    // SOAL 4 Memeriksa kepemilikan objek peminjaman dengan PeminjamanPolicy
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])->findOrFail($id);

        Gate::authorize('view', $peminjaman);

        return view('peminjaman.detail', ['peminjaman' => $peminjaman]);
    }
}