@extends('layouts.app')
@section('title','Register')
@section('content')
<div class="card" style="max-width:490px;margin:auto"><h1>Registrasi Warga</h1><p class="muted">Registrasi publik hanya untuk peran Warga.</p>
<form method="POST" action="{{ route('register') }}">@csrf
<label>Nama<input type="text" name="name" value="{{ old('name') }}" required></label>@error('name')<p class="error">{{ $message }}</p>@enderror
<label>Email<input type="email" name="email" value="{{ old('email') }}" required></label>@error('email')<p class="error">{{ $message }}</p>@enderror
<label>Password (minimal 8 karakter)<input type="password" name="password" required></label>@error('password')<p class="error">{{ $message }}</p>@enderror
<label>Konfirmasi password<input type="password" name="password_confirmation" required></label>
<button type="submit" class="primary">Daftar</button></form></div>
@endsection