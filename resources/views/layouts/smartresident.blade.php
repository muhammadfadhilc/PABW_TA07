<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SmartResident') | Desa Citeureup</title>
    <style>
        :root {
            --primary: #2b893d;
            --primary-dark: #1f6b2f;
            --secondary: #86efac;
            --accent: #4ade80;
            --slate-900: #0f172a;
            --slate-800: #1e293b;
            --slate-500: #64748b;
            --slate-100: #f1f5f9;
            --slate-50: #f8fafc;
            --danger: #ef4444;
            --warning: #f59e0b;
            --success: #10b981;
        }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: "Segoe UI", Arial, sans-serif; color: var(--slate-800); background: var(--slate-50); }
        a { color: inherit; }
        .site-header { background: var(--primary); color: #fff; box-shadow: 0 3px 14px rgba(15,23,42,.13); }
        .header-inner { max-width: 1120px; margin: auto; padding: 13px 22px; display: flex; align-items: center; justify-content: space-between; gap: 20px; }
        .brand { display: flex; gap: 11px; align-items: center; text-decoration: none; min-width: 220px; }
        .brand img { width: 38px; height: 38px; object-fit: contain; background: #fff; border-radius: 8px; padding: 4px; }
        .brand strong { display: block; font-size: 22px; letter-spacing: .2px; }
        .brand small { color: var(--secondary); font-size: 10px; font-weight: 800; letter-spacing: .7px; text-transform: uppercase; }
        .main-nav { display: flex; align-items: center; justify-content: flex-end; gap: 6px; flex-wrap: wrap; }
        .main-nav a, .nav-form button { border: 0; background: transparent; color: #fff; text-decoration: none; padding: 9px 11px; border-radius: 8px; font: inherit; font-size: 13px; font-weight: 700; cursor: pointer; }
        .main-nav a:hover, .main-nav a.active, .nav-form button:hover { background: rgba(255,255,255,.14); }
        .nav-form { margin: 0; }
        .page { max-width: 1120px; margin: auto; padding: 30px 22px 46px; min-height: calc(100vh - 145px); }
        .page-title { margin-bottom: 22px; }
        .page-title h1 { margin: 0 0 6px; font-size: 27px; color: var(--slate-900); }
        .page-title p { margin: 0; color: var(--slate-500); line-height: 1.6; }
        .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 22px; box-shadow: 0 7px 22px rgba(15,23,42,.05); }
        .card + .card { margin-top: 16px; }
        .hero { display: grid; grid-template-columns: 360px 1fr; min-height: 430px; border-radius: 16px; overflow: hidden; background: white; box-shadow: 0 13px 40px rgba(15,23,42,.1); border: 1px solid #e2e8f0; }
        .hero-left { background: var(--primary); color: white; padding: 48px 36px; display: flex; flex-direction: column; align-items: center; text-align: center; justify-content: center; }
        .hero-left img { width: 122px; height: 122px; object-fit: contain; background: white; border-radius: 22px; padding: 12px; margin-bottom: 25px; }
        .hero-left h1 { font-size: 32px; margin: 0 0 8px; }
        .hero-left p { color: var(--secondary); margin: 0; font-weight: 700; }
        .hero-right { padding: 54px 52px; display: flex; flex-direction: column; justify-content: center; }
        .hero-right h2 { margin: 0 0 14px; font-size: 25px; color: var(--slate-900); }
        .hero-right .intro { color: var(--slate-500); line-height: 1.75; margin-bottom: 24px; }
        .hero-actions { display: grid; grid-template-columns: 1fr; gap: 12px; }
        .form-card { max-width: 640px; margin: 0 auto; }
        .form-card.wide { max-width: 860px; }
        .field { margin-bottom: 17px; }
        label { display: block; margin-bottom: 7px; font-size: 14px; font-weight: 700; color: #334155; }
        input, select, textarea { width: 100%; padding: 11px 12px; border-radius: 8px; border: 1px solid #cbd5e1; font: inherit; color: var(--slate-800); background: #fff; }
        input:focus, select:focus, textarea:focus { outline: 3px solid rgba(74,222,128,.22); border-color: var(--primary); }
        textarea { min-height: 112px; resize: vertical; }
        .help { font-size: 12px; color: var(--slate-500); margin-top: 5px; }
        .error-text { color: #b91c1c; font-size: 13px; margin-top: 6px; }
        .btn { display: inline-flex; justify-content: center; align-items: center; gap: 8px; border: 0; border-radius: 8px; padding: 11px 16px; text-decoration: none; font: inherit; font-size: 14px; font-weight: 800; cursor: pointer; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-soft { background: #dcfce7; color: #166534; }
        .btn-light { background: #eef2f6; color: #334155; }
        .btn-danger { background: #fee2e2; color: #991b1b; }
        .actions { display: flex; gap: 10px; flex-wrap: wrap; }
        .banner { background: #ecfdf5; border: 1px solid #a7f3d0; color: #166534; border-radius: 10px; padding: 13px 15px; display: flex; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 20px; }
        .alert-box { display: flex; gap: 12px; align-items: flex-start; padding: 13px 14px; border-radius: 9px; margin-bottom: 18px; line-height: 1.45; }
        .alert-icon { width: 25px; height: 25px; border: 2px solid; border-radius: 50%; display: grid; place-items: center; font-weight: 800; flex: 0 0 auto; }
        .table-wrap { overflow-x: auto; border: 1px solid #e2e8f0; border-radius: 10px; background: white; }
        table { width: 100%; border-collapse: collapse; min-width: 720px; }
        th { background: #f8fafc; color: #475569; text-align: left; font-size: 12px; text-transform: uppercase; letter-spacing: .35px; padding: 12px; border-bottom: 1px solid #e2e8f0; }
        td { padding: 12px; border-bottom: 1px solid #edf2f7; font-size: 13px; vertical-align: top; }
        tbody tr:last-child td { border-bottom: 0; }
        tbody tr:hover { background: #fbfdfb; }
        .status { display: inline-block; padding: 5px 9px; border-radius: 999px; font-size: 11px; font-weight: 800; white-space: nowrap; }
        .status-menunggu { background: #fef3c7; color: #92400e; }
        .status-diproses { background: #dbeafe; color: #1e40af; }
        .status-selesai { background: #dcfce7; color: #166534; }
        .report-grid { display: grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap: 14px; }
        .report-mini { border: 1px solid #e2e8f0; border-radius: 11px; padding: 16px; background: white; }
        .report-mini h3 { margin: 0 0 7px; font-size: 16px; }
        .report-mini p { margin: 5px 0; color: var(--slate-500); font-size: 13px; line-height: 1.5; }
        .report-mini .row { display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-top: 12px; }
        .confirm { max-width: 650px; margin: 0 auto; text-align: center; }
        .check { width: 74px; height: 74px; border-radius: 50%; margin: 0 auto 17px; background: #d1fae5; color: #047857; display: grid; place-items: center; font-size: 42px; font-weight: 800; }
        .ticket { font-size: 37px; color: var(--primary); font-weight: 900; letter-spacing: 1px; margin: 16px 0 7px; }
        .details { display: grid; grid-template-columns: 160px 1fr; gap: 10px 18px; text-align: left; margin: 20px 0; }
        .details dt { color: var(--slate-500); font-weight: 700; }
        .details dd { margin: 0; color: var(--slate-800); }
        .toolbar { display: flex; align-items: center; justify-content: space-between; gap: 15px; margin-bottom: 14px; flex-wrap: wrap; }
        .filter { display: flex; align-items: center; gap: 8px; }
        .filter select { width: auto; min-width: 140px; padding: 8px 10px; }
        .two-col { display: grid; grid-template-columns: 360px 1fr; gap: 18px; }
        .muted { color: var(--slate-500); }
        .site-footer { background: white; border-top: 1px solid #e2e8f0; color: var(--slate-500); }
        .footer-inner { max-width: 1120px; margin: auto; padding: 16px 22px; display: flex; justify-content: space-between; gap: 18px; font-size: 11px; }
        @media (max-width: 820px) {
            .header-inner, .footer-inner { flex-direction: column; align-items: flex-start; }
            .main-nav { justify-content: flex-start; }
            .hero { grid-template-columns: 1fr; }
            .hero-left { padding: 35px 25px; }
            .hero-right { padding: 32px 25px; }
            .report-grid, .two-col { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<header class="site-header">
    <div class="header-inner">
        <a class="brand" href="{{ route('smartresident.home') }}">
            <img src="{{ asset('logo.png') }}" alt="Logo SmartResident">
            <div>
                <strong>SmartResident</strong>
                <small>@yield('subtitle', 'Kiosk Pelayanan Mandiri Warga')</small>
            </div>
        </a>
        <nav class="main-nav">
            <a class="{{ request()->routeIs('smartresident.home') ? 'active' : '' }}" href="{{ route('smartresident.home') }}">Beranda</a>
            @if(session('smartresident_user'))
                <a class="{{ request()->routeIs('warga.dashboard') ? 'active' : '' }}" href="{{ route('warga.dashboard') }}">Dashboard Warga</a>
                <a class="{{ request()->routeIs('warga.laporan.create') ? 'active' : '' }}" href="{{ route('warga.laporan.create') }}">Lapor Baru</a>
                <form class="nav-form" method="POST" action="{{ route('warga.logout') }}">@csrf<button type="submit">Logout</button></form>
            @elseif(session('smartresident_admin'))
                <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                <a class="{{ request()->routeIs('admin.manajemen') ? 'active' : '' }}" href="{{ route('admin.manajemen') }}">Kelola Admin</a>
                <form class="nav-form" method="POST" action="{{ route('admin.logout') }}">@csrf<button type="submit">Keluar</button></form>
            @else
                <a class="{{ request()->routeIs('warga.login') ? 'active' : '' }}" href="{{ route('warga.login') }}">Login Warga</a>
                <a class="{{ request()->routeIs('warga.register') ? 'active' : '' }}" href="{{ route('warga.register') }}">Daftar</a>
                <a class="{{ request()->routeIs('admin.login') ? 'active' : '' }}" href="{{ route('admin.login') }}">Admin</a>
            @endif
            <a href="{{ route('banjir.form') }}">LaporBanjir</a>
        </nav>
    </div>
</header>

<main class="page">
    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif
    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif
    @yield('content')
</main>

<footer class="site-footer">
    <div class="footer-inner">
        <span>© 2026 SmartResident. Terminal Kiosk Pengaduan Kerusakan Balai Desa Citeureup.</span>
        <strong style="color: var(--primary);">KIOSK-ID: SMR-05</strong>
    </div>
</footer>
</body>
</html>
