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
        Schema::create('petani', function (Blueprint $table) {
            $table->id();  // ID petani
            $table->string('nama');  // Nama petani
            $table->string('jenis_kelamin');  // Jenis kelamin
            $table->string('alamat_karyawan');  // Alamat petani
            $table->string('no_telepon');  // Nomor telepon petani, ubah ke string jika panjangnya variatif
            $table->timestamps();  // Timestamps untuk created_at dan updated_at
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('petani');
    }
};
