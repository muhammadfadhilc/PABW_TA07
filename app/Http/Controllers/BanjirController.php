<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BanjirController extends Controller
{
    public function form(): View
    {
        return view('laporbanjir.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_pelapor' => ['required', 'string', 'max:100'],
            'lokasi' => ['required', 'string', 'max:150'],
            'tinggi_air' => ['required', 'numeric', 'min:0', 'max:500'],
        ]);

        $laporan = [
            'id' => 'LB-'.str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT),
            'nama_pelapor' => $data['nama_pelapor'],
            'lokasi' => $data['lokasi'],
            'tinggi_air' => (int) $data['tinggi_air'],
            'waktu' => now()->locale('id')->translatedFormat('d F Y, H:i'),
        ];

        session()->put('banjir_laporan_terakhir', $laporan);

        return redirect()->route('banjir.konfirmasi');
    }

    public function confirmation(): View
    {
        $laporan = session('banjir_laporan_terakhir');

        return view('laporbanjir.konfirmasi', compact('laporan'));
    }

    public function index(): View
    {
        $laporan = [
            ['id' => 'LB-0001', 'nama_pelapor' => 'Dimas Pratama', 'lokasi' => 'Dayeuhkolot, Jl. Raya Bojongsoang', 'tinggi_air' => 22, 'waktu' => '07 Oktober 2026, 07:10'],
            ['id' => 'LB-0002', 'nama_pelapor' => 'Siti Rahma', 'lokasi' => 'Baleendah, Andir', 'tinggi_air' => 48, 'waktu' => '07 Oktober 2026, 07:35'],
            ['id' => 'LB-0003', 'nama_pelapor' => 'Raka Nugraha', 'lokasi' => 'Banjaran, dekat Pasar', 'tinggi_air' => 92, 'waktu' => '07 Oktober 2026, 08:05'],
        ];

        if (session()->has('banjir_laporan_terakhir')) {
            array_unshift($laporan, session('banjir_laporan_terakhir'));
        }

        return view('laporbanjir.index', compact('laporan'));
    }
}
