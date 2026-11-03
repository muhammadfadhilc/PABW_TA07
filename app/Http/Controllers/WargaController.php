<?php

namespace App\Http\Controllers;

use App\Services\SmartResidentData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WargaController extends Controller
{
    private function currentWarga(): ?array
    {
        return session('smartresident_user');
    }

    private function requireWarga(): ?RedirectResponse
    {
        return $this->currentWarga() ? null : redirect()->route('warga.login')->with('error', 'Silakan login sebagai warga terlebih dahulu.');
    }

    public function dashboard(): View|RedirectResponse
    {
        if ($redirect = $this->requireWarga()) {
            return $redirect;
        }

        $warga = $this->currentWarga();
        $laporan = SmartResidentData::reportsForWarga($warga['id']);

        return view('smartresident.warga.dashboard', compact('warga', 'laporan'));
    }

    public function createReport(): View|RedirectResponse
    {
        if ($redirect = $this->requireWarga()) {
            return $redirect;
        }

        return view('smartresident.warga.form-laporan');
    }

    public function storeReport(Request $request): RedirectResponse
    {
        if ($redirect = $this->requireWarga()) {
            return $redirect;
        }

        $data = $request->validate([
            'tipe_fasilitas' => ['required', 'in:Jalan Raya,Penerangan Jalan,Saluran Air,Lainnya'],
            'lokasi' => ['required', 'string', 'max:150'],
            'deskripsi' => ['required', 'string', 'max:1000'],
        ]);

        $warga = $this->currentWarga();
        $laporan = SmartResidentData::addReport(
            $warga['id'],
            $data['tipe_fasilitas'],
            $data['lokasi'],
            $data['deskripsi'],
        );

        return redirect()->route('warga.laporan.konfirmasi', $laporan['id']);
    }

    public function confirmation(int $id): View|RedirectResponse
    {
        if ($redirect = $this->requireWarga()) {
            return $redirect;
        }

        $laporan = SmartResidentData::findReport($id);
        $warga = $this->currentWarga();

        if (!$laporan || $laporan['id_warga'] !== $warga['id']) {
            return redirect()->route('warga.dashboard')->with('error', 'Laporan tidak ditemukan.');
        }

        return view('smartresident.warga.konfirmasi', compact('laporan'));
    }
}
