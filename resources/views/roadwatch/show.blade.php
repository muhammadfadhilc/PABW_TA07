@extends('layouts.app')
@section('title','Detail Laporan')
@section('content')
<div class="card">
    @php
        $bolehKelola = Auth::user()->role === 'admin'
            || (Auth::user()->role === 'warga'
                && $laporan->user_id === Auth::id()
                && $laporan->status === 'Menunggu Verifikasi');
    @endphp
    <h1>Laporan #{{ $laporan->id }}</h1>
    <p><strong>Jenis:</strong> {{ $laporan->jenis_kerusakan }}</p>
    <p><strong>Lokasi:</strong> {{ $laporan->lokasi }}</p>
    <p><strong>Deskripsi:</strong> {{ $laporan->deskripsi }}</p>
    <p><strong>Status:</strong> {{ $laporan->status }}</p>
    <p><strong>Waktu laporan:</strong> {{ $laporan->created_at->format('d-m-Y H:i') }}</p>
    @if($laporan->latitude !== null && $laporan->longitude !== null)
        <p><strong>Koordinat:</strong> {{ $laporan->latitude }}, {{ $laporan->longitude }}</p>
    @endif
    @if($laporan->foto_path)
        <h3>Foto bukti</h3>
        <p><a href="{{ route('laporan.photo', $laporan) }}" target="_blank">Buka / lihat ukuran penuh</a></p>
        <img src="{{ route('laporan.photo', $laporan) }}" alt="Foto bukti kerusakan jalan" style="max-width:100%;max-height:390px;border-radius:10px;border:1px solid #ddd">
    @endif
    @if($bolehKelola)
        <hr>
        <p><a class="button" href="{{ route('laporan.edit',$laporan) }}">Edit Laporan</a></p>
        <form action="{{ route('laporan.destroy',$laporan) }}" method="POST" onsubmit="return confirm('Laporan dan foto akan dihapus. Lanjutkan?')">
            @csrf @method('DELETE')
            <button type="submit" style="background:#b32626;color:white;border:0;border-radius:7px;padding:10px 16px;cursor:pointer">Hapus Laporan</button>
        </form>
    @endif
    @if(Auth::user()->role === 'admin' && in_array($laporan->status, ['Menunggu Verifikasi','Terverifikasi']))
        <hr><h2>Tindakan Admin Desa</h2>
        <form method="POST" action="{{ route('laporan.status',$laporan) }}">
            @csrf @method('PATCH')
            <label>Status baru
                <select name="status">
                    @foreach(($laporan->status === 'Menunggu Verifikasi' ? ['Terverifikasi','Ditolak'] : ['Ditugaskan','Diteruskan']) as $s)
                        <option value="{{ $s }}">{{ $s }}</option>
                    @endforeach
                </select>
            </label>
            @error('status') <p class="error">{{ $message }}</p> @enderror
            <label>Petugas (wajib jika Ditugaskan)
                <select name="assigned_to"><option value="">Pilih petugas</option>
                    @foreach($petugas as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </label>
            @error('assigned_to') <p class="error">{{ $message }}</p> @enderror
            <button class="primary" type="submit">Ubah Status</button>
        </form>
    @endif
    @if(Auth::user()->role === 'petugas' && in_array($laporan->status, ['Ditugaskan','Diproses']))
        <hr><h2>Progres Petugas</h2>
        <form method="POST" action="{{ route('laporan.status',$laporan) }}">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="{{ $laporan->status === 'Ditugaskan' ? 'Diproses' : 'Selesai' }}">
            <button class="primary" type="submit">Ubah menjadi {{ $laporan->status === 'Ditugaskan' ? 'Diproses' : 'Selesai' }}</button>
        </form>
    @endif
    <p><a href="{{ route('laporan.index') }}">Kembali ke Daftar Laporan</a></p>
</div>
@endsection
