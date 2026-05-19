@extends('layouts.app')

@section('title', 'Daftar Orders')

@section('content')
<div class="page-header">
    <div>
        <h1>Daftar Orders</h1>
        <p>Kelola semua pesanan produk Exprowater</p>
    </div>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">+ Tambah Order</a>
</div>

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