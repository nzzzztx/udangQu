<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class transaksistock extends Model
{
    use HasFactory;

    protected $table = 'tb_transaksi_stock';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $guarded = [];


    /**
     * Relasi ke model
     */
    public function tb_barang()
    {
        return $this->belongsTo(barangstock::class, 'barang_id');
    }

    public function tb_karyawan()
    {
        return $this->belongsTo(Tb_karyawan::class, 'karyawan_id');
    }

}
