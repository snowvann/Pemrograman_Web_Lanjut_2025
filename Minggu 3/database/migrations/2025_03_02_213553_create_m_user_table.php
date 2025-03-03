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
        Schema::create('m_user', function (Blueprint $table) {
            $table->id('user_id'); // Membuat kolom user_id sebagai primary key
            $table->unsignedBigInteger('level_id')->index(); // Kolom level_id
            $table->string('username', 20)->unique(); // Kolom username yang unik
            $table->string('nama', 100); // Kolom nama
            $table->string('password'); // Kolom password
            $table->timestamps(); // Kolom created_at dan updated_at

            // Menambahkan foreign key constraint
            $table->foreign('level_id')->references('level_id')->on('m_level')->onDelete('cascade');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_user'); // Menghapus tabel m_user jika migrasi dibatalkan
    }
};