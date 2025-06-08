<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisKegiatan;

class JenisKegiatanSeeder extends Seeder
{
    public function run()
    {
        $jenisKegiatan = [
            [
                'nama' => 'Kuliah',
                'deskripsi' => 'Kegiatan perkuliahan akademik'
            ],
            [
                'nama' => 'Pengajian',
                'deskripsi' => 'Kegiatan pengajian pesantren'
            ],
            [
                'nama' => 'Sholat Jamaah',
                'deskripsi' => 'Kegiatan sholat berjamaah'
            ]
        ];

        foreach ($jenisKegiatan as $jk) {
            JenisKegiatan::create($jk);
        }
    }
}
