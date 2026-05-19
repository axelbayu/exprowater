@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
<style>
    /* ── HERO ── */
    .hero {
        background: linear-gradient(135deg, #0a3d62 0%, #1565a0 55%, #0d7a7a 100%);
        border-radius: 14px;
        padding: 3.5rem 2.5rem;
        position: relative;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .hero::before {
        content: '';
        position: absolute;
        width: 320px; height: 320px;
        border-radius: 50%;
        border: 65px solid rgba(255,255,255,.07);
        right: -80px; top: -80px;
    }
    .hero::after {
        content: '';
        position: absolute;
        width: 180px; height: 180px;
        border-radius: 50%;
        border: 40px solid rgba(255,255,255,.05);
        left: 5%; bottom: -60px;
    }
    .hero-inner { position: relative; z-index: 2; max-width: 520px; }
    .hero-badge {
        display: inline-block;
        background: rgba(255,255,255,.15);
        color: #b3e5fc;
        font-size: 10px;
        letter-spacing: 1.3px;
        text-transform: uppercase;
        padding: 4px 14px;
        border-radius: 20px;
        margin-bottom: 1rem;
    }
    .hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 36px;
        color: #fff;
        line-height: 1.2;
        margin-bottom: .75rem;
    }
    .hero h1 em { color: #80deea; font-style: normal; }
    .hero p {
        font-size: 13px;
        color: #b0d4ea;
        font-weight: 300;
        line-height: 1.65;
        margin-bottom: 1.75rem;
        max-width: 400px;
    }
    .hero-btns { display: flex; gap: 10px; flex-wrap: wrap; }
    .hero-stats {
        display: flex;
        gap: 2rem;
        margin-top: 2.5rem;
        padding-top: 1.5rem;
        border-top: .5px solid rgba(255,255,255,.15);
    }
    .hero-stat .n {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        font-weight: 700;
        color: #fff;
    }
    .hero-stat .l { font-size: 11px; color: #80deea; letter-spacing: .5px; margin-top: 1px; }

    /* ── FEATURE CARDS ── */
    .feat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 1.5rem;
    }
    .feat-card {
        background: #fff;
        border: .5px solid #cddce8;
        border-radius: 12px;
        padding: 1.25rem;
        transition: box-shadow .15s;
    }
    .feat-card:hover { box-shadow: 0 4px 16px rgba(10,61,98,.08); }
    .feat-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
        margin-bottom: 12px;
    }
    .feat-icon.blue  { background: #e6f3fb; }
    .feat-icon.teal  { background: #e0f5f0; }
    .feat-icon.amber { background: #faeeda; }
    .feat-card h3 { font-size: 13px; font-weight: 600; margin-bottom: 5px; }
    .feat-card p  { font-size: 12px; color: #6a8fa8; line-height: 1.55; font-weight: 300; }

    /* ── QUICK STATS ── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-bottom: 1.5rem;
    }
    .stat-card {
        background: #fff;
        border: .5px solid #cddce8;
        border-radius: 10px;
        padding: 1rem 1.25rem;
    }
    .stat-label { font-size: 11px; color: #6a8fa8; margin-bottom: 6px; }
    .stat-value { font-size: 22px; font-weight: 600; color: #0a3d62; }
    .stat-sub   { font-size: 10px; color: #6a8fa8; margin-top: 3px; }
</style>
@endpush

@section('content')
<div class="hero">
    <div class="hero-inner">
        <div class="hero-badge">Sistem Manajemen Order</div>
        <h1>Solusi Air Bersih<br><em>Terpercaya</em> untuk Indonesia</h1>
        <p>Platform manajemen pesanan dan distribusi produk pengolahan air Exprowater secara efisien dan terorganisir.</p>
        <div class="hero-btns">
            <a href="{{ route('orders.index') }}" class="btn btn-primary">Lihat Semua Orders</a>
            <a href="{{ route('orders.create') }}" class="btn btn-secondary" style="background:rgba(255,255,255,.15);color:#fff;border-color:rgba(255,255,255,.3);">+ Tambah Order</a>
        </div>
        <div class="hero-stats">
            <div class="hero-stat"><div class="n">500+</div><div class="l">Proyek Selesai</div></div>
            <div class="hero-stat"><div class="n">15+</div><div class="l">Tahun Pengalaman</div></div>
            <div class="hero-stat"><div class="n">98%</div><div class="l">Kepuasan Klien</div></div>
        </div>
    </div>
</div>

<div class="stats-row">
    <div class="stat-card">
        <div class="stat-label">Total Orders</div>
        <div class="stat-value">{{ $totalOrders ?? 0 }}</div>
        <div class="stat-sub">Semua waktu</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Pending</div>
        <div class="stat-value" style="color:#8a5a00;">{{ $pendingOrders ?? 0 }}</div>
        <div class="stat-sub">Menunggu proses</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Selesai</div>
        <div class="stat-value" style="color:#0d6e4a;">{{ $doneOrders ?? 0 }}</div>
        <div class="stat-sub">Bulan ini</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Nilai</div>
        <div class="stat-value" style="font-size:16px;">Rp {{ number_format($totalValue ?? 0, 0, ',', '.') }}</div>
        <div class="stat-sub">Keseluruhan</div>
    </div>
</div>

<div class="feat-grid">
    <div class="feat-card">
        <div class="feat-icon blue">💧</div>
        <h3>Manajemen Order</h3>
        <p>Kelola pesanan produk air dari pelanggan dengan mudah, cepat, dan terorganisir dalam satu platform.</p>
    </div>
    <div class="feat-card">
        <div class="feat-icon teal">📊</div>
        <h3>Laporan Real-time</h3>
        <p>Pantau status pengiriman dan penjualan secara langsung. Data selalu akurat dan terkini.</p>
    </div>
    <div class="feat-card">
        <div class="feat-icon amber">🔧</div>
        <h3>Manajemen Produk</h3>
        <p>Atur katalog produk filtrasi dan pengolahan air dengan efisien dan terstruktur.</p>
    </div>
</div>
@endsection