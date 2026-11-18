<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Buku;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $kata_kunci = $request->input('cari');
        $query = Buku::with('kategori')->latest();

        if ($kata_kunci) {
            $query->where(function ($q) use ($kata_kunci) {
                $q->where('judul', 'like', '%' . $kata_kunci . '%')
                ->orWhere('penulis', 'like', '%' . $kata_kunci . '%');
            });
        }

        $data_tampil = $query->get();

        return view('buku.index', ['databuku' => $data_tampil]);
    }

    // SOAL 3: Membuka form tambah buku (/buku/create)
    public function create()
    {
        $data_tampil = Buku::with('kategori')->latest()->get();
        return view('buku.index', ['databuku' => $data_tampil]);
    }

    // Menyimpan buku baru (POST /buku)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id'  => ['required', 'exists:kategoris,id'],
            'judul'        => ['required', 'string', 'min:3', 'max:150'],
            'penulis'      => ['required', 'string', 'min:3', 'max:100'],
            'tahun_terbit' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
        ]);

        $validated['gambar'] = 'sample.jpg';
        Buku::create($validated);

        return redirect()->route('buku.index')->with('sukses', 'Koleksi buku baru berhasil disimpan.');
    }

    public function show($id)
    {
        $detail = Buku::with('kategori')->find($id);
        return view('buku.detail', ['buku' => $detail]);
    }

    // SOAL 3: Membuka form ubah buku (/buku/{buku}/edit)
    public function edit(Buku $buku)
    {
        $data_tampil = Buku::with('kategori')->latest()->get();
        return view('buku.index', [
            'databuku' => $data_tampil,
            'bukuEdit' => $buku,
        ]);
    }

    // SOAL 3: Menyimpan perubahan buku (PUT /buku/{buku})
    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'kategori_id'  => ['required', 'exists:kategoris,id'],
            'judul'        => ['required', 'string', 'min:3', 'max:150'],
            'penulis'      => ['required', 'string', 'min:3', 'max:100'],
            'tahun_terbit' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
        ]);

        $buku->update($validated);

        return redirect()->route('buku.index')->with('sukses', 'Data koleksi buku berhasil diperbarui.');
    }

    // SOAL 2 (b): Pencarian buku aman dengan Query Binding (?)
    public function cariBuku(Request $request)
    {
        $judul = $request->query('judul');
        $data = DB::select('SELECT * FROM bukus WHERE judul = ?', [$judul]);

        return response()->json($data);
    }

    // SOAL 2 (c) & SOAL 3: Menghapus buku (DELETE /buku/{buku})
    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect()->route('buku.index')->with('sukses', 'Buku berhasil dihapus dari koleksi.');
    }
}