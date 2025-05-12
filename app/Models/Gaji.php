<?php

namespace App\Models;

use App\Models\Karyawan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gaji extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tb_karyawan()
    {
        return $this->belongsTo(Tb_karyawan::class, 'karyawan_id');
        // return $this->belongsTo(Karyawan::class);
    }

}
