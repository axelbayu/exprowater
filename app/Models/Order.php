<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelanggan',
        'telepon',
        'produk',
        'jumlah',
        'total_harga',
        'status',
        'tanggal_order',
        'catatan',
    ];
}
