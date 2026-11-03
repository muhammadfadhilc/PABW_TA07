@extends('layouts.smartresident')

@section('title', 'Dashboard Admin')
@section('subtitle', 'Antrian Laporan Kerusakan Fasilitas')

@section('content')
<div class="banner">
    <div>
        <strong>Petugas: {{ $admin['nama'] }}</strong>
        <div style="font-size:12px; margin-top:3px;">Peran: {{ strtoupper($admin['role']) }}</div>
    </div>
    <a class="btn btn-soft" href="{{ route('admin.manajemen') }}">Kelola Akun Admin</a>
</div>

<div class="toolbar">
    <div class="page-title" style="margin:0;">
        <h1 style="font-size:21px;">Antrian Laporan Kerusakan Fasilitas</h1>
    </div>
    <form class="filter" method="GET" action="{{ route('admin.dashboard') }}">
        <label for="status" style="margin:0;">Filter Status:</label>
        <select id="status" name="status" onchange="this.form.submit()">
            @foreach(['Semua', 'Menunggu', 'Diproses', 'Selesai'] as $item)
                <option value="{{ $item }}" @selected($filter === $item)>{{ $item }}</option>
            @endforeach
        </select>
    </form>
</div>

<div class="report-grid">
    @forelse($laporan as $report)
        @include('smartresident.partials.report-card', ['report' => $report, 'showDetail' => true])
    @empty
        <div class="card" style="grid-column:1/-1;">Tidak ada laporan pada filter ini.</div>
    @endforelse
</div>
@endsection
