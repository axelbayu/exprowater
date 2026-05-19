<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Exprowater – @yield('title', 'Sistem Manajemen Order')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:     #003962;
            --navy-mid: #1565a0;
            --teal:     #0d7a7a;
            --sky:      #4fc3f7;
            --bg:       #eef3f8;
            --surface:  #ffffff;
            --border:   #cddce8;
            --text:     #1a2e42;
            --muted:    #6a8fa8;
            --success-bg: #e0f5f0; --success-txt: #0d6e4a;
            --warn-bg:  #faeeda;   --warn-txt:    #8a5a00;
            --danger-bg:#fde8e8;   --danger-txt:  #9a2222;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── NAVBAR ── */
        .navbar {
            background: var(--navy);
            height: 54px;
            padding: 0 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 8px rgba(10,61,98,.25);
        }
        .nav-brand {
            display: flex;
            align-items: center;
            gap: 9px;
            font-family: 'Playfair Display', serif;
            font-size: 17px;
            font-weight: 700;
            color: #fff;
            letter-spacing: .6px;
            text-decoration: none;
        }
        .nav-brand .drop {
            width: 26px; height: 26px;
            background: var(--sky);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
        }
        .nav-brand .drop span {
            width: 9px; height: 12px;
            background: var(--navy);
            border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
            display: block;
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: .25rem;
        }
        .nav-links a {
            color: #90caf9;
            text-decoration: none;
            font-size: 13px;
            padding: 6px 12px;
            border-radius: 6px;
            transition: background .15s, color .15s;
        }
        .nav-links a:hover,
        .nav-links a.active { background: rgba(0, 0, 0, 0.1); color: #fff; }

        .nav-user {
            display: flex; align-items: center; gap: 8px;
            font-size: 12px; color: #fff;
        }
        .avatar {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: var(--sky);
            color: var(--navy);
            font-size: 11px; font-weight: 600;
            display: flex; align-items: center; justify-content: center;
        }

        /* ── MAIN ── */
        main { flex: 1; padding: 1.75rem; }

        /* ── FLASH MESSAGES ── */
        .flash {
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 1.25rem;
            border-left: 3px solid;
        }
        .flash-success { background: var(--success-bg); color: var(--success-txt); border-color: var(--success-txt); }
        .flash-error   { background: var(--danger-bg);  color: var(--danger-txt);  border-color: var(--danger-txt); }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }
        .page-header h1 { font-size: 18px; font-weight: 600; color: var(--text); }
        .page-header p  { font-size: 12px; font-weight: 300; color: var(--muted); margin-top: 2px; }

        /* ── CARD ── */
        .card {
            background: var(--surface);
            border: .5px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        /* ── TABLE ── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        thead { background: #f5f8fc; }
        th {
            padding: 10px 14px;
            text-align: left;
            font-size: 10px;
            font-weight: 500;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .6px;
            border-bottom: .5px solid var(--border);
            white-space: nowrap;
        }
        td {
            padding: 10px 14px;
            border-bottom: .5px solid #eef3f8;
            color: var(--text);
        }
        tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: #f9fbfd; }

        /* ── BADGES ── */
        .badge {
            display: inline-block;
            padding: 2px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 500;
        }
        .badge-success { background: var(--success-bg); color: var(--success-txt); }
        .badge-warning { background: var(--warn-bg);    color: var(--warn-txt); }
        .badge-danger  { background: var(--danger-bg);  color: var(--danger-txt); }
        .badge-info    { background: #e6f3fb;            color: #0a4a7a; }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 7px 18px;
            border-radius: 20px;
            font-size: 12px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 500;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: opacity .15s, transform .1s;
        }
        .btn:active { transform: scale(.98); }
        .btn-primary   { background: var(--navy);    color: #fff; }
        .btn-primary:hover { opacity: .88; }
        .btn-secondary { background: var(--surface); color: var(--muted); border: .5px solid var(--border); }
        .btn-secondary:hover { background: var(--bg); }
        .btn-sm { padding: 3px 10px; font-size: 11px; border-radius: 6px; }
        .btn-edit   { background: #e6f3fb; color: #0a4a7a; border: .5px solid #b3d4f0; }
        .btn-delete { background: var(--danger-bg); color: var(--danger-txt); border: .5px solid #f0b3b3; }

        /* ── FORMS ── */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-group { display: flex; flex-direction: column; gap: 5px; }
        .form-group.full { grid-column: 1 / -1; }
        label { font-size: 11px; font-weight: 500; color: #4a6a82; }
        .form-control {
            background: #f8fafc;
            border: .5px solid var(--border);
            border-radius: 8px;
            padding: 9px 13px;
            font-size: 13px;
            color: var(--text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            outline: none;
            transition: border-color .15s, background .15s;
            width: 100%;
        }
        .form-control:focus { border-color: #4a90c4; background: #fff; }
        .form-control.is-invalid { border-color: #e24b4a; }
        .invalid-feedback { font-size: 10px; color: var(--danger-txt); margin-top: 2px; }
        .form-hint { font-size: 10px; color: #8aacbf; }
        .form-actions { display: flex; gap: 8px; justify-content: flex-end; margin-top: 1.25rem; }

        /* ── PAGINATION ── */
        .pagination-wrap {
            padding: .85rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: .5px solid var(--border);
            font-size: 11px;
            color: var(--muted);
        }
        .pagination { display: flex; gap: 3px; }
        .page-btn {
            width: 28px; height: 28px;
            border-radius: 6px;
            border: .5px solid var(--border);
            background: var(--surface);
            font-size: 11px;
            color: var(--text);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            text-decoration: none;
            transition: background .12s;
        }
        .page-btn:hover    { background: var(--bg); }
        .page-btn.active   { background: var(--navy); color: #fff; border-color: var(--navy); }
        .page-btn.disabled { opacity: .4; pointer-events: none; }

        /* ── FILTERS ── */
        .filters {
            display: flex;
            gap: 8px;
            padding: 1rem 1.25rem;
            border-bottom: .5px solid var(--border);
            background: #f9fbfd;
        }
        .filter-input {
            flex: 1;
            background: var(--surface);
            border: .5px solid var(--border);
            border-radius: 8px;
            padding: 7px 12px;
            font-size: 12px;
            color: var(--text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            outline: none;
        }
        .filter-select {
            background: var(--surface);
            border: .5px solid var(--border);
            border-radius: 8px;
            padding: 7px 10px;
            font-size: 12px;
            color: var(--muted);
            font-family: 'Plus Jakarta Sans', sans-serif;
            outline: none;
        }

        /* ── FOOTER ── */
        footer {
            background: var(--surface);
            border-top: .5px solid var(--border);
            padding: .85rem 1.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
            color: var(--muted);
        }
        footer strong { color: var(--navy); font-weight: 600; font-family: 'Playfair Display', serif; }

        /* ── UTILITIES ── */
        .action-btns { display: flex; gap: 4px; }
        .text-right { text-align: right; }
        .mt-1 { margin-top: .5rem; }
        .section-divider {
            font-size: 11px;
            font-weight: 500;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .8px;
            padding-bottom: .5rem;
            border-bottom: .5px solid var(--border);
            margin-bottom: 1rem;
        }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar">
    <a href="{{ auth()->check() ? route('orders.index') : route('login') }}" class="nav-brand">
        <div class="drop"><span></span></div>
        EXPROWATER
    </a>

    @auth
    <div class="nav-links">
        <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">Orders</a>
    </div>

    <div class="nav-user">
        <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}</div>
        <span>{{ auth()->user()->name ?? 'Admin' }}</span>
        {{-- ✅ fix: use POST method for logout --}}
        <form method="POST" action="{{ route('logout') }}" style="display:inline;margin-left:4px;">
            @csrf
            <button type="submit" class="btn btn-sm" style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.2);">Logout</button>
        </form>
    </div>
    @else
    <div class="nav-links"></div>
    <div class="nav-user">
        <a href="{{ route('login') }}" class="btn" style="padding:6px 12px;background:transparent;color:#fff;border:1px solid rgba(255,255,255,.25);">Login</a>
    </div>
    @endauth
</nav>

<main>
    @if(session('success'))
        <div class="flash flash-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash flash-error">{{ session('error') }}</div>
    @endif

    @yield('content')
</main>

<footer>
    <strong>Exprowater</strong>
    <span>&copy; {{ date('Y') }} — Sistem Manajemen Order</span>
</footer>

@stack('scripts')
</body>
</html>