@extends('layouts.master')
@section('judul', 'Kelola Pengguna & Role')
@section('konten')
    <h2 style="color:#142850; text-align:center; margin-bottom:20px;">Manajemen Akun & Role Pengguna</h2>
    <div class="box-crud">
        <h3 style="margin-top:0; color:#142850;">Tambah Pengguna Baru</h3>
        <form action="{{ route('pengguna.store') }}" method="POST">
            @csrf
            <div class="baris-form">
                <div class="grup-input"><label>Nama Lengkap</label><input type="text" name="name" required placeholder="Nama lengkap"></div>
                <div class="grup-input"><label>Email</label><input type="email" name="email" required placeholder="user@perpustakaan.com"></div>
                <div class="grup-input"><label>Password</label><input type="password" name="password" required placeholder="Minimal 6 karakter"></div>
                <div class="grup-input">
                    <label>Role</label>
                    <select name="role" required>
                        @foreach($roles as $r)
                            <option value="{{ $r->name }}">{{ strtoupper($r->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div style="margin-top:12px;"><button type="submit" class="btn-cari">Tambah Pengguna</button></div>
        </form>
    </div>
    <div class="box-tabel">
        <table class="tabel-api">
            <thead><tr><th>No</th><th>Nama</th><th>Email</th><th>Role Aktif</th><th>Ubah Role</th><th>Aksi</th></tr></thead>
            <tbody>
                @foreach($users as $i => $u)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><b>{{ $u->name }}</b></td>
                    <td>{{ $u->email }}</td>
                    <td><span class="badge">{{ strtoupper($u->getRoleNames()->first() ?? '-') }}</span></td>
                    <td>
                        <form action="{{ route('pengguna.role', $u->id) }}" method="POST" style="display:flex; gap:6px;">
                            @csrf @method('PUT')
                            <select name="role" style="padding:5px 8px; border:1px solid #cbd5e1; border-radius:4px;">
                                @foreach($roles as $r)
                                    <option value="{{ $r->name }}" @selected($u->hasRole($r->name))>{{ strtoupper($r->name) }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn-aksi btn-ubah">Update</button>
                        </form>
                    </td>
                    <td>
                        @if($u->id !== auth()->id())
                        <form action="{{ route('pengguna.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-aksi btn-hapus">Hapus</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
