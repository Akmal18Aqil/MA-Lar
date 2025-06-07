<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasantri extends Model
{
    protected $fillable = [
        'user_id',
        'nim',
        'full_name',
        'address',
        'date_of_birth',
        'phone_number',
        'guardian_name',
        'guardian_contact',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function uktPayments()
    {
        return $this->hasMany(UktPayment::class);
    }

    public function hukuman()
    {
        return $this->hasMany(Hukuman::class);
    }
    //
}
