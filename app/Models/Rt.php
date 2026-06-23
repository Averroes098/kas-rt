<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rt extends Model
{
    protected $fillable = [
        'nama_rt'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function inventaris()
    {
        return $this->hasMany(Inventaris::class);
    }
}