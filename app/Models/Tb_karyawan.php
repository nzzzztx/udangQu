<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_karyawan extends Model
{
    use HasFactory;

    protected $table = 'tb_karyawans';
    protected $primaryKey = 'karyawan_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $guarded = [];
}
