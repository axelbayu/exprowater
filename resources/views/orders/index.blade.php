@extends('layouts.app')

@section('title', 'Daftar Orders')

@push('styles')
<style>
    /* ── MONTHLY SUMMARY ── */
    .monthly-section {
        margin-bottom: 1.5rem;
    }
    .monthly-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: .75rem;
    }
    .monthly-section-header h2 {
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
        letter-spacing: .3px;
    }
    .monthly-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 12px;
    }
    .month-card {
        background: var(--surface);
        border: .5px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        transition: box-shadow .15s;
    }
    .month-card:hover { box-shadow: 0 4px 18px rgba(10,61,98,.09); }
    .month-card-header {
        background: linear-gradient(135deg, #003962 0%, #1565a0 100%);
        padding: .75rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .month-label {
        font-size: 13px;
        font-weight: 600;
        color: #fff;
        letter-spacing: .4px;
    }
    .month-order-count {
        background: rgba(255,255,255,.18);
        color: #b3e5fc;
        font-size: 10px;
        padding: 2px 8px;
        border-radius: 20px;
    }
    .month-card-body { padding: .9rem 1rem; }
    .month-total-main {
        font-size: 20px;
        font-weight: 600;
        color: var(--text);
        margin-bottom: .65rem;
        letter-spacing: -.3px;
    }
    .month-total-main span {
        font-size: 11px;
        font-weight: 400;
        color: var(--muted);
        margin-left: 3px;
    }
    .month-breakdown {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px;
    }
    .breakdown-item {
        background: #f5f8fc;
        border-radius: 7px;
        padding: 6px 8px;
    }
    .breakdown-label {
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: .7px;
        color: var(--muted);
        margin-bottom: 2px;
    }
    .breakdown-value {
        font-size: 11px;
        font-weight: 500;
    }
    .bv-selesai    { color: var(--success-txt); }
    .bv-diproses   { color: #0a4a7a; }
    .bv-pending    { color: var(--warn-txt); }
    .bv-dibatalkan { color: var(--danger-txt); }

    /* Toggle button */
    .toggle-monthly {
        background: none;
        border: .5px solid var(--border);
        border-radius: 6px;
        font-size: 11px;
        color: var(--muted);
        padding: 4px 10px;
        cursor: pointer;
        font-family: 'Plus Jakarta Sans', sans-serif;
        transition: background .12s;
    }
    .toggle-monthly:hover { background: var(--bg); }
</style>
@endpush

@section('content')
<div class="page-header">
    <div>
        <h1>Daftar Orders</h1>
        <p>Kelola semua pesanan produk Exprowater</p>
    </div>
    <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
        <a href="{{ route('orders.pdf', request()->query()) }}" target="_blank" class="btn btn-secondary">📄 Cetak PDF</a>
        <a href="{{ route('orders.pdf.save', request()->query()) }}" class="btn btn-secondary">💾 Simpan PDF</a>
        <a href="{{ route('orders.create') }}" class="btn btn-primary">+ Tambah Order</a>
    </div>
</div>

@if(session('success'))
    <div class="flash flash-success" style="margin-top:1rem;">{{ session('success') }}
        @if(session('pdf_url'))
            <a href="{{ session('pdf_url') }}" target="_blank">Buka PDF</a>
        @endif
    </div>
@endif
@if(session('error'))
    <div class="flash flash-error" style="margin-top:1rem;">{{ session('error') }}</div>
@endif

@if($monthlyTotals->count() > 0)
<div class="monthly-section">
    <div class="monthly-section-header">
        <h2>📅 Total Pembayaran per Bulan</h2>
        <button class="toggle-monthly" onclick="toggleMonthly(this)">Sembunyikan</button>
    </div>
    <div class="monthly-grid" id="monthlyGrid">
        @php
            $namaBulan = [
                1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April',
                5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus',
                9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
            ];
        @endphp
        @foreach($monthlyTotals as $row)
        <div class="month-card">
            <div class="month-card-header">
                <span class="month-label">{{ $namaBulan[$row->bulan] }} {{ $row->tahun }}</span>
                <span class="month-order-count">{{ $row->jumlah_order }} order</span>
            </div>
            <div class="month-card-body">
                <div class="month-total-main">
                    Rp {{ number_format($row->total ?? 0, 0, ',', '.') }}
                    <span>total keseluruhan</span>
                </div>
                <div class="month-breakdown">
                    <div class="breakdown-item">
                        <div class="breakdown-label">Selesai</div>
                        <div class="breakdown-value bv-selesai">Rp {{ number_format($row->total_selesai ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="breakdown-item">
                        <div class="breakdown-label">Diproses</div>
                        <div class="breakdown-value bv-diproses">Rp {{ number_format($row->total_diproses ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="breakdown-item">
                        <div class="breakdown-label">Pending</div>
                        <div class="breakdown-value bv-pending">Rp {{ number_format($row->total_pending ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="breakdown-item">
                        <div class="breakdown-label">Dibatalkan</div>
                        <div class="breakdown-value bv-dibatalkan">Rp {{ number_format($row->total_dibatalkan ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

@if(session('pdf_url'))
    <div class="flash flash-success">PDF disimpan: <a href="{{ session('pdf_url') }}" target="_blank">Buka PDF</a></div>
@endif

<div class="card">
    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('orders.index') }}">
        <div class="filters">
            <input
                class="filter-input"
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama pelanggan atau produk..."
            >
            <select class="filter-select" name="status" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="pending"    {{ request('status') == 'pending'    ? 'selected' : '' }}>Pending</option>
                <option value="diproses"   {{ request('status') == 'diproses'   ? 'selected' : '' }}>Diproses</option>
                <option value="selesai"    {{ request('status') == 'selesai'    ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            <button type="submit" class="btn btn-secondary" style="padding:7px 14px;">Cari</button>
            @if(request('search') || request('status'))
                <a href="{{ route('orders.index') }}" class="btn btn-secondary" style="padding:7px 14px;">Reset</a>
            @endif
            @if(class_exists(\Barryvdh\DomPDF\Facade\Pdf::class))
                <a href="{{ route('orders.pdf.save', request()->query()) }}" class="btn btn-secondary" style="padding:7px 14px;">💾 Simpan PDF Semua</a>
            @endif
        </div>
    </form>

    {{-- Table --}}
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
                @forelse($orders as $order)
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
                                default      => 'badge-info',
                            };
                        @endphp
                        <span class="badge {{ $badge }}">{{ ucfirst($order->status) }}</span>
                    </td>
                    <td style="color:#6a8fa8;font-size:11px;">
                        {{ \Carbon\Carbon::parse($order->tanggal_order)->format('d M Y') }}
                    </td>
                    <td>
                            <div class="action-btns">
                                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus order ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-delete">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:2.5rem;color:#6a8fa8;">
                        Belum ada data order.
                        <a href="{{ route('orders.create') }}" style="color:#0a3d62;">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="pagination-wrap">
        <span>
            Menampilkan {{ $orders->firstItem() ?? 0 }}–{{ $orders->lastItem() ?? 0 }}
            dari {{ $orders->total() }} data
        </span>
        <div class="pagination">
            {{-- Previous --}}
            <a href="{{ $orders->previousPageUrl() }}"
               class="page-btn {{ $orders->onFirstPage() ? 'disabled' : '' }}">‹</a>

            @foreach($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                <a href="{{ $url }}"
                   class="page-btn {{ $orders->currentPage() == $page ? 'active' : '' }}">
                    {{ $page }}
                </a>
            @endforeach

            {{-- Next --}}
            <a href="{{ $orders->nextPageUrl() }}"
               class="page-btn {{ !$orders->hasMorePages() ? 'disabled' : '' }}">›</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleMonthly(btn) {
    const grid = document.getElementById('monthlyGrid');
    if (grid.style.display === 'none') {
        grid.style.display = 'grid';
        btn.textContent = 'Sembunyikan';
    } else {
        grid.style.display = 'none';
        btn.textContent = 'Tampilkan';
    }
}
</script>
@endpush