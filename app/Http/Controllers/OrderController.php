<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Daftar produk beserta harga satuan (Rp).
     * Tambah produk baru cukup di sini — otomatis muncul di form.
     */
    private array $produkList = [
        'Expro Water' => 10000,
    ];

    /**
     * Tampilkan semua order dengan filter & paginasi.
     */
    public function index(Request $request)
    {
        $query = Order::latest();

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

        $orders = $query->paginate(10)->withQueryString();

        return view('orders.index', compact('orders'));
    }

    /**
     * Form tambah order.
     */
    public function create()
    {
        $produkList = $this->produkList;
        return view('orders.create', compact('produkList'));
    }

    /**
     * Simpan order baru.
     * Total harga dihitung ulang di server agar tidak bisa dimanipulasi.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'telepon'        => 'nullable|string|max:50',
            'produk'         => 'required|string|in:' . implode(',', array_keys($this->produkList)),
            'jumlah'         => 'required|integer|min:1',
            'status'         => 'required|in:pending,diproses,selesai,dibatalkan',
            'tanggal_order'  => 'required|date',
            'catatan'        => 'nullable|string|max:1000',
        ]);

        // Hitung total harga di server (tidak percaya input dari client)
        $data['total_harga'] = $this->produkList[$data['produk']] * $data['jumlah'];

        Order::create($data);

        return redirect()->route('orders.index')
            ->with('success', 'Order berhasil dibuat.');
    }

    /**
     * Form edit order.
     */
    public function edit(Order $order)
    {
        $produkList = $this->produkList;
        return view('orders.edit', compact('order', 'produkList'));
    }

    /**
     * Update order.
     * Total harga dihitung ulang di server.
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'telepon'        => 'nullable|string|max:50',
            'produk'         => 'required|string|in:' . implode(',', array_keys($this->produkList)),
            'jumlah'         => 'required|integer|min:1',
            'status'         => 'required|in:pending,diproses,selesai,dibatalkan',
            'tanggal_order'  => 'required|date',
            'catatan'        => 'nullable|string|max:1000',
        ]);

        // Hitung total harga di server
        $data['total_harga'] = $this->produkList[$data['produk']] * $data['jumlah'];

        $order->update($data);

        return redirect()->route('orders.index')
            ->with('success', 'Order berhasil diperbarui.');
    }

    /**
     * Hapus order.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order berhasil dihapus.');
    }
}