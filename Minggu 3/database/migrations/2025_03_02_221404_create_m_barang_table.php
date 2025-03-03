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
        Schema::create('m_barang', function (Blueprint $table) {
            $table->id('barang_id'); // Membuat kolom barang_id sebagai primary key
            $table->unsignedBigInteger('kategori_id')->index(); // Kolom kategori_id
            $table->string('barang_kode', 10)->unique(); // Kolom barang_kode yang unik
            $table->string('barang_nama', 100); // Kolom barang_nama
            $table->integer('harga_beli'); // Kolom harga beli
            $table->integer('harga_jual'); // Kolom harga jual            
            $table->timestamps(); // Kolom created_at dan updated_at

            // Menambahkan foreign key constraint
            $table->foreign('kategori_id')->references('id')->on('m_kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_barang');
    }
};
