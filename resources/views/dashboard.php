@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1>Selamat Datang, {{ auth()->user()->name }} 👋</h1>
        <p>Ringkasan aktivitas pesanan Exprowater</p>
    </div>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">+ Tambah Order</a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#e6f3fb;">📦</div>
        <div>
            <div class="stat-title">Total Orders</div>
            <div class="stat-number">{{ $totalOrders }}</div>
            <div class="stat-sub">Semua waktu</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#faeeda;">⏳</div>
        <div>
            <div class="stat-title">Pending</div>
            <div class="stat-number" style="color:#8a5a00;">{{ $pendingOrders }}</div>
            <div class="stat-sub">Menunggu proses</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#e6f3fb;">🔄</div>
        <div>
            <div class="stat-title">Diproses</div>
            <div class="stat-number" style="color:#0a4a7a;">{{ $diprosesOrders }}</div>
            <div class="stat-sub">Sedang berjalan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#e0f5f0;">✅</div>
        <div>
            <div class="stat-title">Selesai Bulan Ini</div>
            <div class="stat-number" style="color:#0d6e4a;">{{ $doneOrders }}</div>
            <div class="stat-sub">{{ now()->translatedFormat('F Y') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fde8e8;">❌</div>
        <div>
            <div class="stat-title">Dibatalkan</div>
            <div class="stat-number" style="color:#9a2222;">{{ $batalOrders }}</div>
            <div class="stat-sub">Total keseluruhan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#e0f5f0;">💰</div>
        <div>
            <div class="stat-title">Total Nilai</div>
            <div class="stat-number" style="font-size:15px;">Rp {{ number_format($totalValue, 0, ',', '.') }}</div>
            <div class="stat-sub">Keseluruhan order</div>
        </div>
    </div>
</div>

<div class="card" style="margin-top:1.5rem;">
    <div style="padding:1rem 1.25rem;border-bottom:.5px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
        <span style="font-size:13px;font-weight:600;color:var(--text);">Order Terbaru</span>
        <a href="{{ route('orders.index') }}" style="font-size:11px;color:#4a90c4;text-decoration:none;">Lihat semua →</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                <tr>
                    <td style="color:#6a8fa8;font-size:11px;">{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td style="font-weight:500;">{{ $order->nama_pelanggan }}</td>
                    <td>{{ $order->produk }}</td>
                    <td>{{ $order->jumlah }} unit</td>
                    <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td>
                        @php
                            $badge = match($order->status) {
                                'selesai'    => 'badge-success',
                                'diproses'   => 'badge-info',
                                'dibatalkan' => 'badge-danger',
                                default      => 'badge-warning',
                            };
                        @endphp
                        <span class="badge {{ $badge }}">{{ ucfirst($order->status) }}</span>
                    </td>
                    <td style="color:#6a8fa8;font-size:11px;">
                        {{ \Carbon\Carbon::parse($order->tanggal_order)->format('d M Y') }}
                    </td>
                    <td>
                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-edit">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:2rem;color:#6a8fa8;">
                        Belum ada order.
                        <a href="{{ route('orders.create') }}" style="color:#0a3d62;">Buat sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
}
.stat-card {
    background: var(--surface);
    border: .5px solid var(--border);
    border-radius: 12px;
    padding: 1.1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}
.stat-icon {
    width: 46px; height: 46px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
}
.stat-title  { font-size: 11px; color: var(--muted); margin-bottom: 3px; }
.stat-number { font-size: 22px; font-weight: 700; color: var(--text); line-height: 1; }
.stat-sub    { font-size: 10px; color: var(--muted); margin-top: 3px; }
@media (max-width: 900px) { .stats-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 600px) { .stats-grid { grid-template-columns: 1fr; } }
</style>
@endpush