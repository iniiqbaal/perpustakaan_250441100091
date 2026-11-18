@extends('layouts.master')
@section('judul', 'Profil Saya')
@section('konten')
    <h2 style="color:#142850; text-align:center; margin-bottom:20px;">Data Profil Pribadi</h2>
    <div class="box-crud" style="max-width:600px; margin:0 auto;">
        <p>Status Role: <span class="badge">{{ strtoupper(auth()->user()->getRoleNames()->first() ?? 'SISWA') }}</span></p>
        <form action="{{ route('profil.saya.update') }}" method="POST">
            @csrf @method('PUT')
            <div class="baris-form" style="flex-direction:column;">
                <div class="grup-input" style="flex:auto;"><label>Nama Lengkap</label><input type="text" name="name" value="{{ old('name', $user->name) }}" required></div>
                <div class="grup-input" style="flex:auto;"><label>Email</label><input type="email" name="email" value="{{ old('email', $user->email) }}" required></div>
                <div class="grup-input" style="flex:auto;"><label>No. Telepon</label><input type="text" name="no_telepon" value="{{ old('no_telepon', $anggota->no_telepon) }}"></div>
                <div class="grup-input" style="flex:auto;"><label>Password Baru (Opsional)</label><input type="password" name="password" placeholder="Kosongkan jika tidak diganti"></div>
            </div>
            @can('ubah profil sendiri')
                <div style="margin-top:15px;"><button type="submit" class="btn-cari">Simpan Perubahan Profil</button></div>
            @endcan
        </form>
    </div>
@endsection
