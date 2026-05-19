<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\History;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // 🔹 Tampilkan semua data dengan PAGINASI
    public function index()
    {
        // Gunakan paginate() agar method hasPages() atau paginasi manual berfungsi
        $orders = Order::latest()->paginate(10); 
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'telepon'        => 'nullable|string|max:50',
            'produk'         => 'required|string|max:255',
            'jumlah'         => 'required|integer|min:1',
            'total_harga'    => 'nullable|numeric|min:15000',
            'status'         => 'required|in:pending,diproses,selesai,dibatalkan',
            'tanggal_order'  => 'required|date',
            'catatan'        => 'nullable|string|max:1000',
        ]);

        Order::create($data);

        return redirect()->route('orders.index')
            ->with('success', 'Order berhasil dibuat.');
    }

    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'telepon'        => 'nullable|string|max:50',
            'produk'         => 'required|string|max:255',
            'jumlah'         => 'required|integer|min:1',
            'total_harga'    => 'nullable|numeric|min:15000',
            'status'         => 'required|in:pending,diproses,selesai,dibatalkan',
            'tanggal_order'  => 'required|date',
            'catatan'        => 'nullable|string|max:1000',
        ]);

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

    public function selesai($id)
    {
        $order = Order::findOrFail($id);

        History::create([
            'nama_pelanggan' => $order->nama_pelanggan,
            'telepon'        => $order->telepon,
            'produk'         => $order->produk,
            'jumlah'         => $order->jumlah,
            'total_harga'    => $order->total_harga,
            'status'         => $order->status,
            'tanggal_order'  => $order->tanggal_order,
            'catatan'        => $order->catatan,
        ]);

        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Pesanan selesai & masuk history');
    }
}