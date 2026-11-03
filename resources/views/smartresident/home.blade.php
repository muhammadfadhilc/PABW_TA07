@extends('layouts.smartresident')

@section('title', 'Beranda')
@section('subtitle', 'Kiosk Pelayanan Mandiri Warga')

@section('content')
<div class="hero">
    <section class="hero-left">
        <img src="{{ asset('logo.png') }}" alt="Logo SmartResident">
        <h1>SmartResident</h1>
        <p>Kiosk Pelayanan Mandiri Warga</p>
    </section>
    <section class="hero-right">
        <h2>Selamat Datang Warga Desa</h2>
        <div class="intro">
            SmartResident Kiosk adalah fasilitas mandiri pelaporan infrastruktur desa. Silakan masuk sebagai warga untuk membuat pengaduan baru atau memeriksa riwayat status laporan. Jika belum memiliki akun, lakukan registrasi terlebih dahulu.
        </div>
        <div class="hero-actions">
            <a class="btn btn-soft" href="{{ route('warga.login') }}">Masuk / Login Warga</a>
            <a class="btn btn-primary" href="{{ route('warga.register') }}">Daftar Akun Baru</a>
            <a class="btn btn-light" href="{{ route('admin.login') }}">Portal Petugas Desa</a>
        </div>
        <p class="muted" style="text-align:center; margin:22px 0 0; font-size:12px; font-weight:700;">• PILIH MENU DI ATAS UNTUK MEMULAI •</p>
    </section>
</div>
@endsection
