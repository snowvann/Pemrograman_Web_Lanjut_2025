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
        Schema::create('items', function (Blueprint $table) { 
            $table->id(); //menambahkan kolom id sebagai primary key
            $table->string('name'); //menambahkan kolom name dengan tipe data string
            $table->text('description'); //menambahkan kolom description dengan tipe data text
            $table->timestamps(); //menambahkan kolom created_at dan updated_at secara otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
