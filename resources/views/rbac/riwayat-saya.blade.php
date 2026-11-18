@extends('layouts.master')
@section('judul', 'Riwayat Peminjaman Saya')
@section('konten')
    <h2 style="color:#142850; text-align:center; margin-bottom:20px;">Riwayat Peminjaman Saya ({{ auth()->user()->name }})</h2>
    @can('mengajukan peminjaman buku')
    <div class="box-crud">
        <h3 style="margin-top:0; color:#142850;">Ajukan Peminjaman Buku Baru</h3>
        <form action="{{ route('pinjam.ajukan') }}" method="POST">
            @csrf
            <div class="baris-form">
                <div class="grup-input">
                    <label>Pilih Buku</label>
                    <select name="buku_id" required>
                        <option value="">- Pilih Buku yang Ingin Dipinjam -</option>
                        @foreach($bukus as $b)
                            <option value="{{ $b->id }}">{{ $b->judul }} - {{ $b->penulis }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div style="margin-top:12px;"><button type="submit" class="btn-cari">Ajukan Peminjaman</button></div>
        </form>
    </div>
    @endcan
    <div class="box-tabel">
        <table class="tabel-api">
            <thead><tr><th>No</th><th>Judul Buku</th><th>Tanggal Pinjam</th><th>Status Peminjaman</th></tr></thead>
            <tbody>
                @forelse($riwayat as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><b>{{ $r->buku->judul ?? '-' }}</b></td>
                    <td>{{ $r->tanggal_pinjam }}</td>
                    <td>
                        @if($r->tanggal_kembali)
                            <span class="badge" style="background:#28a745;">Sudah Dikembalikan ({{ $r->tanggal_kembali }})</span>
                        @else
                            <span class="badge" style="background:#f0ad4e;">Sedang Dipinjam</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;">Belum ada riwayat peminjaman untuk akun Anda.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
