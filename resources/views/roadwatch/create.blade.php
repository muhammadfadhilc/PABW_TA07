@extends('layouts.app')
@section('title', 'Tambah Laporan')
@section('content')
<div class="card" style="max-width:800px">
    <h1>Tambah Laporan Kerusakan Jalan</h1>
    <p class="muted">Sertakan foto bukti JPG/PNG maksimal 2 MB.</p>
    <form method="POST" action="{{ route('laporan.store') }}" enctype="multipart/form-data">
        @csrf
        <label>Jenis kerusakan
            <select name="jenis_kerusakan" required>
                <option value="">Pilih jenis</option>
                @foreach(['Lubang','Retak','Ambles'] as $jenis)
                    <option value="{{ $jenis }}" @selected(old('jenis_kerusakan') === $jenis)>{{ $jenis }}</option>
                @endforeach
            </select>
        </label>
        @error('jenis_kerusakan') <p class="error">{{ $message }}</p> @enderror

        <label>Lokasi / nama jalan
            <input type="text" name="lokasi" maxlength="255" value="{{ old('lokasi') }}" required>
        </label>
        @error('lokasi') <p class="error">{{ $message }}</p> @enderror

        <label>Ruas jalan (opsional)
            <select name="ruas_jalan_id"><option value="">Belum ditentukan</option>
                @foreach($ruas as $r)
                    <option value="{{ $r->id }}" @selected(old('ruas_jalan_id') == $r->id)>{{ $r->nama }}</option>
                @endforeach
            </select>
        </label>
        @error('ruas_jalan_id') <p class="error">{{ $message }}</p> @enderror

        <label>Deskripsi kerusakan
            <textarea name="deskripsi" maxlength="2000" rows="4" required>{{ old('deskripsi') }}</textarea>
        </label>
        @error('deskripsi') <p class="error">{{ $message }}</p> @enderror

        <label>Latitude (opsional)
            <input type="number" name="latitude" step="0.0000001" min="-90" max="90" value="{{ old('latitude') }}">
        </label>
        @error('latitude') <p class="error">{{ $message }}</p> @enderror

        <label>Longitude (opsional)
            <input type="number" name="longitude" step="0.0000001" min="-180" max="180" value="{{ old('longitude') }}">
        </label>
        @error('longitude') <p class="error">{{ $message }}</p> @enderror

        <label>Foto bukti (wajib, JPG/JPEG/PNG, maks. 2 MB)
            <input type="file" name="foto" accept="image/jpeg,image/png" required>
        </label>
        @error('foto') <p class="error">{{ $message }}</p> @enderror

        <button class="primary" type="submit">Simpan Laporan</button>
        <a href="{{ route('laporan.index') }}" style="margin-left:10px">Batal</a>
    </form>
</div>
@endsection
