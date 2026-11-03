@extends('layouts.app')
@section('title','Login')
@section('content')
<div class="card" style="max-width:490px;margin:auto"><h1>Login RoadWatch</h1><p class="muted">Masuk dengan akun pengguna yang terdaftar.</p>
<form method="POST" action="{{ route('login') }}">@csrf
<label>Email<input type="email" name="email" value="{{ old('email') }}" required autofocus></label>@error('email')<p class="error">{{ $message }}</p>@enderror
<label>Password<input type="password" name="password" required></label>@error('password')<p class="error">{{ $message }}</p>@enderror
<label><input style="width:auto;display:inline" type="checkbox" name="remember" value="1"> Ingat saya</label><button class="primary" type="submit">Login</button>
</form><p>Belum punya akun? <a href="{{ route('register') }}">Daftar sebagai warga</a></p></div>
@endsection