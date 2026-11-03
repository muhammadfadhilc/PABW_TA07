@extends('layouts.smartresident')

@section('title', 'Detail Laporan')
@section('subtitle', 'Detail Laporan Pengaduan')

@section('content')
<div class="form-card wide card">
    <div class="page-title">
        <h1>Detail Laporan Pengaduan</h1>
        <p>Periksa detail laporan kemudian perbarui status penanganannya.</p>
    </div>

    <dl class="details">
        <dt>Nomor Tiket</dt><dd><strong>TKT-{{ str_pad((string) $laporan['id'], 5, '0', STR_PAD_LEFT) }}</strong></dd>
        <dt>Tanggal Lapor</dt><dd>{{ $laporan['tanggal_lapor'] }}</dd>
        <dt>Nama Pelapor</dt><dd>{{ $laporan['pelapor'] }}</dd>
        <dt>Jenis Fasilitas</dt><dd>{{ $laporan['tipe_fasilitas'] }}</dd>
        <dt>Lokasi</dt><dd>{{ $laporan['lokasi'] }}</dd>
        <dt>Deskripsi</dt><dd>{{ $laporan['deskripsi'] }}</dd>
        <dt>Status Saat Ini</dt><dd>@include('smartresident.partials.status-badge', ['status' => $laporan['status']])</dd>
    </dl>

    <form method="POST" action="{{ route('admin.laporan.status', $laporan['id']) }}" style="margin-top:18px;">
        @csrf
        @method('PATCH')
        <div class="field">
            <label for="status">Status</label>
            <select id="status" name="status">
                @foreach(['Menunggu', 'Diproses', 'Selesai'] as $status)
                    <option value="{{ $status }}" @selected($laporan['status'] === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <div class="actions">
            <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
            <a class="btn btn-light" href="{{ route('admin.dashboard') }}">Batal / Kembali</a>
        </div>
    </form>

    <form method="POST" action="{{ route('admin.laporan.delete', $laporan['id']) }}" style="margin-top:10px;" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit">Hapus Laporan</button>
    </form>
</div>
@endsection
