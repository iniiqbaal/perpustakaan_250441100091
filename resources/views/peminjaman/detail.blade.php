@extends('layouts.master')
@section('judul', 'Rincian Peminjaman')
@section('konten')
    <div class="box-detail">
        <h2 style="margin-top: 0; color: #142850;">Rincian Transaksi Peminjaman #{{ $peminjaman->id }}</h2>
        <hr>
        <p>ID Transaksi: <b>#{{ $peminjaman->id }}</b></p>
        <p>Nama Peminjam: <b>{{ $peminjaman->anggota->nama ?? '-' }}</b></p>
        <p>Email Anggota: <b>{{ $peminjaman->anggota->email ?? '-' }}</b></p>
        <p>Judul Buku: <b>{{ $peminjaman->buku->judul ?? '-' }}</b></p>
        <p>Tanggal Pinjam: <b>{{ $peminjaman->tanggal_pinjam }}</b></p>
        <p>Status Peminjaman: 
            @if($peminjaman->tanggal_kembali)
                <span class="badge" style="background:#28a745;">Sudah Kembali ({{ $peminjaman->tanggal_kembali }})</span>
            @else
                <span class="badge" style="background:#f0ad4e;">Sedang Dipinjam</span>
            @endif
        </p>
        <br>
        <a href="{{ route('buku.index') }}" class="tombol">Kembali</a>
    </div>
@endsection