<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasantri;

class MahasantriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 1,
                'nim' => '2021001',
                'nama_lengkap' => 'Ahmad Fauzi',
                'alamat' => 'Jl. Merdeka No. 1',
                'tanggal_lahir' => '2001-01-15',
                'no_hp' => '081234567890',
                'nama_wali' => 'Bapak Fauzi',
                'kontak_wali' => '081111111111',
            ],
            [
                'user_id' => 1,
                'nim' => '2021002',
                'nama_lengkap' => 'Siti Aminah',
                'alamat' => 'Jl. Sudirman No. 2',
                'tanggal_lahir' => '2002-02-20',
                'no_hp' => '081298765432',
                'nama_wali' => 'Bapak Amin',
                'kontak_wali' => '081222222222',
            ],
            [
                'user_id' => 1,
                'nim' => '2021003',
                'nama_lengkap' => 'Budi Santoso',
                'alamat' => 'Jl. Diponegoro No. 3',
                'tanggal_lahir' => '2001-05-10',
                'no_hp' => '081212345678',
                'nama_wali' => 'Ibu Santi',
                'kontak_wali' => '081333333333',
            ],
        ];

        foreach ($data as $m) {
            Mahasantri::updateOrCreate(['nim' => $m['nim']], $m);
        }
    }
}
