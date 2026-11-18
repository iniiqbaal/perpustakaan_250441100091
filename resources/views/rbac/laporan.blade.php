@extends('layouts.master')
@section('judul', 'Laporan Perpustakaan')
@section('konten')
    <h2 style="color:#142850; text-align:center; margin-bottom:20px;">Laporan Rekapitulasi Perpustakaan</h2>
    <div class="box-tabel">
        <table class="tabel-api">
            <thead><tr><th>No</th><th>Nama Kategori</th><th>Total Koleksi Buku</th></tr></thead>
            <tbody>
                @foreach($kategoris as $i => $k)
                    <tr><td>{{ $i + 1 }}</td><td><b>{{ $k->nama }}</b></td><td><span class="badge">{{ $k->bukus_count }} Buku</span></td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="box-tabel">
        <table class="tabel-api">
            <thead><tr><th>No</th><th>Peminjam</th><th>Judul Buku</th><th>Tanggal Pinjam</th><th>Tanggal Kembali</th></tr></thead>
            <tbody>
                @foreach($peminjamans as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->anggota->nama ?? '-' }}</td>
                    <td><b>{{ $p->buku->judul ?? '-' }}</b></td>
                    <td>{{ $p->tanggal_pinjam }}</td>
                    <td>{{ $p->tanggal_kembali ?? 'Masih Dipinjam' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
