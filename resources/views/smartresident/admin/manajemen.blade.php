@extends('layouts.smartresident')

@section('title', 'Manajemen Admin')
@section('subtitle', 'Manajemen Akun Petugas')

@section('content')
<div class="page-title">
    <h1>Manajemen Admin</h1>
    <p>Tambah petugas baru dan lihat daftar akun administrasi yang tersedia pada prototipe.</p>
</div>

<div class="two-col">
    <div class="card">
        <h2 style="margin-top:0; font-size:19px;">Tambah Admin</h2>
        <form method="POST" action="{{ route('admin.manajemen.store') }}">
            @csrf
            <div class="field">
                <label for="nama">Nama Lengkap</label>
                <input id="nama" name="nama" required>
            </div>
            <div class="field">
                <label for="username">Username</label>
                <input id="username" name="username" required>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required>
            </div>
            <div class="field">
                <label for="role">Role / Peran</label>
                <select id="role" name="role">
                    @foreach(['admin', 'superadmin', 'kontraktor'] as $role)
                        <option value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-primary" type="submit">Tambah</button>
        </form>
    </div>

    <div class="card">
        <div class="toolbar">
            <h2 style="margin:0; font-size:19px;">Daftar Petugas Administrasi</h2>
            <a class="btn btn-light" href="{{ route('admin.dashboard') }}">Kembali ke Dashboard</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>ID</th><th>Nama</th><th>Username</th><th>Role</th></tr></thead>
                <tbody>
                    @foreach($admins as $item)
                        <tr>
                            <td>{{ $item['id'] }}</td>
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['username'] }}</td>
                            <td>{{ $item['role'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
