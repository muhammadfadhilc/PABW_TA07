@extends('layouts.smartresident')

@section('title', 'Dashboard Warga')
@section('subtitle', 'Riwayat Laporan Warga')

@section('content')
<div class="banner">
    <div>
        <strong>Selamat Datang Warga, {{ $warga['nama'] }}</strong>
        <div style="font-size:12px; margin-top:3px;">Pantau riwayat laporan kerusakan fasilitas desa dari halaman ini.</div>
    </div>
    <a class="btn btn-primary" href="{{ route('warga.laporan.create') }}">+ Lapor Baru</a>
</div>

<div class="toolbar">
    <div class="page-title" style="margin:0;">
        <h1 style="font-size:21px;">Riwayat Laporan Kerusakan Anda</h1>
    </div>
    <span class="muted" style="font-size:13px;">Total: {{ count($laporan) }} laporan</span>
</div>

<div class="report-grid">
    @forelse($laporan as $report)
        @include('smartresident.partials.report-card', ['report' => $report])
    @empty
        <div class="card" style="grid-column:1/-1;">Belum ada laporan. Klik <strong>Lapor Baru</strong> untuk membuat laporan pertama.</div>
    @endforelse
</div>
@endsection
