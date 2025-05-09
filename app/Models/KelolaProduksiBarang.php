<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KelolaProduksiBarang extends Model
{
    use HasFactory;

    protected $table = 'kelola_produksi_barangs';

    protected $fillable = [
        'petani_id',  // Menggunakan petani_id untuk foreign key
        'tanggal_produksi',
        'nama_barang',
        'jumlah_produksi',
        'satuan',
        'catatan',
    ];

    public function petani()
    {
        return $this->belongsTo(Karyawan::class, 'petani_id');
    }

}

