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

            $table->unsignedBigInteger('karyawan_id');
            $table->foreign('karyawan_id')
                ->references('karyawan_id')
                ->on('tb_karyawans')
                ->onDelete('cascade');

            // Tanggal dan jam absensi
            $table->date('tanggal_absensi');
            $table->time('jam_masuk');
            $table->time('jam_keluar')->nullable();

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
