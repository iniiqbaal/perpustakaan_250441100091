@extends('layouts.master')
@section('judul', 'Dashboard Admin')
@section('konten')
    <div class="banner" style="padding: 25px; margin-bottom: 20px;">
        <h2 style="margin:0; font-size:24px;">Panel Kendali Administrator</h2>
        <p style="margin:8px 0 0 0;">Selamat datang, <b>{{ auth()->user()->name }}</b>. Anda memiliki hak akses penuh mengelola seluruh sistem perpustakaan.</p>
    </div>
    <div class="grid" style="margin-bottom: 25px;">
        <div class="kartu" style="text-align:center;"><h3>Total Koleksi Buku</h3><p style="font-size:28px; font-weight:bold; color:#142850;">{{ $totalBuku }}</p></div>
        <div class="kartu" style="text-align:center;"><h3>Total Akun User</h3><p style="font-size:28px; font-weight:bold; color:#00909e;">{{ $totalUser }}</p></div>
        <div class="kartu" style="text-align:center;"><h3>Peminjaman Aktif</h3><p style="font-size:28px; font-weight:bold; color:#f0ad4e;">{{ $totalPeminjaman }}</p></div>
    </div>
    <div class="box-detail" style="text-align:center;">
        @can('kelola data buku')<a href="{{ route('buku.index') }}" class="tombol" style="margin:5px;">Kelola Data Buku</a>@endcan
        @can('kelola data pengguna')<a href="{{ route('pengguna.index') }}" class="tombol" style="margin:5px;">Kelola Pengguna & Role</a>@endcan
        @can('kelola peminjaman')<a href="{{ route('peminjaman.index') }}" class="tombol" style="margin:5px;">Peminjaman & Pengembalian</a>@endcan
        @can('lihat laporan perpustakaan')<a href="{{ route('laporan.index') }}" class="tombol" style="margin:5px;">Laporan Perpustakaan</a>@endcan
    </div>
@endsection
