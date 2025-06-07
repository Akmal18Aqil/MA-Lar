<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hukuman extends Model
{
    protected $fillable = [
        'mahasantri_id',
        'jenis_hukuman',
        'tanggal_mulai',
        'tanggal_selesai',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function mahasantri()
    {
        return $this->belongsTo(Mahasantri::class);
    }
    //
}
