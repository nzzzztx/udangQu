<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi massal.
     */
    protected $guarded = [];

    /**
     * Relasi ke model Karyawan.
     */
    public function tb_karyawan()
    {
        return $this->belongsTo(Tb_karyawan::class, 'karyawan_id');
        // return $this->belongsTo(Karyawan::class);
    }
}
