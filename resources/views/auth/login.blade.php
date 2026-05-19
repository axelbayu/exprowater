<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Exprowater</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --navy: #002d52; --mid: #1565a0; --sky: #4fc3f7;
            --muted: #6a8fa8; --border: #cddce8; --danger: #e24b4a;
        }
        html, body { height: 100%; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { display: grid; grid-template-columns: 1fr 440px; min-height: 100vh; }

        /* LEFT */
        .panel-left {
            background: linear-gradient(145deg, #002d52 0%, #1565a0 50%, #0d7a7a 100%);
            position: relative; display: flex; flex-direction: column;
            justify-content: space-between; padding: 3rem; overflow: hidden;
        }
        .panel-left::before {
            content: ''; position: absolute; width: 500px; height: 500px;
            border-radius: 50%; border: 80px solid rgba(255,255,255,.05);
            right: -160px; top: -160px;
        }
        .panel-left::after {
            content: ''; position: absolute; width: 320px; height: 320px;
            border-radius: 50%; border: 50px solid rgba(255,255,255,.04);
            left: -80px; bottom: -80px;
        }
        .brand { display: flex; align-items: center; gap: 12px; position: relative; z-index: 2; }
        .brand-drop {
            width: 38px; height: 38px; border-radius: 50%; background: var(--sky);
            display: flex; align-items: center; justify-content: center;
        }
        .brand-drop span {
            width: 11px; height: 14px; background: var(--navy);
            border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%; display: block;
        }
        .brand-name { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 700; color: #fff; letter-spacing: .8px; }

        .panel-hero { position: relative; z-index: 2; }
        .panel-hero h1 { font-family: 'Playfair Display', serif; font-size: 46px; line-height: 1.15; color: #fff; margin-bottom: 1.25rem; }
        .panel-hero h1 em { color: #6fe7ff; font-style: italic; }
        .panel-hero p { font-size: 14px; font-weight: 300; color: rgba(255,255,255,.7); line-height: 1.8; max-width: 420px; }

        .panel-stats { display: flex; gap: 2.5rem; padding-top: 1.75rem; border-top: 1px solid rgba(255,255,255,.12); position: relative; z-index: 2; }
        .stat-val { font-family: 'Playfair Display', serif; font-size: 32px; color: #fff; font-weight: 700; }
        .stat-lbl { font-size: 11px; color: #8de7ff; margin-top: 2px; }

        /* RIGHT */
        .panel-right { background: #f4f8fb; display: flex; align-items: center; justify-content: center; padding: 2.5rem; }
        .login-box { width: 100%; max-width: 360px; }
        .login-box h2 { font-family: 'Playfair Display', serif; font-size: 26px; color: var(--navy); margin-bottom: 6px; }
        .login-box .sub { font-size: 13px; color: var(--muted); margin-bottom: 2rem; font-weight: 300; }

        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; font-size: 11px; font-weight: 600; color: #3a5a72; text-transform: uppercase; letter-spacing: .6px; margin-bottom: 6px; }
        .form-group input {
            width: 100%; background: #fff; border: 1px solid var(--border); border-radius: 10px;
            padding: 11px 14px; font-size: 13px; color: #1a2e42;
            font-family: 'Plus Jakarta Sans', sans-serif; outline: none;
            transition: border-color .15s, box-shadow .15s;
        }
        .form-group input:focus { border-color: #4a90c4; box-shadow: 0 0 0 3px rgba(74,144,196,.12); }
        .form-group input.is-invalid { border-color: var(--danger); }
        .err-msg { font-size: 11px; color: var(--danger); margin-top: 4px; }

        .remember-row { display: flex; align-items: center; gap: 8px; margin-bottom: 1.5rem; }
        .remember-row input[type="checkbox"] { width: 15px; height: 15px; accent-color: var(--mid); cursor: pointer; }
        .remember-row label { font-size: 12px; color: var(--muted); cursor: pointer; }

        .btn-login {
            width: 100%; background: var(--navy); color: #fff; border: none; border-radius: 10px;
            padding: 13px; font-size: 14px; font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer;
            transition: background .2s, transform .1s; letter-spacing: .3px;
        }
        .btn-login:hover { background: #1565a0; }
        .btn-login:active { transform: scale(.99); }

        .alert-error { background: #fde8e8; border: 1px solid #f0b3b3; border-radius: 8px; padding: 10px 14px; font-size: 12px; color: #9a2222; margin-bottom: 1.25rem; }
        .alert-success { background: #e0f5f0; border: 1px solid #0d6e4a; border-radius: 8px; padding: 10px 14px; font-size: 12px; color: #0d6e4a; margin-bottom: 1.25rem; }
        .login-footer { margin-top: 1.5rem; text-align: center; font-size: 11px; color: var(--muted); }

        @media (max-width: 768px) {
            body { grid-template-columns: 1fr; }
            .panel-left { display: none; }
            .panel-right { padding: 2rem 1.5rem; background: #fff; }
        }
    </style>
</head>
<body>

<div class="panel-left">
    <div class="brand">
        <div class="brand-drop"><span></span></div>
        <span class="brand-name">EXPROWATER</span>
    </div>
    <div class="panel-hero">
        <h1>Solusi Air Bersih<br><em>Terpercaya</em><br>untuk Indonesia</h1>
        <p>Platform manajemen pesanan dan distribusi produk pengolahan air Exprowater — efisien, modern, dan terorganisir.</p>
        <div class="panel-stats">
            <div><div class="stat-val">500+</div><div class="stat-lbl">Proyek Selesai</div></div>
            <div><div class="stat-val">15+</div><div class="stat-lbl">Tahun Pengalaman</div></div>
            <div><div class="stat-val">98%</div><div class="stat-lbl">Kepuasan Klien</div></div>
        </div>
    </div>
</div>

<div class="panel-right">
    <div class="login-box">
        <h2>Selamat Datang</h2>
        <p class="sub">Masuk untuk mengelola pesanan Exprowater.</p>

        @if($errors->any())
            <div class="alert-error">{{ $errors->first('email') }}</div>
        @endif
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    placeholder="nama@email.com" required autofocus
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                @error('email')<div class="err-msg">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password"
                    placeholder="••••••••" required
                    class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                @error('password')<div class="err-msg">{{ $message }}</div>@enderror
            </div>
            <div class="remember-row">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ingat saya</label>
            </div>
            <button type="submit" class="btn-login">Masuk →</button>
        </form>

        <div class="login-footer">&copy; {{ date('Y') }} Exprowater — Sistem Manajemen Order</div>
    </div>
</div>

</body>
</html>