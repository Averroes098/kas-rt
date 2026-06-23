<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    protected $table = 'inventaris';

    protected $fillable = [
        'rt_id',
        'nama_barang',
        'jumlah',
        'kondisi',
        'lokasi',
        'tahun_perolehan',
        'keterangan'
    ];

    public function rt()
    {
        return $this->belongsTo(Rt::class);
    }
}