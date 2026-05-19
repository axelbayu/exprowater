<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// ── Root: kalau belum login → login, sudah login → dashboard ───
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// ── Auth routes (tamu saja) ─────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// ── Protected routes (wajib login) ─────────────────────────────
Route::middleware('auth')->group(function () {

    // Beranda / Dashboard
    Route::get('/dashboard', function () {
        $totalOrders    = \App\Models\Order::count();
        $pendingOrders  = \App\Models\Order::where('status', 'pending')->count();
        $diprosesOrders = \App\Models\Order::where('status', 'diproses')->count();
        $selesaiOrders  = \App\Models\Order::where('status', 'selesai')->count();
        $batalOrders    = \App\Models\Order::where('status', 'dibatalkan')->count();
        $doneOrders     = \App\Models\Order::where('status', 'selesai')
                              ->whereMonth('tanggal_order', now()->month)
                              ->count();
        $totalValue     = \App\Models\Order::sum('total_harga');
        $recentOrders   = \App\Models\Order::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalOrders', 'pendingOrders', 'diprosesOrders',
            'selesaiOrders', 'batalOrders', 'doneOrders',
            'totalValue', 'recentOrders'
        ));
    })->name('dashboard');

    // Orders CRUD
    Route::resource('orders', OrderController::class)->except(['show']);
});