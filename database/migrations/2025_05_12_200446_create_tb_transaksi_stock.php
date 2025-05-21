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
        Schema::create('tb_transaksi_stock', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id');
            $table->foreign('barang_id')
                ->references('barang_id')
                ->on('tb_barang')
                ->onDelete('cascade');

            $table->unsignedBigInteger('karyawan_id');
            $table->foreign('karyawan_id')
                    ->references('karyawan_id')
                    ->on('tb_karyawans')
                    ->onDelete('cascade');

            $table->date('tanggal_transaksi');
            $table->integer('jumlah_barang');
            $table->integer('harga_barang');
            $table->integer('jumlah_stock');
            $table->integer('sisa_stock');
            $table->string('catatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_transaksi_stock');
    }
};