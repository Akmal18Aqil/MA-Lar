<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiburKegiatan extends Model
{
    protected $table = 'libur_kegiatan';
    protected $fillable = [
        'tanggal',
        'kegiatan_id',
        'keterangan',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }
}
