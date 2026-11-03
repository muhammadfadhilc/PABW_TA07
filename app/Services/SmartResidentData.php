<?php

namespace App\Services;

use App\Models\AdminPetugas;
use App\Models\LaporanFasilitas;
use App\Models\Warga;
use Illuminate\Support\Facades\Hash;

/**
 * Adaptor data agar semua Blade/controller Modul 3 tetap bisa dipakai.
 * Pada Modul 4 data dibaca dan disimpan menggunakan model MySQL,
 * bukan array statis/session (session hanya untuk autentikasi login).
 */
class SmartResidentData
{
    public static function warga(): array
    {
        return Warga::orderBy('id')->get()->toArray();
    }

    public static function admins(): array
    {
        return AdminPetugas::orderBy('id')->get()->toArray();
    }

    public static function reports(): array
    {
        return LaporanFasilitas::orderByDesc('tanggal_lapor')->get()
            ->map(fn (LaporanFasilitas $r) => self::reportArray($r))->all();
    }

    public static function findWarga(string $username, string $password): ?array
    {
        $warga = Warga::where('username', $username)->first();
        return $warga && Hash::check($password, $warga->password)
            ? $warga->only(['id', 'nama', 'username']) : null;
    }

    public static function addWarga(string $nama, string $username, string $password): array
    {
        $warga = Warga::create([
            'nama' => $nama,
            'username' => $username,
            'password' => Hash::make($password),
        ]);
        return $warga->only(['id', 'nama', 'username']);
    }

    public static function usernameExists(string $username): bool
    {
        return Warga::where('username', $username)->exists();
    }

    public static function findAdmin(string $username, string $password): ?array
    {
        $admin = AdminPetugas::where('username', $username)->first();
        return $admin && Hash::check($password, $admin->password)
            ? $admin->only(['id', 'nama', 'username', 'role']) : null;
    }

    public static function reportsForWarga(int $idWarga): array
    {
        return LaporanFasilitas::with('warga')->where('id_warga', $idWarga)
            ->orderByDesc('tanggal_lapor')->get()
            ->map(fn (LaporanFasilitas $r) => self::reportArray($r))->all();
    }

    public static function addReport(int $idWarga, string $tipe, string $lokasi, string $deskripsi): array
    {
        $laporan = LaporanFasilitas::create([
            'id_warga' => $idWarga,
            'tipe_fasilitas' => $tipe,
            'lokasi' => $lokasi,
            'deskripsi' => $deskripsi,
            'status' => 'Menunggu',
            'tanggal_lapor' => now(),
            'id_kontraktor' => null,
        ]);
        return self::reportArray($laporan);
    }

    public static function findReport(int $id): ?array
    {
        $laporan = LaporanFasilitas::with('warga')->find($id);
        return $laporan ? self::reportArray($laporan) : null;
    }

    public static function allReportsWithPelapor(): array
    {
        return LaporanFasilitas::with('warga')->orderByDesc('tanggal_lapor')
            ->get()->map(fn (LaporanFasilitas $r) => self::reportArray($r))->all();
    }

    public static function updateReportStatus(int $id, string $status): bool
    {
        $laporan = LaporanFasilitas::find($id);
        return $laporan ? $laporan->update(['status' => $status]) : false;
    }

    public static function deleteReport(int $id): bool
    {
        $laporan = LaporanFasilitas::find($id);
        return $laporan ? (bool) $laporan->delete() : false;
    }

    public static function addAdmin(string $nama, string $username, string $password, string $role): array
    {
        $admin = AdminPetugas::create([
            'nama' => $nama,
            'username' => $username,
            'password' => Hash::make($password),
            'role' => $role,
        ]);
        return $admin->only(['id', 'nama', 'username', 'role']);
    }

    public static function updateAdmin(int $id, string $nama, string $username, ?string $password, string $role): bool
    {
        $admin = AdminPetugas::find($id);
        if (!$admin) return false;
        $payload = compact('nama', 'username', 'role');
        if ($password !== null && $password !== '') {
            $payload['password'] = Hash::make($password);
        }
        return $admin->update($payload);
    }

    public static function deleteAdmin(int $id): bool
    {
        $admin = AdminPetugas::find($id);
        return $admin ? (bool) $admin->delete() : false;
    }

    private static function reportArray(LaporanFasilitas $laporan): array
    {
        $date = $laporan->tanggal_lapor;
        return [
            'id' => $laporan->id,
            'id_warga' => $laporan->id_warga,
            'tipe_fasilitas' => $laporan->tipe_fasilitas,
            'lokasi' => $laporan->lokasi,
            'deskripsi' => $laporan->deskripsi,
            'status' => $laporan->status,
            'tanggal_lapor' => $date ? $date->locale('id')->translatedFormat('d F Y H:i') : '',
            'id_kontraktor' => $laporan->id_kontraktor,
            'pelapor' => $laporan->warga?->nama ?? 'Warga Tidak Dikenal',
        ];
    }
}
