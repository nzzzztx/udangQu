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
        Schema::create('kelola_produksi_barangs', function (Blueprint $table) {
            $table->id();  // ID untuk produksi barang
            // Menggunakan petani_id sebagai foreign key
            $table->foreignId('petani_id')->constrained('petani')->onDelete('cascade');
            $table->date('tanggal_produksi');  // Tanggal produksi barang
            $table->string('nama_barang');  // Nama barang
            $table->integer('jumlah_produksi');  // Jumlah barang yang diproduksi
            $table->string('satuan')->default('pcs');  // Satuan produksi, misalnya pcs, liter, kg, dll.
            $table->text('catatan')->nullable();  // Catatan tambahan untuk produksi barang
            $table->timestamps();  // Timestamps untuk created_at dan updated_at
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelola_produksi_barangs');
    }
};
