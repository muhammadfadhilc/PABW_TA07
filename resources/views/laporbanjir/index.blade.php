@extends('layouts.app')

@section('title', 'Daftar Laporan')

@section('content')
<div class="page-heading">
    <h1>Daftar Laporan Banjir</h1>
    <p>Status genangan ditentukan dengan directive Blade: &lt;30 cm = Waspada, 30-70 cm = Siaga, dan &gt;70 cm = Awas.</p>
</div>

<div class="grid">
    @forelse($laporan as $item)
        @include('partials.laporan-card', ['item' => $item])
    @empty
        <div class="card" style="grid-column:1/-1;">Belum ada laporan banjir.</div>
    @endforelse
</div>
@endsection
