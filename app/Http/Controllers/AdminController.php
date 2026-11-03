<?php

namespace App\Http\Controllers;

use App\Services\SmartResidentData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    private function currentAdmin(): ?array
    {
        return session('smartresident_admin');
    }

    private function requireAdmin(): ?RedirectResponse
    {
        return $this->currentAdmin() ? null : redirect()->route('admin.login')->with('error', 'Silakan login sebagai petugas terlebih dahulu.');
    }

    public function dashboard(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $admin = $this->currentAdmin();
        $filter = $request->query('status', 'Semua');
        $laporan = SmartResidentData::allReportsWithPelapor();

        if (in_array($filter, ['Menunggu', 'Diproses', 'Selesai'], true)) {
            $laporan = array_values(array_filter($laporan, fn (array $r) => $r['status'] === $filter));
        }

        return view('smartresident.admin.dashboard', compact('admin', 'laporan', 'filter'));
    }

    public function detail(int $id): View|RedirectResponse
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $laporan = SmartResidentData::findReport($id);
        if (!$laporan) {
            return redirect()->route('admin.dashboard')->with('error', 'Laporan tidak ditemukan.');
        }

        return view('smartresident.admin.detail-laporan', compact('laporan'));
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $data = $request->validate([
            'status' => ['required', 'in:Menunggu,Diproses,Selesai'],
        ]);

        SmartResidentData::updateReportStatus($id, $data['status']);

        return redirect()->route('admin.laporan.detail', $id)->with('success', 'Status laporan berhasil diperbarui.');
    }

    public function deleteReport(int $id): RedirectResponse
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        SmartResidentData::deleteReport($id);
        return redirect()->route('admin.dashboard')->with('success', 'Laporan berhasil dihapus.');
    }

    public function manage(): View|RedirectResponse
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $admin = $this->currentAdmin();
        $admins = SmartResidentData::admins();

        return view('smartresident.admin.manajemen', compact('admin', 'admins'));
    }

    public function createAdmin(Request $request): RedirectResponse
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', Rule::unique('admins_v2', 'username')],
            'password' => ['required', 'string', 'min:4'],
            'role' => ['required', 'in:admin,superadmin,kontraktor'],
        ]);

        SmartResidentData::addAdmin($data['nama'], $data['username'], $data['password'], $data['role']);
        return redirect()->route('admin.manajemen')->with('success', 'Akun petugas berhasil ditambahkan.');
    }

    public function updateAdmin(Request $request, int $id): RedirectResponse
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', Rule::unique('admins_v2', 'username')->ignore($id)],
            'password' => ['nullable', 'string', 'min:4'],
            'role' => ['required', 'in:admin,superadmin,kontraktor'],
        ]);

        SmartResidentData::updateAdmin($id, $data['nama'], $data['username'], $data['password'] ?? null, $data['role']);
        return redirect()->route('admin.manajemen')->with('success', 'Data petugas berhasil diubah.');
    }

    public function deleteAdmin(int $id): RedirectResponse
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        if ($this->currentAdmin()['id'] === $id) {
            return back()->with('error', 'Akun yang sedang digunakan tidak dapat dihapus.');
        }

        SmartResidentData::deleteAdmin($id);
        return redirect()->route('admin.manajemen')->with('success', 'Akun petugas berhasil dihapus.');
    }
}
