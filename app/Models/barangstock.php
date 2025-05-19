<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class barangstock extends Model
{
    protected $table = 'tb_barang';

    protected $fillable = [
        'nama_barang', 
        'tanggal_stock',
        'jumlah_stock',
        'satuan',
        'harga_barang',
    ];

    protected $primaryKey = 'barang_id'; // Primary key
}
