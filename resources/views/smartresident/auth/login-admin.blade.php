@extends('layouts.smartresident')

@section('title', 'Login Admin')
@section('subtitle', 'Portal Login Petugas Desa')

@section('content')
<div class="form-card card">
    <div class="page-title">
        <h1>Portal Login Petugas Desa</h1>
        <p>Masukkan username dan password admin.</p>
    </div>

    @error('login')
        <x-alert type="error" :message="$message" />
    @enderror

    <form method="POST" action="{{ route('admin.login.store') }}">
        @csrf
        <div class="field">
            <label for="username">Username</label>
            <input id="username" name="username" value="{{ old('username') }}" required>
            @error('username')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
            @error('password')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div class="actions">
            <button class="btn btn-primary" type="submit">Login</button>
            <a class="btn btn-light" href="{{ route('smartresident.home') }}">Batal</a>
        </div>
    </form>
    <div class="help" style="margin-top:16px;">Akun demo: <strong>admin</strong> / <strong>admin123</strong></div>
</div>
@endsection
