<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Orders</title>
    <style>
        body { font-family: Arial, sans-serif; color: #1a2e42; }
        header { margin-bottom: 20px; }
        h1 { font-size: 20px; margin-bottom: 0; }
        p { margin: 4px 0 0; font-size: 12px; color: #555; }
        .summary { margin: 20px 0; font-size: 12px; }
        .summary span { display: inline-block; margin-right: 18px; }
        table { width: 100%; border-collapse: collapse; font-size: 11px; }
        th, td { border: 1px solid #ccd5dd; padding: 8px 10px; }
        th { background: #f1f5f9; text-align: left; }
        td { vertical-align: top; }
        .text-right { text-align: right; }
        .badge { display: inline-block; padding: 3px 7px; border-radius: 12px; font-size: 10px; }
        .badge-selesai { background: #e6f8ef; color: #0d6e4a; }
        .badge-diproses { background: #e8f2fb; color: #0a4a7a; }
        .badge-pending { background: #fff4d5; color: #8a5a00; }
        .badge-dibatalkan { background: #fde8e8; color: #9a2222; }
        .footer { margin-top: 30px; font-size: 11px; color: #555; }
    </style>
</head>
<body>
    <header>
        <h1>Daftar Orders Exprowater</h1>
        <p>Dicetak pada {{ now()->format('d M Y H:i') }}</p>
    </header>

    @php
        $statusLabels = [
            'selesai' => 'Selesai',
            'diproses' => 'Diproses',
            'pending' => 'Pending',
            'dibatalkan' => 'Dibatalkan',
        ];
    @endphp

    @if($monthlyTotals->count())
        <div class="summary">
            @foreach($monthlyTotals as $row)
                <span><strong>{{ $row->bulan }}/{{ $row->tahun }}</strong> Rp {{ number_format($row->total ?? 0, 0, ',', '.') }}</span>
            @endforeach
        </div>
    @endif

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
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $order->nama_pelanggan }}</td>
                    <td>{{ $order->produk }}</td>
                    <td class="text-right">{{ $order->jumlah }}</td>
                    <td class="text-right">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge badge-{{ $order->status }}">{{ $statusLabels[$order->status] ?? ucfirst($order->status) }}</span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($order->tanggal_order)->format('d M Y') }}</td>
                    <td>{{ $order->catatan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding: 20px;">Tidak ada data order.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total order: {{ $orders->count() }}</p>
    </div>
</body>
</html>
