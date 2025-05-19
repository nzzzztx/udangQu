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
        Schema::create('tb_barang', function (Blueprint $table) {
            $table->id('barang_id');
            $table->string('nama_barang');
            $table->string('tanggal_stock'); // Tanggal stock
            $table->string('jumlah_stock'); // Jumlah stock
            $table->string('satuan');
            $table->string('harga_barang'); // Nama barang
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_barang');

    }
};
