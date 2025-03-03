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
        Schema::create('t_penjualan', function (Blueprint $table) {
            $table->id('penjualan_id'); // Membuat kolom barang_id sebagai primary key
            $table->unsignedBigInteger('user_id')->index(); // Kolom kategori_id
            $table->string('penjualan_kode', 50)->unique(); // Kolom barang_kode yang unik
            $table->dateTime('penjualan_tanggal');
            $table->integer('harga_jual'); // Kolom harga jual
            $table->timestamps(); // Kolom created_at dan updated_at

            // Menambahkan foreign key constraint
            $table->foreign('user_id')->references('user_id')->on('m_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_penjualan');
    }
};
