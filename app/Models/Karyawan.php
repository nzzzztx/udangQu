<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory;

    // Gunakan tabel 'petani' meskipun model bernama 'Karyawan'
    protected $table = 'petani';

    // Semua field boleh diisi (mass assignment)
    protected $guarded = [];

    /**
     * Relasi: Karyawan (petani) memiliki banyak data produksi
     */
        public function produksi()
    {
        return $this->hasMany(KelolaProduksiBarang::class, 'petani_id');
    }

}
