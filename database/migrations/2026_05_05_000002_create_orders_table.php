<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan');
            $table->string('telepon')->nullable();
            $table->string('produk');
            $table->integer('jumlah');
            $table->integer('total_harga')->nullable();
            $table->enum('status', ['pending', 'diproses', 'selesai', 'dibatalkan'])->default('pending');
            $table->date('tanggal_order');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
