@extends('layouts.smartresident')

@section('title', 'Form Laporan')
@section('subtitle', 'Formulir Pengaduan Warga')

@section('content')
<div class="form-card card">
    <div class="page-title">
        <h1>Formulir Pengaduan Kerusakan Fasilitas</h1>
        <p>Lengkapi jenis fasilitas, lokasi, dan deskripsi kerusakan.</p>
    </div>

    @if($errors->any())
        <x-alert type="error" message="Semua data laporan wajib diisi dengan benar." />
    @endif

    <form method="POST" action="{{ route('warga.laporan.store') }}">
        @csrf
        <div class="field">
            <label for="tipe_fasilitas">Jenis Fasilitas Rusak</label>
            <select id="tipe_fasilitas" name="tipe_fasilitas" required>
                <option value="">-- Pilih Jenis Fasilitas --</option>
                @foreach(['Jalan Raya', 'Penerangan Jalan', 'Saluran Air', 'Lainnya'] as $jenis)
                    <option value="{{ $jenis }}" @selected(old('tipe_fasilitas') === $jenis)>{{ $jenis }}</option>
                @endforeach
            </select>
            @error('tipe_fasilitas')<div class="error-text">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="lokasi">Lokasi Kerusakan (Nama Jalan, RT/RW, Dusun)</label>
            <input id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required>
            @error('lokasi')<div class="error-text">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="deskripsi">Deskripsi Kerusakan (Jenis Kerusakan, Dampak, dll)</label>
            <textarea id="deskripsi" name="deskripsi" required>{{ old('deskripsi') }}</textarea>
            @error('deskripsi')<div class="error-text">{{ $message }}</div>@enderror
        </div>

        <div class="actions">
            <button class="btn btn-primary" type="submit">Kirim Laporan Pengaduan</button>
            <a class="btn btn-light" href="{{ route('warga.dashboard') }}">Kembali / Batal</a>
        </div>
    </form>
</div>
@endsection
