@extends('layouts.app')
@section('title', 'Daftar Laporan')
@section('content')
<h1>Daftar Laporan Kerusakan Jalan</h1>
<p class="muted">Hanya laporan yang sesuai akun dan peran yang dapat ditampilkan.</p>
@if(Auth::user()->role === 'warga')
    <p><a class="button" href="{{ route('laporan.create') }}">+ Tambah Laporan</a></p>
@endif
<div class="card" style="overflow:auto">
    <table>
        <thead><tr><th>No</th><th>Foto</th><th>Jenis</th><th>Lokasi</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($rows as $r)
            @php
                $bolehKelola = Auth::user()->role === 'admin'
                    || (Auth::user()->role === 'warga'
                        && $r->user_id === Auth::id()
                        && $r->status === 'Menunggu Verifikasi');
            @endphp
            <tr>
                <td>{{ $rows->firstItem() + $loop->index }}</td>
                <td>
                    @if($r->foto_path)
                        <a href="{{ route('laporan.photo', $r) }}" target="_blank">
                            <img src="{{ route('laporan.photo', $r) }}" alt="Foto bukti laporan #{{ $r->id }}" style="width:84px;height:60px;object-fit:cover;border-radius:6px">
                        </a>
                    @else
                        <span class="muted">Tidak ada</span>
                    @endif
                </td>
                <td>{{ $r->jenis_kerusakan }}</td>
                <td>{{ $r->lokasi }}</td>
                <td>{{ $r->status }}</td>
                <td>{{ $r->created_at->format('d-m-Y') }}</td>
                <td>
                    <a href="{{ route('laporan.show', $r) }}">Detail</a>
                    @if($bolehKelola)
                        | <a href="{{ route('laporan.edit', $r) }}">Edit</a>
                        <form method="POST" action="{{ route('laporan.destroy', $r) }}" style="display:inline" onsubmit="return confirm('Yakin hapus laporan dan foto ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="background:none;color:#b32626;border:0;cursor:pointer;padding:0">Hapus</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="7">Belum ada laporan.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top:18px">{{ $rows->links() }}</div>
</div>
@endsection
