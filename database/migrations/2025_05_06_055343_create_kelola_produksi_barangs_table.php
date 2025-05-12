<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('kelola_stock_barangs', function (Blueprint $table) {
            $table->id();  // ID untuk produksi barang
            $table->unsignedBigInteger('karyawan_id');
            $table->foreign('karyawan_id')
                ->references('karyawan_id')
                ->on('tb_karyawans')
                ->onDelete('cascade');
            
            $table->date('tanggal_stock');  // Tanggal produksi barang
            $table->string('nama_barang');  // Nama barang
            $table->integer('jumlah_stock');
            $table->integer('sisa_stock');  // Jumlah barang yang diproduksi // Satuan produksi, misalnya pcs, liter, kg, dll.
            $table->text('catatan')->nullable();  // Catatan tambahan untuk produksi barang
            $table->timestamps();  // Timestamps untuk created_at dan updated_at
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelola_stock_barangs');
    }
};
