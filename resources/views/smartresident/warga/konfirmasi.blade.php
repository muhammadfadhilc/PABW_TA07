@extends('layouts.smartresident')

@section('title', 'Konfirmasi Laporan')
@section('subtitle', 'Konfirmasi Pelaporan Berhasil')

@section('content')
<div class="confirm card">
    <x-alert type="success" message="Laporan berhasil terkirim dan masuk ke antrian petugas desa." />
    <div class="check">✓</div>
    <h1 style="margin:0; color:var(--slate-900);">Laporan Berhasil Terkirim!</h1>
    <p class="muted" style="line-height:1.65;">Terima kasih atas partisipasi Anda dalam menjaga fasilitas desa. Berikut nomor tiket laporan Anda:</p>
    <div class="ticket">TKT-{{ str_pad((string) $laporan['id'], 5, '0', STR_PAD_LEFT) }}</div>
    <p class="muted">Simpan nomor tiket untuk memudahkan pengecekan laporan.</p>

    <dl class="details">
        <dt>Jenis Fasilitas</dt><dd>{{ $laporan['tipe_fasilitas'] }}</dd>
        <dt>Lokasi</dt><dd>{{ $laporan['lokasi'] }}</dd>
        <dt>Status</dt><dd>@include('smartresident.partials.status-badge', ['status' => $laporan['status']])</dd>
    </dl>

    <a class="btn btn-primary" href="{{ route('warga.dashboard') }}">Selesai</a>
</div>
@endsection
