<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    private array $produkList = [
        'Expro Water' => 10000,
    ];

    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('produk', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        // MySQL compatible
        $monthlyTotals = Order::select(
                DB::raw('YEAR(tanggal_order) as tahun'),
                DB::raw('MONTH(tanggal_order) as bulan'),
                DB::raw('SUM(total_harga) as total'),
                DB::raw('COUNT(*) as jumlah_order'),
                DB::raw('SUM(CASE WHEN status = "selesai" THEN total_harga ELSE 0 END) as total_selesai'),
                DB::raw('SUM(CASE WHEN status = "pending" THEN total_harga ELSE 0 END) as total_pending'),
                DB::raw('SUM(CASE WHEN status = "diproses" THEN total_harga ELSE 0 END) as total_diproses'),
                DB::raw('SUM(CASE WHEN status = "dibatalkan" THEN total_harga ELSE 0 END) as total_dibatalkan')
            )
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        return view('orders.index', compact('orders', 'monthlyTotals'));
    }

    public function exportPdf(Request $request)
    {
        if (! class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return redirect()->route('orders.index')
                ->with('error', 'Fitur cetak PDF belum tersedia. Jalankan composer require barryvdh/laravel-dompdf.');
        }

        $query = Order::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('produk', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->get();

        $monthlyTotals = Order::select(
                DB::raw('YEAR(tanggal_order) as tahun'),
                DB::raw('MONTH(tanggal_order) as bulan'),
                DB::raw('SUM(total_harga) as total'),
                DB::raw('COUNT(*) as jumlah_order'),
                DB::raw('SUM(CASE WHEN status = "selesai" THEN total_harga ELSE 0 END) as total_selesai'),
                DB::raw('SUM(CASE WHEN status = "pending" THEN total_harga ELSE 0 END) as total_pending'),
                DB::raw('SUM(CASE WHEN status = "diproses" THEN total_harga ELSE 0 END) as total_diproses'),
                DB::raw('SUM(CASE WHEN status = "dibatalkan" THEN total_harga ELSE 0 END) as total_dibatalkan')
            )
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('orders.pdf', compact('orders', 'monthlyTotals'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('orders-' . now()->format('Ymd_His') . '.pdf');
    }

    public function savePdf(Request $request)
    {
        if (! class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return redirect()->route('orders.index')
                ->with('error', 'Fitur cetak PDF belum tersedia. Jalankan composer require barryvdh/laravel-dompdf.');
        }

        $query = Order::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('produk', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->get();

        $monthlyTotals = Order::select(
                DB::raw('YEAR(tanggal_order) as tahun'),
                DB::raw('MONTH(tanggal_order) as bulan'),
                DB::raw('SUM(total_harga) as total'),
                DB::raw('COUNT(*) as jumlah_order'),
                DB::raw('SUM(CASE WHEN status = "selesai" THEN total_harga ELSE 0 END) as total_selesai'),
                DB::raw('SUM(CASE WHEN status = "pending" THEN total_harga ELSE 0 END) as total_pending'),
                DB::raw('SUM(CASE WHEN status = "diproses" THEN total_harga ELSE 0 END) as total_diproses'),
                DB::raw('SUM(CASE WHEN status = "dibatalkan" THEN total_harga ELSE 0 END) as total_dibatalkan')
            )
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('orders.pdf', compact('orders', 'monthlyTotals'))
            ->setPaper('a4', 'landscape');

        $output = $pdf->output();
        $filename = 'orders-' . now()->format('Ymd_His') . '.pdf';
        $folder = 'orders';

        // pastikan folder ada dan simpan di disk public
        Storage::disk('public')->put($folder . '/' . $filename, $output);
        $url = Storage::disk('public')->url($folder . '/' . $filename);

        return redirect()->route('orders.index')
            ->with('success', 'PDF berhasil disimpan.')
            ->with('pdf_url', $url);
    }

    public function create()
    {
        $produkList = $this->produkList;
        return view('orders.create', compact('produkList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'telepon'        => 'nullable|string|max:50',
            'produk'         => 'required|string|max:255',
            'jumlah'         => 'required|integer|min:1',
            'total_harga'    => 'nullable|numeric|min:0',
            'status'         => 'required|in:pending,diproses,selesai,dibatalkan',
            'tanggal_order'  => 'required|date',
            'catatan'        => 'nullable|string|max:1000',
        ]);

        // Hitung total_harga di server berdasarkan harga produk dan jumlah
        $hargaProduk = $this->produkList[$data['produk']] ?? 0;
        $data['total_harga'] = ($hargaProduk * ($data['jumlah'] ?? 0));

        Order::create($data);

        return redirect()->route('orders.index')
            ->with('success', 'Order berhasil dibuat.');
    }

    public function edit(Order $order)
    {
        $produkList = $this->produkList;
        return view('orders.edit', compact('order', 'produkList'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'telepon'        => 'nullable|string|max:50',
            'produk'         => 'required|string|max:255',
            'jumlah'         => 'required|integer|min:1',
            'total_harga'    => 'nullable|numeric|min:0',
            'status'         => 'required|in:pending,diproses,selesai,dibatalkan',
            'tanggal_order'  => 'required|date',
            'catatan'        => 'nullable|string|max:1000',
        ]);

        // Pastikan total_harga selalu konsisten dengan harga produk di server
        $hargaProduk = $this->produkList[$data['produk']] ?? 0;
        $data['total_harga'] = ($hargaProduk * ($data['jumlah'] ?? 0));

        $order->update($data);

        return redirect()->route('orders.index')
            ->with('success', 'Order berhasil diperbarui.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')
            ->with('success', 'Order berhasil dihapus.');
    }

    public function saveOrderPdf(Order $order)
    {
        if (! class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return redirect()->route('orders.index')
                ->with('error', 'Fitur cetak PDF belum tersedia. Jalankan composer require barryvdh/laravel-dompdf.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('orders.single_pdf', compact('order'))
            ->setPaper('a4', 'portrait');

        $output = $pdf->output();
        $filename = 'order-' . str_pad($order->id, 3, '0', STR_PAD_LEFT) . '-' . now()->format('Ymd_His') . '.pdf';
        $folder = 'orders';

        Storage::disk('public')->put($folder . '/' . $filename, $output);
        $url = Storage::disk('public')->url($folder . '/' . $filename);

        return redirect()->route('orders.index')
            ->with('success', 'PDF order berhasil disimpan.')
            ->with('pdf_url', $url);
    }
}