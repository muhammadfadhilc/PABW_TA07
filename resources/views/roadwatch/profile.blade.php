@extends('layouts.app')
@section('title','Profil')
@section('content')<div class="card"><h1>Profil Pengguna</h1><p>Nama: <strong>{{ Auth::user()->name }}</strong></p><p>Email: {{ Auth::user()->email }}</p>
<p>Peran: {{ Auth::user()->role }}</p><p>Akun dibuat: {{ Auth::user()->created_at->format('d M Y H:i') }}</p></div>@endsection