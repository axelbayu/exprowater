@extends('layouts.app')

@section('title', 'Edit Order #' . str_pad($order->id, 3, '0', STR_PAD_LEFT))

@section('content')
<div class="page-header">
    <div>
        <h1>Edit Order <span style="color:#6a8fa8;font-weight:300;">#{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</span></h1>
        <p>Perbarui informasi order dari {{ $order->nama_pelanggan }}</p>
    </div>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="padding:1.5rem;">
    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="section-divider">Informasi Pelanggan</div>
        <div class="form-grid" style="margin-bottom:1.25rem;">
            <div class="form-group">
                <label for="nama_pelanggan">Nama Pelanggan <span style="color:#e24b4a;">*</span></label>
                <input
                    type="text"
                    id="nama_pelanggan"
                    name="nama_pelanggan"
                    class="form-control {{ $errors->has('nama_pelanggan') ? 'is-invalid' : '' }}"
                    value="{{ old('nama_pelanggan', $order->nama_pelanggan) }}"
                    required
                >
                @error('nama_pelanggan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="telepon">No. Telepon</label>
                <input
                    type="text"
                    id="telepon"
                    name="telepon"
                    class="form-control {{ $errors->has('telepon') ? 'is-invalid' : '' }}"
                    value="{{ old('telepon', $order->telepon) }}"
                    placeholder="08xx-xxxx-xxxx"
                >
                @error('telepon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group full">
                <label for="alamat">Alamat Pengiriman</label>
                <input
                    type="text"
                    id="alamat"
                    name="alamat"
                    class="form-control {{ $errors->has('alamat') ? 'is-invalid' : '' }}"
                    value="{{ old('alamat', $order->alamat) }}"
                    placeholder="Masukkan alamat lengkap pengiriman"
                >
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="section-divider">Detail Order</div>
        <div class="form-grid">
            <div class="form-group">
                <label for="produk">Produk <span style="color:#e24b4a;">*</span></label>
                <select id="produk" name="produk"
                        class="form-control {{ $errors->has('produk') ? 'is-invalid' : '' }}" required>
                    <option value="">Pilih produk...</option>
                    @foreach([
                        'Expro Water',
                    ] as $item)
                        <option value="{{ $item }}"
                            {{ old('produk', $order->produk) == $item ? 'selected' : '' }}>
                            {{ $item }}
                        </option>
                    @endforeach
                </select>
                @error('produk')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="jumlah">Jumlah Unit <span style="color:#e24b4a;">*</span></label>
                <input
                    type="number"
                    id="jumlah"
                    name="jumlah"
                    class="form-control {{ $errors->has('jumlah') ? 'is-invalid' : '' }}"
                    value="{{ old('jumlah', $order->jumlah) }}"
                    min="1"
                    required
                >
                @error('jumlah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="total_harga">Total Harga (Rp)</label>
                <input
                    type="number"
                    id="total_harga"
                    name="total_harga"
                    class="form-control {{ $errors->has('total_harga') ? 'is-invalid' : '' }}"
                    value="{{ old('total_harga', $order->total_harga) }}"
                    min="0"
                >
                @error('total_harga')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status Order <span style="color:#e24b4a;">*</span></label>
                <select id="status" name="status"
                        class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" required>
                    @foreach(['pending', 'diproses', 'selesai', 'dibatalkan'] as $s)
                        <option value="{{ $s }}" {{ old('status', $order->status) == $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal_order">Tanggal Order <span style="color:#e24b4a;">*</span></label>
                <input
                    type="date"
                    id="tanggal_order"
                    name="tanggal_order"
                    class="form-control {{ $errors->has('tanggal_order') ? 'is-invalid' : '' }}"
                    value="{{ old('tanggal_order', \Carbon\Carbon::parse($order->tanggal_order)->format('Y-m-d')) }}"
                    required
                >
                @error('tanggal_order')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group full">
                <label for="catatan">Catatan</label>
                <textarea
                    id="catatan"
                    name="catatan"
                    class="form-control {{ $errors->has('catatan') ? 'is-invalid' : '' }}"
                    rows="3"
                    placeholder="Catatan tambahan untuk order ini (opsional)..."
                >{{ old('catatan', $order->catatan) }}</textarea>
                <span class="form-hint">Informasi tambahan, instruksi pengiriman, atau permintaan khusus.</span>
                @error('catatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update Order</button>
        </div>
    </form>
</div>
@endsection