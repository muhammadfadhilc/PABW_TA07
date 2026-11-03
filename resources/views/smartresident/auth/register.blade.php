@extends('layouts.smartresident')

@section('title', 'Registrasi Warga')
@section('subtitle', 'Registrasi Akun Warga Baru')

@section('content')
<div class="form-card card">
    <div class="page-title">
        <h1>Registrasi Akun Warga Baru</h1>
        <p>Isi data warga untuk membuat akun kiosk baru.</p>
    </div>

    @if($errors->any())
        <x-alert type="error" message="Registrasi belum berhasil. Periksa kembali data yang diisi." />
    @endif

    <form method="POST" action="{{ route('warga.register.store') }}">
        @csrf
        <div class="field">
            <label for="nama">Nama Lengkap</label>
            <input id="nama" name="nama" value="{{ old('nama') }}" required>
            @error('nama')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div class="field">
            <label for="username">Username Kiosk</label>
            <input id="username" name="username" value="{{ old('username') }}" required>
            @error('username')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
            @error('password')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div class="actions">
            <button class="btn btn-primary" type="submit">Daftar Akun</button>
            <a class="btn btn-light" href="{{ route('smartresident.home') }}">Kembali</a>
        </div>
    </form>
</div>
@endsection
