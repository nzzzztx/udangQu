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
        Schema::create('tb_karyawans', function (Blueprint $table) {
            $table->id('karyawan_id');
            $table->string('nama');  // Nama petani
            $table->string('jenis_kelamin');  // Jenis kelamin
            $table->string('alamat_karyawan');  // Alamat petani
            $table->string('no_telepon');
            $table->string('qr_code')->nullable();  // QR Code
            $table->boolean('active_st');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_karyawans');
    }
};