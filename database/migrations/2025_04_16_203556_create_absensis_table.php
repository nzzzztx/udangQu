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
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel 'petani' sebagai karyawan
            $table->foreignId('karyawan_id')
                  ->constrained('petani')
                  ->onDelete('cascade');

            // Tanggal dan jam absensi
            $table->date('tanggal_absensi');
            $table->time('jam_masuk');

            // Keterangan absensi opsional (misalnya hadir, izin, sakit)
            $table->string('keterangan_absensi')->nullable();

            // Timestamps (created_at dan updated_at)
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};