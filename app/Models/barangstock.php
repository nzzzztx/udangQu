<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class barangstock extends Model
{
    use HasFactory;
    /**
     * Kolom yang boleh diisi massal.
     */

    protected $table = 'tb_barang';

    protected $primaryKey = 'barang_id'; // Primary key

    protected $fillable = [
        'nama_barang',
        'tanggal_stock',
        'jumlah_stock',
        'satuan',
        'harga_barang',
    ];

}