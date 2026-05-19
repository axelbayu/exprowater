<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// ── Public routes ──────────────────────────────────────────────
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// ── Root redirect ───────────────────────────────────────────────
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    return redirect()->route('orders.index');
});

// ── Protected routes (require login) ───────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $totalOrders  = \App\Models\Order::count();
        $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
        $doneOrders   = \App\Models\Order::where('status', 'selesai')
                            ->whereMonth('tanggal_order', now()->month)
                            ->count();
        $totalValue   = \App\Models\Order::sum('total_harga');

        return view('welcome', compact('totalOrders', 'pendingOrders', 'doneOrders', 'totalValue'));
    })->name('dashboard');

    Route::resource('orders', OrderController::class)->except(['show']);
});