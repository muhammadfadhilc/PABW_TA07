<?php

namespace App\Http\Controllers;

use App\Models\LaporanJalan;
use App\Models\RuasJalan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

/**
 * Resource controller untuk CRUD laporan kerusakan jalan, Tugas Praktikum Modul 7.
 * Pengendalian status/verifikasi tetap dikelola RoadWatchController::status().
 */
class LaporanJalanController extends Controller
{
    private function visibleReports()
    {
        $user = Auth::user();
        $query = LaporanJalan::query();

        if ($user->role === 'warga') {
            $query->where('user_id', $user->id);
        } elseif ($user->role === 'petugas') {
            $query->where('assigned_to', $user->id);
        } else {
            abort_unless(in_array($user->role, ['admin', 'kepala_desa'], true), 403);
        }

        return $query;
    }

    private function canView(LaporanJalan $laporan): void
    {
        $user = Auth::user();

        abort_unless(
            in_array($user->role, ['admin', 'kepala_desa'], true)
            || ($user->role === 'warga' && $laporan->user_id === $user->id)
            || ($user->role === 'petugas' && $laporan->assigned_to === $user->id),
            403
        );
    }

    // Warga boleh memperbaiki/menghapus laporan sendiri selama belum diverifikasi.
    // Admin dapat mengelola setiap laporan. Petugas/Kepala Desa hanya melihat.
    private function canManage(LaporanJalan $laporan): void
    {
        $user = Auth::user();
        abort_unless(
            $user->role === 'admin'
            || ($user->role === 'warga'
                && $laporan->user_id === $user->id
                && $laporan->status === 'Menunggu Verifikasi'),
            403
        );
    }

    private function fields(): array
    {
        return [
            'jenis_kerusakan' => ['required', Rule::in(['Lubang', 'Retak', 'Ambles'])],
            'lokasi' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:2000'],
            'ruas_jalan_id' => ['nullable', 'exists:ruas_jalan,id'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ];
    }

    public function index()
    {
        $rows = $this->visibleReports()->latest()->paginate(10);
        return view('roadwatch.index', compact('rows'));
    }

    public function create()
    {
        abort_unless(Auth::user()->role === 'warga', 403);
        return view('roadwatch.create', ['ruas' => RuasJalan::orderBy('nama')->get()]);
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->role === 'warga', 403);

        $data = $request->validate($this->fields() + [
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        unset($data['foto']);
        $data['user_id'] = Auth::id();
        $data['status'] = 'Menunggu Verifikasi';
        // Simpan foto fisik ke storage/app/public/roadwatch.
        $data['foto_path'] = $request->file('foto')->store('roadwatch', 'public');

        try {
            LaporanJalan::create($data);
        } catch (\Throwable $error) {
            // Jika insert database gagal, foto yang terunggah tidak dibiarkan yatim.
            Storage::disk('public')->delete($data['foto_path']);
            throw $error;
        }

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan beserta foto berhasil ditambahkan.');
    }

    public function show(LaporanJalan $laporan)
    {
        $this->canView($laporan);
        $petugas = User::where('role', 'petugas')->orderBy('name')->get();
        return view('roadwatch.show', compact('laporan', 'petugas'));
    }

    public function edit(LaporanJalan $laporan)
    {
        $this->canManage($laporan);
        return view('roadwatch.edit', [
            'laporan' => $laporan,
            'ruas' => RuasJalan::orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, LaporanJalan $laporan)
    {
        $this->canManage($laporan);

        $data = $request->validate($this->fields() + [
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        unset($data['foto']);
        $oldPath = $laporan->foto_path;
        $newPath = null;

        if ($request->hasFile('foto')) {
            $newPath = $request->file('foto')->store('roadwatch', 'public');
            $data['foto_path'] = $newPath;
        }

        try {
            $laporan->update($data);
        } catch (\Throwable $error) {
            if ($newPath) {
                Storage::disk('public')->delete($newPath);
            }
            throw $error;
        }

        // Hapus foto sebelumnya hanya setelah pembaruan data berhasil.
        if ($newPath && $oldPath) {
            $this->removeOldFile($oldPath);
        }

        return redirect()->route('laporan.show', $laporan)
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(LaporanJalan $laporan)
    {
        $this->canManage($laporan);

        $path = $laporan->foto_path;
        $laporan->delete();

        if ($path) {
            $this->removeOldFile($path);
        }

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan dan foto berhasil dihapus.');
    }

    private function removeOldFile(string $path): void
    {
        // Kompatibilitas foto Modul 6 yang pernah disimpan pada disk local.
        Storage::disk('public')->delete($path);
        Storage::disk('local')->delete($path);
    }
}
