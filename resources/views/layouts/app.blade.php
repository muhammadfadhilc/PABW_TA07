<!DOCTYPE html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>@yield('title','RoadWatch') | SmartResident</title>
<style>
:root{--green:#17624c;--ink:#1a2932;--light:#f5f8f7;--line:#dbe7e3}*{box-sizing:border-box}
body{margin:0;background:var(--light);color:var(--ink);font:15px/1.6 Arial,sans-serif}nav{background:var(--green);color:white;padding:14px max(20px,calc((100vw - 1100px)/2));display:flex;gap:16px;align-items:center;flex-wrap:wrap}nav a,nav button{color:white;text-decoration:none;font:inherit;background:transparent;border:0;cursor:pointer}nav strong{font-size:19px;margin-right:auto}nav form{margin:0}.wrap{max-width:1100px;margin:32px auto;padding:0 20px}.card{background:white;border:1px solid var(--line);border-radius:12px;padding:22px;margin-bottom:18px}.box{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}.box .card{margin:0}input,select,textarea{display:block;width:100%;padding:10px;border:1px solid #bdccc6;border-radius:7px;margin:6px 0 13px;font:inherit}button.primary,.button{border:0;border-radius:7px;background:var(--green);color:white;padding:10px 16px;cursor:pointer;text-decoration:none;display:inline-block}.muted{color:#687c75}.error{color:#9e2020;font-size:13px}.notice{background:#e5f6ed;padding:10px 15px;border-radius:8px;margin:0 0 20px}table{width:100%;border-collapse:collapse;background:white}th,td{padding:10px;border-bottom:1px solid var(--line);text-align:left}th{background:#e8f0ed}.small{font-size:13px}h1{font-size:28px;margin-top:0}hr{border:0;border-top:1px solid var(--line);margin:20px 0}@media(max-width:720px){.box{grid-template-columns:1fr}table{display:block;overflow:auto}}
</style></head><body><nav><strong>SmartResident / RoadWatch</strong>
@auth
<a href="{{ route('dashboard') }}">Dashboard</a><a href="{{ route('laporan.index') }}">Laporan</a>
@if(Auth::user()->role==='warga')<a href="{{ route('laporan.create') }}">Buat Laporan</a>@endif
<a href="{{ route('profile') }}">Profil</a><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Logout</button></form>
@else
<a href="{{ route('login') }}">Login</a><a href="{{ route('register') }}">Register</a>
@endauth
</nav><main class="wrap">
@if(session('success'))<div class="notice">{{ session('success') }}</div>@endif
@yield('content')</main></body></html>