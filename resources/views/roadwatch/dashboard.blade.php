@extends('layouts.app')
@section('title','Dashboard')
@section('content')
<h1>Dashboard Monitoring Jalan</h1><p class="muted">Desa Citeureup, Dayeuhkolot, Kabupaten Bandung | Peran: {{ str_replace('_',' ',Auth::user()->role) }}</p>
<div class="box"><div class="card"><div class="muted">Total laporan yang dapat diakses</div><h1>{{ $total }}</h1></div><div class="card"><div class="muted">Menunggu verifikasi</div><h1>{{ $menunggu }}</h1></div><div class="card"><div class="muted">Selesai</div><h1>{{ $selesai }}</h1></div></div>
<div class="card"><h2>Laporan terbaru</h2>
@forelse($rows->take(10) as $r)<p><a href="{{ route('laporan.show',$r) }}">#{{ $r->id }} | {{ $r->jenis_kerusakan }} | {{ $r->lokasi }}</a> <span class="muted">({{ $r->status }})</span></p>@empty<p>Belum ada laporan RoadWatch. Data fasilitas umum Modul 4 tetap disimpan sebagai arsip terpisah.</p>@endforelse
<a class="button" href="{{ route('laporan.index') }}">Lihat daftar laporan</a></div>
@endsection