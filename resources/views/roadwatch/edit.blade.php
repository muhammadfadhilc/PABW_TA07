@extends('layouts.app')
@section('title', 'Edit Laporan')
@section('content')
<div class="card" style="max-width:800px">
    <h1>Edit Laporan #{{ $laporan->id }}</h1>
    <p class="muted">Boleh hanya memperbarui teks tanpa mengganti foto.</p>

    <form method="POST" action="{{ route('laporan.update', $laporan) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Jenis kerusakan
            <select name="jenis_kerusakan" required>
                @foreach(['Lubang','Retak','Ambles'] as $jenis)
                    <option value="{{ $jenis }}" @selected(old('jenis_kerusakan', $laporan->jenis_kerusakan) === $jenis)>{{ $jenis }}</option>
                @endforeach
            </select>
        </label>
        @error('jenis_kerusakan') <p class="error">{{ $message }}</p> @enderror

        <label>Lokasi / nama jalan
            <input type="text" name="lokasi" maxlength="255" required value="{{ old('lokasi', $laporan->lokasi) }}">
        </label>
        @error('lokasi') <p class="error">{{ $message }}</p> @enderror

        <label>Ruas jalan (opsional)
            <select name="ruas_jalan_id"><option value="">Belum ditentukan</option>
                @foreach($ruas as $r)
                    <option value="{{ $r->id }}" @selected(old('ruas_jalan_id', $laporan->ruas_jalan_id) == $r->id)>{{ $r->nama }}</option>
                @endforeach
            </select>
        </label>
        @error('ruas_jalan_id') <p class="error">{{ $message }}</p> @enderror

        <label>Deskripsi kerusakan
            <textarea name="deskripsi" maxlength="2000" rows="4" required>{{ old('deskripsi', $laporan->deskripsi) }}</textarea>
        </label>
        @error('deskripsi') <p class="error">{{ $message }}</p> @enderror

        <label>Latitude (opsional)
            <input type="number" name="latitude" step="0.0000001" min="-90" max="90" value="{{ old('latitude', $laporan->latitude) }}">
        </label>
        @error('latitude') <p class="error">{{ $message }}</p> @enderror

        <label>Longitude (opsional)
            <input type="number" name="longitude" step="0.0000001" min="-180" max="180" value="{{ old('longitude', $laporan->longitude) }}">
        </label>
        @error('longitude') <p class="error">{{ $message }}</p> @enderror

        @if($laporan->foto_path)
            <p><strong>Foto sekarang:</strong></p>
            <p><img src="{{ route('laporan.photo', $laporan) }}" alt="Foto bukti lama" style="max-width:280px;max-height:180px;border-radius:8px"></p>
            <p><a href="{{ route('laporan.photo', $laporan) }}" target="_blank">Buka foto lama</a></p>
        @endif
        <label>Ganti foto (opsional, JPG/JPEG/PNG, maks. 2 MB)
            <input type="file" name="foto" accept="image/jpeg,image/png">
        </label>
        @error('foto') <p class="error">{{ $message }}</p> @enderror

        <button class="primary" type="submit">Simpan Perubahan</button>
        <a href="{{ route('laporan.show', $laporan) }}" style="margin-left:10px">Batal</a>
    </form>
</div>
@endsection
