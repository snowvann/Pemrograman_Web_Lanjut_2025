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
        Schema::create('m_level', function (Blueprint $table) {
            $table->id('level_id'); // Ini akan membuat kolom id sebagai primary key
            $table->string('level_kode', 10)->unique(); // Kolom level_kode yang unik
            $table->string('level_nama', 100); // Kolom level_nama
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_level'); // Menghapus tabel m_level jika migrasi dibatalkan
    }
};