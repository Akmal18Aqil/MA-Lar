<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UktPayment extends Model
{
    protected $fillable = [
        'mahasantri_id',
        'jumlah',
        'tanggal_bayar',
        'status',
        'periode',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
    ];

    public function mahasantri()
    {
        return $this->belongsTo(Mahasantri::class);
    }
    //
}
