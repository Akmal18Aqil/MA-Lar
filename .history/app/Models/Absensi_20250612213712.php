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
        'keterangan',
        'updated_by',
        'waktu_hadir',
        'is_late',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_hadir' => 'datetime:H:i',
        'is_late' => 'boolean',
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
