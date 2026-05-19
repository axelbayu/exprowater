<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Root → login
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest only
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Auth only
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        $totalOrders    = \App\Models\Order::count();
        $pendingOrders  = \App\Models\Order::where('status', 'pending')->count();
        $diprosesOrders = \App\Models\Order::where('status', 'diproses')->count();
        $selesaiOrders  = \App\Models\Order::where('status', 'selesai')->count();
        $batalOrders    = \App\Models\Order::where('status', 'dibatalkan')->count();
        $doneOrders     = \App\Models\Order::where('status', 'selesai')
                            ->whereMonth('tanggal_order', now()->month)
                            ->count();
        $totalValue   = \App\Models\Order::sum('total_harga');
        $recentOrders = \App\Models\Order::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalOrders', 'pendingOrders', 'diprosesOrders',
            'selesaiOrders', 'batalOrders', 'doneOrders',
            'totalValue', 'recentOrders'
        ));
    })->name('dashboard');

    Route::resource('orders', OrderController::class)->except(['show']);
});