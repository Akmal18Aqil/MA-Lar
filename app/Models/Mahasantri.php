<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasantri extends Model
{
    protected $table = 'mahasantri';

    protected $fillable = [
        'user_id',
        'nim',
        'nama_lengkap',
        'alamat',
        'tanggal_lahir',
        'no_hp',
        'nama_wali',
        'kontak_wali',
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
