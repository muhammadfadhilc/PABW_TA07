@extends('layouts.app')

@section('title', 'Konfirmasi Laporan')

@section('content')
<div class="confirmation card">
    @if($laporan)
        <x-alert type="success" message="Laporan banjir berhasil dikirim dan data telah diterima oleh sistem." />
        <h1 style="margin: 4px 0 5px; color:#12364a;">Laporan Berhasil Dikirim</h1>
        <p style="color:#64748b; line-height:1.6;">Berikut ringkasan data yang Anda kirimkan.</p>
        <div class="confirm-value">{{ $laporan['id'] }}</div>
        <div style="text-align:left; background:#f8fafc; border-radius:10px; padding:15px 18px; line-height:1.8;">
            <strong>Nama Pelapor:</strong> {{ $laporan['nama_pelapor'] }}<br>
            <strong>Lokasi:</strong> {{ $laporan['lokasi'] }}<br>
            <strong>Tinggi Air:</strong> {{ $laporan['tinggi_air'] }} cm<br>
            <strong>Waktu:</strong> {{ $laporan['waktu'] }}
        </div>
    @else
        <x-alert type="warning" message="Belum ada laporan yang baru dikirim. Silakan isi form terlebih dahulu." />
    @endif

    <div class="actions" style="justify-content:center; margin-top:20px;">
        <a class="btn btn-primary" href="{{ route('banjir.form') }}">Buat Laporan Baru</a>
        <a class="btn btn-secondary" href="{{ route('banjir.index') }}">Daftar Laporan</a>
    </div>
</div>
@endsection
