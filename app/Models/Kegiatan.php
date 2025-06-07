<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $fillable = [
        'nama_kegiatan',
        'jenis_kegiatan',
        'waktu_mulai',
        'waktu_selesai',
    ];

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
    //
}
