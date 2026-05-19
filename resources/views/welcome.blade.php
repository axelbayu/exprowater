<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Exprowater')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        *{
            font-family: 'Poppins', sans-serif;
        }

        body{
            background:#eef3f8;
            margin:0;
            padding:0;
        }

        /* ===== NAVBAR ===== */
        .navbar-custom{
            background:#003f6b;
            padding:14px 28px;
        }

        .brand-logo{
            display:flex;
            align-items:center;
            gap:12px;
            color:white;
            text-decoration:none;
            font-weight:700;
            font-size:28px;
        }

        .brand-circle{
            width:36px;
            height:36px;
            border-radius:50%;
            background:#00bfff;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#003f6b;
            font-weight:bold;
        }

        .user-box{
            display:flex;
            align-items:center;
            gap:10px;
        }

        .user-avatar{
            width:38px;
            height:38px;
            border-radius:50%;
            background:#00bfff;
            color:#003f6b;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:600;
        }

        .logout-btn{
            border:1px solid rgba(255,255,255,.4);
            color:white;
            padding:6px 16px;
            border-radius:8px;
            text-decoration:none;
            font-size:13px;
        }

        .logout-btn:hover{
            background:white;
            color:#003f6b;
        }

        /* ===== HERO ===== */
        .hero{
            background:linear-gradient(135deg,#0a3d62 0%,#1565a0 55%,#0d7a7a 100%);
            border-radius:18px;
            padding:60px;
            position:relative;
            overflow:hidden;
            margin-top:25px;
            margin-bottom:25px;
        }

        .hero::before{
            content:'';
            position:absolute;
            width:340px;
            height:340px;
            border-radius:50%;
            border:70px solid rgba(255,255,255,.07);
            right:-90px;
            top:-90px;
        }

        .hero::after{
            content:'';
            position:absolute;
            width:220px;
            height:220px;
            border-radius:50%;
            border:45px solid rgba(255,255,255,.05);
            left:20px;
            bottom:-80px;
        }

        .hero-content{
            position:relative;
            z-index:2;
            max-width:650px;
        }

        .hero-badge{
            display:inline-block;
            background:rgba(255,255,255,.12);
            color:#b3e5fc;
            font-size:11px;
            padding:6px 16px;
            border-radius:30px;
            margin-bottom:20px;
            letter-spacing:1px;
        }

        .hero h1{
            font-family:'Playfair Display', serif;
            color:white;
            font-size:58px;
            line-height:1.1;
            margin-bottom:18px;
        }

        .hero h1 span{
            color:#6fe7ff;
        }

        .hero p{
            color:#d7edf9;
            font-size:15px;
            line-height:1.8;
            max-width:520px;
            margin-bottom:35px;
        }

        /* ===== LOGIN ===== */
        .login-form{
            display:flex;
            gap:14px;
            flex-wrap:wrap;
            margin-bottom:35px;
        }

        .login-form input{
            border:none;
            padding:14px 18px;
            border-radius:10px;
            min-width:240px;
            outline:none;
        }

        .login-form button{
            background:white;
            color:#003f6b;
            border:none;
            padding:14px 26px;
            border-radius:10px;
            font-weight:600;
            transition:.2s;
        }

        .login-form button:hover{
            background:#dff6ff;
        }

        /* ===== STATS ===== */
        .hero-stats{
            display:flex;
            gap:50px;
            border-top:1px solid rgba(255,255,255,.15);
            padding-top:28px;
        }

        .hero-stat-number{
            color:white;
            font-size:42px;
            font-family:'Playfair Display', serif;
            font-weight:700;
        }

        .hero-stat-label{
            color:#8de7ff;
            font-size:13px;
        }

        /* ===== CARDS ===== */
        .stats-grid{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:16px;
            margin-bottom:25px;
        }

        .stat-card{
            background:white;
            border-radius:14px;
            padding:22px;
            border:1px solid #dce7f1;
        }

        .stat-title{
            font-size:13px;
            color:#6f8ca3;
            margin-bottom:8px;
        }

        .stat-number{
            font-size:28px;
            font-weight:700;
            color:#003f6b;
        }

        .stat-sub{
            margin-top:4px;
            font-size:11px;
            color:#7d97ab;
        }

        /* ===== FEATURE ===== */
        .feature-grid{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:18px;
        }

        .feature-card{
            background:white;
            border-radius:16px;
            padding:25px;
            border:1px solid #dce7f1;
            transition:.2s;
        }

        .feature-card:hover{
            transform:translateY(-4px);
            box-shadow:0 8px 22px rgba(0,0,0,.05);
        }

        .feature-icon{
            width:50px;
            height:50px;
            border-radius:14px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:24px;
            margin-bottom:16px;
        }

        .blue{
            background:#e5f3ff;
        }

        .green{
            background:#e7f8f1;
        }

        .orange{
            background:#fff2df;
        }

        .feature-card h3{
            font-size:18px;
            margin-bottom:10px;
            color:#003f6b;
        }

        .feature-card p{
            color:#6f8ca3;
            font-size:14px;
            line-height:1.7;
        }

        /* ===== RESPONSIVE ===== */
        @media(max-width:992px){

            .stats-grid{
                grid-template-columns:repeat(2,1fr);
            }

            .feature-grid{
                grid-template-columns:1fr;
            }

            .hero h1{
                font-size:42px;
            }
        }

        @media(max-width:768px){

            .hero{
                padding:35px 25px;
            }

            .stats-grid{
                grid-template-columns:1fr;
            }

            .hero-stats{
                flex-direction:column;
                gap:20px;
            }

            .login-form{
                flex-direction:column;
            }

            .login-form input,
            .login-form button{
                width:100%;
            }

            .hero h1{
                font-size:34px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="navbar-custom d-flex justify-content-between align-items-center">

        <a href="#" class="brand-logo">
            <div class="brand-circle">O</div>
            EXPROWATER
        </a>

        <div class="user-box">

            <div class="user-avatar">
                AX
            </div>

            <span class="text-white">
                Axel Bayu
            </span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="logout-btn">
                    Logout
                </button>
            </form>

        </div>

    </nav>

    {{-- CONTENT --}}
    <div class="container-fluid px-4">

        <div class="hero">

            <div class="hero-content">

                <div class="hero-badge">
                    SISTEM MANAJEMEN ORDER
                </div>

                <h1>
                    Solusi Air Bersih
                    <br>
                    <span>Terpercaya</span> untuk Indonesia
                </h1>

                <p>
                    Platform manajemen pesanan dan distribusi produk pengolahan air Exprowater 
                    secara efisien, modern, dan terorganisir.
                </p>

                {{-- LOGIN --}}
                <form action="{{ route('auth.login') }}" method="POST" class="login-form">
                    @csrf

                    <input 
                        type="email"
                        name="email"
                        placeholder="Masukkan Email"
                        required
                    >

                    <input 
                        type="password"
                        name="password"
                        placeholder="Masukkan Password"
                        required
                    >

                    <button type="submit">
                        Login
                    </button>
                </form>

                {{-- HERO STATS --}}
                <div class="hero-stats">

                    <div>
                        <div class="hero-stat-number">500+</div>
                        <div class="hero-stat-label">Proyek Selesai</div>
                    </div>

                    <div>
                        <div class="hero-stat-number">15+</div>
                        <div class="hero-stat-label">Tahun Pengalaman</div>
                    </div>

                    <div>
                        <div class="hero-stat-number">98%</div>
                        <div class="hero-stat-label">Kepuasan Klien</div>
                    </div>

                </div>

            </div>

        </div>

        {{-- QUICK STATS --}}
        <div class="stats-grid">

            <div class="stat-card">
                <div class="stat-title">Total Orders</div>
                <div class="stat-number">{{ $totalOrders ?? 0 }}</div>
                <div class="stat-sub">Semua waktu</div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Pending</div>
                <div class="stat-number text-warning">{{ $pendingOrders ?? 0 }}</div>
                <div class="stat-sub">Menunggu proses</div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Selesai</div>
                <div class="stat-number text-success">{{ $doneOrders ?? 0 }}</div>
                <div class="stat-sub">Bulan ini</div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Total Nilai</div>
                <div class="stat-number" style="font-size:22px;">
                    Rp {{ number_format($totalValue ?? 0,0,',','.') }}
                </div>
                <div class="stat-sub">Keseluruhan</div>
            </div>

        </div>

        {{-- FEATURE --}}
        <div class="feature-grid">

            <div class="feature-card">

                <div class="feature-icon blue">
                    💧
                </div>

                <h3>Manajemen Order</h3>

                <p>
                    Kelola pesanan produk air dari pelanggan dengan cepat,
                    rapi, dan efisien dalam satu platform modern.
                </p>

            </div>

            <div class="feature-card">

                <div class="feature-icon green">
                    📊
                </div>

                <h3>Laporan Real-time</h3>

                <p>
                    Pantau status pengiriman dan penjualan secara langsung
                    dengan data yang selalu update.
                </p>

            </div>

            <div class="feature-card">

                <div class="feature-icon orange">
                    🔧
                </div>

                <h3>Manajemen Produk</h3>

                <p>
                    Atur katalog produk filtrasi dan pengolahan air dengan
                    sistem yang terstruktur dan mudah digunakan.
                </p>

            </div>

        </div>

    </div>

</body>
</html>