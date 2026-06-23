<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'rt_id',
        'tanggal',
        'jenis',
        'keterangan',
        'nominal'
    ];

    public function rt()
    {
        return $this->belongsTo(Rt::class);
    }
}