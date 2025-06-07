<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UktPayment extends Model
{
    protected $fillable = [
        'mahasantri_id',
        'amount',
        'payment_date',
        'status',
        'period',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function mahasantri()
    {
        return $this->belongsTo(Mahasantri::class);
    }
    //
}
