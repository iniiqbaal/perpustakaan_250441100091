@extends('layouts.master')
@section('judul', 'Detail Buku')
@section('konten')
    <div class="box-detail">
        @if($buku)
            <img src="{{ asset('img/' . $buku['gambar']) }}" alt="{{ $buku['judul'] }}" class="img-detail">
            
            <h2 style="margin-top: 0;">{{ $buku['judul'] }}</h2>
            <hr>
            <p>ID Buku: <b>{{ $buku['id'] }}</b></p>
            <p>Penulis: <b>{{ $buku['penulis'] }}</b></p>
            <p>Tahun Rilis: <b>{{ $buku['tahun_terbit'] }}</b></p>
            <p>Kategori: <b>{{ $buku->kategori->nama }}</b></p>
            <br>
            <a href="{{ route('buku.index') }}" class="tombol">Kembali</a>
        @else
            <h2 style="color: red;">Error 404</h2>
            <p>Buku yang kamu cari nggak ada di data kami.</p>
            <br>
            <a href="{{ route('buku.index') }}" class="tombol">Kembali</a>
        @endif
    </div>
@endsection