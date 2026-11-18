@extends('layouts.master')
@section('judul', 'Peminjaman & Pengembalian')
@section('konten')
    <h2 style="color:#142850; text-align:center; margin-bottom:20px;">Transaksi Peminjaman & Pengembalian Buku</h2>
    <div class="box-crud">
        <h3 style="margin-top:0; color:#142850;">Catat & Setujui Peminjaman Baru</h3>
        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf
            <div class="baris-form">
                <div class="grup-input">
                    <label>Anggota / Siswa</label>
                    <select name="anggota_id" required>
                        <option value="">- Pilih Anggota -</option>
                        @foreach($anggotas as $a)
                            <option value="{{ $a->id }}">{{ $a->nama }} ({{ $a->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="grup-input">
                    <label>Buku yang Dipinjam</label>
                    <select name="buku_id" required>
                        <option value="">- Pilih Buku -</option>
                        @foreach($bukus as $b)
                            <option value="{{ $b->id }}">{{ $b->judul }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grup-input">
                    <label>Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>
            <div style="margin-top:12px;"><button type="submit" class="btn-cari">Setujui Peminjaman</button></div>
        </form>
    </div>
    <div class="box-tabel">
        <table class="tabel-api">
            <thead><tr><th>No</th><th>Nama Peminjam</th><th>Judul Buku</th><th>Tgl Pinjam</th><th>Status</th><th>Aksi Pengembalian</th></tr></thead>
            <tbody>
                @foreach($peminjamans as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><b>{{ $p->anggota->nama ?? '-' }}</b></td>
                    <td>{{ $p->buku->judul ?? '-' }}</td>
                    <td>{{ $p->tanggal_pinjam }}</td>
                    <td>
                        @if($p->tanggal_kembali)
                            <span class="badge" style="background:#28a745;">Kembali ({{ $p->tanggal_kembali }})</span>
                        @else
                            <span class="badge" style="background:#f0ad4e;">Dipinjam</span>
                        @endif
                    </td>
                    <td>
                        @if(!$p->tanggal_kembali)
                        <form action="{{ route('peminjaman.kembali', $p->id) }}" method="POST">
                            @csrf @method('PUT')
                            <button type="submit" class="btn-aksi btn-ubah">Catat Kembali</button>
                        </form>
                        @else
                            Selesai
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
