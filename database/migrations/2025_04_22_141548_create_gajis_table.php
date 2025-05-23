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
        Schema::create('gajis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id'); // <-- harus ada ini dulu
            $table->string('bulan');
            $table->string('tahun');
            $table->integer('total_absen')->nullable();
            $table->decimal('total_gaji', 10, 2);
            $table->string('gaji_harian')->nullable();
            $table->timestamps();

            // foreign key-nya ditaruh setelah kolom dibuat
            $table->foreign('karyawan_id')->references('karyawan_id')->on('tb_karyawans')->onDelete('cascade');
            // $table->foreign('karyawan_id')->references('id')->on('petani')->onDelete('cascade');
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gajis');
    }
};
