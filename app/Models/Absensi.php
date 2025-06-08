<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = [
        'mahasantri_id',
        'kegiatan_id',
        'tanggal',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function mahasantri()
    {
        return $this->belongsTo(Mahasantri::class);
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }
    //
}
