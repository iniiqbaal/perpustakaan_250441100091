@extends('layouts.master')
@section('judul', 'Daftar Buku')
@section('konten')
    <h2 style="color: #142850; text-align: center;">Koleksi Tersedia</h2>

    {{-- SOAL 3: Form Tambah / Ubah Buku hanya muncul untuk yang diizinkan Gate 'kelola-buku' --}}
    @can('kelola-buku')
    <div id="kartu-form" class="box-crud">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <h3 id="form-title" style="margin: 0; color: #142850;">
                {{ isset($bukuEdit) ? 'Ubah Data Buku #' . $bukuEdit->id : 'Tambah Buku Baru' }}
            </h3>
            <a href="{{ route('buku.create') }}" class="tombol">+ Tambah Buku</a>
        </div>

        <form action="{{ isset($bukuEdit) ? route('buku.update', $bukuEdit->id) : route('buku.store') }}" method="POST">
            @csrf
            @if(isset($bukuEdit))
                @method('PUT')
            @endif

            <div class="baris-form">
                <div class="grup-input">
                    <label>Kategori Buku</label>
                    <select name="kategori_id" required>
                        <option value="">- Pilih Kategori -</option>
                        @foreach(\App\Models\Kategori::all() as $kat)
                            <option value="{{ $kat->id }}" @selected(old('kategori_id', $bukuEdit->kategori_id ?? '') == $kat->id)>
                                {{ $kat->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grup-input">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" value="{{ old('judul', $bukuEdit->judul ?? '') }}" placeholder="Masukkan judul buku" required>
                </div>

                <div class="grup-input">
                    <label>Penulis</label>
                    <input type="text" name="penulis" value="{{ old('penulis', $bukuEdit->penulis ?? '') }}" placeholder="Contoh: Iqbal Hasan" required>
                </div>

                <div class="grup-input">
                    <label>Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $bukuEdit->tahun_terbit ?? '') }}" placeholder="2026" required>
                </div>
            </div>

            <div style="margin-top: 12px;">
                <button type="submit" class="btn-cari" style="border-radius: 4px;">
                    {{ isset($bukuEdit) ? 'Simpan Perubahan' : 'Tambah Buku' }}
                </button>
                @if(isset($bukuEdit))
                    <a href="{{ route('buku.index') }}" class="btn-batal" style="text-decoration: none;">Batal Ubah</a>
                @endif
            </div>
        </form>
    </div>
    @endcan

    <div class="box-tabel">
        <table class="tabel-api">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kategori</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Tahun Terbit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($databuku as $item)
                <tr>
                    <td>#{{ $item->id }}</td>
                    <td><span class="badge">{{ $item->kategori->nama ?? '-' }}</span></td>
                    {{-- SOAL 2 (a): Judul buku dengan Blade Escaping {{ }} --}}
                    <td><b>{{ $item->judul }}</b></td>
                    <td>{{ $item->penulis }}</td>
                    <td>{{ $item->tahun_terbit }}</td>
                    <td>
                        <a href="{{ route('buku.show', $item->id) }}" class="btn-aksi btn-ubah">Detail</a>

                        {{-- SOAL 3: Tombol Ubah & Hapus dibungkus @can('kelola-buku') --}}
                        @can('kelola-buku')
                            <a href="{{ route('buku.edit', $item->id) }}" class="btn-aksi btn-ubah">Ubah</a>
                            <form action="{{ route('buku.destroy', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-aksi btn-hapus">Hapus</button>
                            </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Data koleksi buku belum tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <form action="{{ route('buku.index') }}" method="GET" class="form-cari">
        <input type="text" name="cari" placeholder="Cari judul atau penulis buku..." class="input-cari" value="{{ request('cari') }}">
        <button type="submit" class="btn-cari">Cari</button>
    </form>

    <div class="grid">
        @foreach($databuku as $item)
            <x-kartu :judul="$item['judul']" :penulis="$item['penulis']" :tahun="$item['tahun_terbit']" :kategori="$item->kategori->nama" :gambar="$item['gambar']">
                <a href="{{ route('buku.show', $item['id']) }}" class="tombol">Detail Buku</a>
            </x-kartu>
        @endforeach
    </div>
@endsection