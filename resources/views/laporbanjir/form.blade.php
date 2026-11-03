@extends('layouts.app')

@section('title', 'Form Pelaporan')

@section('content')
<div class="page-heading">
    <h1>Form Pelaporan Banjir</h1>
    <p>Isi data kejadian banjir secara singkat. Laporan akan dikirim melalui method POST dan ditampilkan kembali pada halaman konfirmasi.</p>
</div>

<div class="card" style="max-width: 720px;">
    @if($errors->any())
        <x-alert type="error" message="Masih ada data yang belum benar. Silakan periksa kembali form." />
    @endif

    <form method="POST" action="{{ route('banjir.store') }}">
        @csrf
        <div class="field">
            <label for="nama_pelapor">Nama Pelapor</label>
            <input id="nama_pelapor" name="nama_pelapor" value="{{ old('nama_pelapor') }}" placeholder="Contoh: Muhammad Fadhil" required>
            @error('nama_pelapor')<div class="error-text">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="lokasi">Lokasi Kejadian</label>
            <input id="lokasi" name="lokasi" value="{{ old('lokasi') }}" placeholder="Nama jalan, desa/kecamatan, atau patokan lokasi" required>
            @error('lokasi')<div class="error-text">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="tinggi_air">Tinggi Genangan Air (cm)</label>
            <input id="tinggi_air" name="tinggi_air" type="number" min="0" max="500" value="{{ old('tinggi_air') }}" placeholder="Contoh: 45" required>
            @error('tinggi_air')<div class="error-text">{{ $message }}</div>@enderror
        </div>

        <div class="actions">
            <button class="btn btn-primary" type="submit">Kirim Laporan</button>
            <a class="btn btn-secondary" href="{{ route('banjir.index') }}">Lihat Daftar Laporan</a>
        </div>
    </form>
</div>
@endsection
