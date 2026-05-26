<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Order #{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #1a2e42; }
        .header { margin-bottom: 12px; }
        .meta { margin-bottom: 10px; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #ccd5dd; padding: 8px 10px; }
        th { background: #f1f5f9; text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Order #{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</h2>
        <div class="meta">Pelanggan: {{ $order->nama_pelanggan }} &nbsp; | &nbsp; Telepon: {{ $order->telepon ?? '-' }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $order->produk }}</td>
                <td>{{ $order->jumlah }} unit</td>
                <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>{{ \Carbon\Carbon::parse($order->tanggal_order)->format('d M Y') }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top:16px;font-size:12px;">Catatan: {{ $order->catatan ?? '-' }}</div>
</body>
</html>
