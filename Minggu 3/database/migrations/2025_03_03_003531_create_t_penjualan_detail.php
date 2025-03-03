<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_penjualan_detail', function (Blueprint $table) {
            $table->id('stok_id'); // Membuat kolom barang_id sebagai primary key
            $table->unsignedBigInteger('barang_id')->index(); // Kolom kategori_id
            $table->unsignedBigInteger('penjualan_id')->index(); // Kolom kategori_id
            $table->integer('harga'); // Kolom harga jual
            $table->integer('jumlah'); // Kolom harga jual
            $table->timestamps(); // Kolom created_at dan updated_at

            // Menambahkan foreign key constraint
            $table->foreign('barang_id')->references('barang_id')->on('m_barang')->onDelete('cascade');
            $table->foreign('penjualan_id')->references('penjualan_id')->on('t_penjualan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_penjualan_detail');
    }
};
