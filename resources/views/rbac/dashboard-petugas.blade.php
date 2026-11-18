@extends('layouts.master')
@section('judul', 'Dashboard Petugas')
@section('konten')
    <div class="banner" style="padding: 25px; margin-bottom: 20px;">
        <h2 style="margin:0; font-size:24px;">Dashboard Operasional Petugas</h2>
        <p style="margin:8px 0 0 0;">Halo, <b>{{ auth()->user()->name }}</b>. Anda bertugas mengelola buku, transaksi peminjaman, pengembalian, dan laporan.</p>
    </div>
    <div class="grid" style="margin-bottom: 25px;">
        <div class="kartu" style="text-align:center;"><h3>Total Buku</h3><p style="font-size:28px; font-weight:bold; color:#142850;">{{ $totalBuku }}</p></div>
        <div class="kartu" style="text-align:center;"><h3>Sedang Dipinjam</h3><p style="font-size:28px; font-weight:bold; color:#f0ad4e;">{{ $totalPeminjaman }}</p></div>
        <div class="kartu" style="text-align:center;"><h3>Sudah Kembali</h3><p style="font-size:28px; font-weight:bold; color:#28a745;">{{ $totalKembali }}</p></div>
    </div>
    <div class="box-detail" style="text-align:center;">
        @can('kelola data buku')<a href="{{ route('buku.index') }}" class="tombol" style="margin:5px;">Kelola Koleksi Buku</a>@endcan
        @can('kelola peminjaman')<a href="{{ route('peminjaman.index') }}" class="tombol" style="margin:5px;">Proses Peminjaman & Pengembalian</a>@endcan
        @can('lihat laporan perpustakaan')<a href="{{ route('laporan.index') }}" class="tombol" style="margin:5px;">Lihat Laporan</a>@endcan
    </div>
@endsection
