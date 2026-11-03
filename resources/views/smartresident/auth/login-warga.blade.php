@extends('layouts.smartresident')

@section('title', 'Login Warga')
@section('subtitle', 'Portal Masuk Layanan Kiosk')

@section('content')
<div class="form-card card">
    <div class="page-title">
        <h1>Portal Masuk Layanan Kiosk</h1>
        <p>Masukkan username dan password warga.</p>
    </div>

    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif
    @error('login')
        <x-alert type="error" :message="$message" />
    @enderror

    <form method="POST" action="{{ route('warga.login.store') }}">
        @csrf
        <div class="field">
            <label for="username">Username Warga</label>
            <input id="username" name="username" value="{{ old('username') }}" autocomplete="username" required>
            @error('username')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>
            @error('password')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div class="actions">
            <button class="btn btn-primary" type="submit">Masuk</button>
            <a class="btn btn-light" href="{{ route('smartresident.home') }}">Batal</a>
        </div>
    </form>
    <div class="help" style="margin-top:16px;">Akun demo: <strong>fadhil</strong> / <strong>warga123</strong></div>
</div>
@endsection
