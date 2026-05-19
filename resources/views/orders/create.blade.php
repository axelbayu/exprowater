@extends('layouts.app')

@section('title', 'Tambah Order')

@section('content')
<div class="page-header">
    <div>
        <h1>Tambah Order Baru</h1>
        <p>Isi formulir berikut untuk membuat order baru</p>
    </div>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="padding:1.5rem;">
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div class="section-divider">Informasi Pelanggan</div>
        <div class="form-grid" style="margin-bottom:1.25rem;">
            <div class="form-group">
                <label for="nama_pelanggan">Nama Pelanggan <span style="color:#e24b4a;">*</span></label>
                <input
                    type="text"
                    id="nama_pelanggan"
                    name="nama_pelanggan"
                    class="form-control {{ $errors->has('nama_pelanggan') ? 'is-invalid' : '' }}"
                    value="{{ old('nama_pelanggan') }}"
                    placeholder="Masukkan nama pelanggan atau perusahaan"
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
                    value="{{ old('telepon') }}"
                    placeholder="08xx-xxxx-xxxx"
                >
                @error('telepon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="section-divider">Detail Order</div>
        <div class="form-grid">
            <div class="form-group">
                <label for="produk">Produk <span style="color:#e24b4a;">*</span></label>
                <select id="produk" name="produk"
                        class="form-control {{ $errors->has('produk') ? 'is-invalid' : '' }}"
                        required onchange="hitungTotal()">
                    <option value="">Pilih produk...</option>
                    @foreach($produkList as $nama => $harga)
                        <option value="{{ $nama }}"
                            data-harga="{{ $harga }}"
                            {{ old('produk') == $nama ? 'selected' : '' }}>
                            {{ $nama }} — Rp {{ number_format($harga, 0, ',', '.') }}/unit
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
                    value="{{ old('jumlah', 1) }}"
                    min="1"
                    required
                    oninput="hitungTotal()"
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
                    value="{{ old('total_harga') }}"
                    min="0"
                    readonly
                    style="background:#f0f4f8;cursor:default;"
                    placeholder="Otomatis terisi setelah pilih produk"
                >
                <span id="rincian-harga" class="form-hint" style="display:none;"></span>
                @error('total_harga')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status Order <span style="color:#e24b4a;">*</span></label>
                <select id="status" name="status"
                        class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" required>
                    <option value="pending"    {{ old('status', 'pending') == 'pending'    ? 'selected' : '' }}>Pending</option>
                    <option value="diproses"   {{ old('status') == 'diproses'   ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai"    {{ old('status') == 'selesai'    ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ old('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
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
                    value="{{ old('tanggal_order', date('Y-m-d')) }}"
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
                >{{ old('catatan') }}</textarea>
                <span class="form-hint">Informasi tambahan, instruksi pengiriman, atau permintaan khusus.</span>
                @error('catatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Order</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function hitungTotal() {
    var produkEl  = document.getElementById('produk');
    var jumlahEl  = document.getElementById('jumlah');
    var totalEl   = document.getElementById('total_harga');
    var rincianEl = document.getElementById('rincian-harga');

    var selectedOption = produkEl.options[produkEl.selectedIndex];
    var harga  = parseInt(selectedOption.getAttribute('data-harga')) || 0;
    var jumlah = parseInt(jumlahEl.value) || 0;

    if (harga > 0 && jumlah > 0) {
        var total = harga * jumlah;
        totalEl.value = total;

        var fmt = function(n) {
            return 'Rp ' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        };
        rincianEl.textContent = fmt(harga) + ' \u00d7 ' + jumlah + ' unit = ' + fmt(total);
        rincianEl.style.display = 'block';
    } else {
        totalEl.value = '';
        rincianEl.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    hitungTotal();
});
</script>
@endpush