<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('judul', 'Perpustakaan Iqbal')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="kepala">
        <h1>Perpustakaan Modul1 - Iqbal Hasan</h1>
        @auth
            <p style="margin: 6px 0 0 0; font-size: 14px;">
                Aktif sebagai: <b>{{ auth()->user()->name }}</b>
                <span class="badge" style="background: #00909e; margin-left: 8px; margin-bottom: 0;">
                    {{ strtoupper(auth()->user()->getRoleNames()->first() ?? 'USER') }}
                </span>
            </p>
        @endauth
    </header>

    <nav class="navigasi">
        <a href="{{ route('home') }}">Beranda</a>

        @auth
            @role('admin')
                <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
            @endrole

            @role('petugas')
                <a href="{{ route('petugas.dashboard') }}">Dashboard Petugas</a>
            @endrole

            @can('lihat daftar buku')
                <a href="{{ route('buku.index') }}">Koleksi Buku</a>
            @endcan

            @can('kelola data pengguna')
                <a href="{{ route('pengguna.index') }}">Kelola Pengguna</a>
            @endcan

            @can('kelola peminjaman')
                <a href="{{ route('peminjaman.index') }}">Peminjaman</a>
            @endcan

            @can('lihat laporan perpustakaan')
                <a href="{{ route('laporan.index') }}">Laporan</a>
            @endcan

            @role('siswa')
                <a href="{{ route('riwayat.saya') }}">Riwayat Pinjam</a>
            @endrole

            @can('lihat profil sendiri')
                <a href="{{ route('profil.saya') }}">Profil Saya</a>
            @endcan

            <form action="{{ route('logout') }}" method="POST" style="display: inline; margin-left: 10px;">
                @csrf
                <button type="submit" class="btn-aksi btn-hapus" style="padding: 6px 12px;">Logout</button>
            </form>
        @endauth

        @guest
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endguest
    </nav>

    <main class="utama">
        @if(session('sukses'))
            <div class="alert-box alert-success">{{ session('sukses') }}</div>
        @endif
        @if(session('galat'))
            <div class="alert-box alert-danger">{{ session('galat') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-box alert-warning">{{ $errors->first() }}</div>
        @endif

        @yield('konten')
    </main>

    <footer class="kaki">
        <p>&copy; 2026 - Iqbal Hasan (250441100091 - Sistem Informasi)</p>
    </footer>

    @stack('scripts')
</body>
</html>