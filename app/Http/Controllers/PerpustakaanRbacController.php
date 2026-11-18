<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;

class PerpustakaanRbacController extends Controller
{
    public function redirectDashboard()
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->hasRole('petugas')) {
            return redirect()->route('petugas.dashboard');
        }
        return redirect()->route('buku.index');
    }

    public function adminDashboard()
    {
        return view('rbac.dashboard-admin', [
            'totalBuku'       => Buku::count(),
            'totalUser'       => User::count(),
            'totalPeminjaman' => Peminjaman::whereNull('tanggal_kembali')->count(),
            'totalKembali'    => Peminjaman::whereNotNull('tanggal_kembali')->count(),
        ]);
    }

    public function petugasDashboard()
    {
        return view('rbac.dashboard-petugas', [
            'totalBuku'       => Buku::count(),
            'totalPeminjaman' => Peminjaman::whereNull('tanggal_kembali')->count(),
            'totalKembali'    => Peminjaman::whereNotNull('tanggal_kembali')->count(),
        ]);
    }

    public function kelolaPengguna()
    {
        return view('rbac.kelola-pengguna', [
            'users' => User::with('roles')->latest()->get(),
            'roles' => Role::all(),
        ]);
    }

    public function simpanPengguna(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role'     => ['required', 'exists:roles,name'],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->syncRoles([$data['role']]);

        if ($data['role'] === 'siswa') {
            Anggota::firstOrCreate(
                ['email' => $user->email],
                ['nama' => $user->name, 'no_telepon' => '080000000000']
            );
        }

        return back()->with('sukses', 'Pengguna baru berhasil ditambahkan.');
    }

    public function ubahRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'exists:roles,name'],
        ]);

        $user->syncRoles([$request->role]);

        if ($request->role === 'siswa') {
            Anggota::firstOrCreate(
                ['email' => $user->email],
                ['nama' => $user->name, 'no_telepon' => '080000000000']
            );
        }

        return back()->with('sukses', "Role {$user->name} berhasil diperbarui menjadi {$request->role}.");
    }

    public function hapusPengguna(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('galat', 'Tidak dapat menghapus akun yang sedang digunakan.');
        }
        $user->delete();
        return back()->with('sukses', 'Akun pengguna berhasil dihapus.');
    }

    public function kelolaPeminjaman()
    {
        return view('rbac.kelola-peminjaman', [
            'peminjamans' => Peminjaman::with(['anggota', 'buku'])->latest()->get(),
            'anggotas'    => Anggota::orderBy('nama')->get(),
            'bukus'       => Buku::orderBy('judul')->get(),
        ]);
    }

    public function simpanPeminjaman(Request $request)
    {
        $data = $request->validate([
            'anggota_id'     => ['required', 'exists:anggotas,id'],
            'buku_id'        => ['required', 'exists:bukus,id'],
            'tanggal_pinjam' => ['required', 'date'],
        ]);

        Peminjaman::create([
            'anggota_id'      => $data['anggota_id'],
            'buku_id'         => $data['buku_id'],
            'tanggal_pinjam'  => $data['tanggal_pinjam'],
            'tanggal_kembali' => null,
        ]);

        return back()->with('sukses', 'Transaksi peminjaman buku berhasil disetujui.');
    }

    public function kembalikanBuku(Peminjaman $peminjaman)
    {
        $peminjaman->update([
            'tanggal_kembali' => now()->toDateString(),
        ]);

        return back()->with('sukses', 'Pengembalian buku berhasil dicatat.');
    }

    public function laporan()
    {
        return view('rbac.laporan', [
            'kategoris'   => Kategori::withCount('bukus')->get(),
            'peminjamans' => Peminjaman::with(['anggota', 'buku'])->latest()->get(),
        ]);
    }
public function riwayatSaya($userId = null)
    {
        $loginUser = Auth::user();

        $anggota = Anggota::firstOrCreate(
            ['email' => $loginUser->email],
            ['nama' => $loginUser->name, 'no_telepon' => '080000000000']
        );

        // SOAL 4 MODUL 6 (250441100091): Mengganti pemeriksaan manual Modul 5 dengan PeminjamanPolicy
        if ($userId !== null) {
            $targetUser = User::findOrFail($userId);
            $targetAnggota = Anggota::where('email', $targetUser->email)->first();
            $peminjamanTarget = new Peminjaman([
                'anggota_id' => $targetAnggota ? $targetAnggota->id : 0,
            ]);

            Gate::authorize('view', $peminjamanTarget);
        }

        $riwayat = Peminjaman::with('buku')
            ->where('anggota_id', $anggota->id)
            ->latest()
            ->get();

        return view('rbac.riwayat-saya', [
            'riwayat' => $riwayat,
            'bukus'   => Buku::orderBy('judul')->get(),
            'anggota' => $anggota,
        ]);
    }

    
    public function ajukanPinjam(Request $request)
    {
        $request->validate([
            'buku_id' => ['required', 'exists:bukus,id'],
        ]);

        $loginUser = Auth::user();
        $anggota = Anggota::firstOrCreate(
            ['email' => $loginUser->email],
            ['nama' => $loginUser->name, 'no_telepon' => '080000000000']
        );

        Peminjaman::create([
            'anggota_id'      => $anggota->id,
            'buku_id'         => $request->buku_id,
            'tanggal_pinjam'  => now()->toDateString(),
            'tanggal_kembali' => null,
        ]);

        return back()->with('sukses', 'Pengajuan peminjaman buku berhasil dikirim.');
    }

    public function profilSaya($userId = null)
    {
        $loginUser = Auth::user();

        if ($userId !== null && (int) $userId !== (int) $loginUser->id) {
            abort(403, 'Akses Ditolak: Anda hanya dapat mengakses profil milik sendiri.');
        }

        $anggota = Anggota::firstOrCreate(
            ['email' => $loginUser->email],
            ['nama' => $loginUser->name, 'no_telepon' => '080000000000']
        );

        return view('rbac.profil-saya', [
            'user'    => $loginUser,
            'anggota' => $anggota,
        ]);
    }

    public function updateProfil(Request $request)
    {
        $loginUser = Auth::user();

        $data = $request->validate([
            'name'       => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'unique:users,email,' . $loginUser->id],
            'no_telepon' => ['nullable', 'string', 'max:25'],
            'password'   => ['nullable', 'string', 'min:6'],
        ]);

        $emailLama = $loginUser->email;

        $loginUser->name  = $data['name'];
        $loginUser->email = $data['email'];
        if (!empty($data['password'])) {
            $loginUser->password = Hash::make($data['password']);
        }
        $loginUser->save();

        Anggota::updateOrCreate(
            ['email' => $emailLama],
            [
                'nama'       => $data['name'],
                'email'      => $data['email'],
                'no_telepon' => $data['no_telepon'] ?? '080000000000',
            ]
        );

        return back()->with('sukses', 'Data profil pribadi berhasil diperbarui.');
    }
}