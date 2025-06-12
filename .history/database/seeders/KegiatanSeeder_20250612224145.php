<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KegiatanSeeder extends Seeder
{
    public function run()
    {
        DB::table('kegiatan')->insert([
            [
                'nama_kegiatan' => 'Kuliah Pagi',
                'jenis' => 'kuliah',
                'waktu_mulai' => '07:00:00',
                'waktu_selesai' => '09:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kegiatan' => 'Kuliah Sore',
                'jenis' => 'kuliah',
                'waktu_mulai' => '16:00:00',
                'waktu_selesai' => '18:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kegiatan' => 'Kuliah Malam',
                'jenis' => 'kuliah',
                'waktu_mulai' => '19:00:00',
                'waktu_selesai' => '21:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kegiatan' => 'Pengajian Subuh',
                'jenis' => 'pengajian',
                'waktu_mulai' => '05:00:00',
                'waktu_selesai' => '06:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kegiatan' => 'Pengajian Pagi',
                'jenis' => 'pengajian',
                'waktu_mulai' => '08:00:00',
                'waktu_selesai' => '09:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kegiatan' => 'Sholat Subuh',
                'jenis' => 'sholat_jamaah',
                'waktu_mulai' => '04:30:00',
                'waktu_selesai' => '05:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kegiatan' => 'Sholat Dzuhur',
                'jenis' => 'sholat_jamaah',
                'waktu_mulai' => '12:00:00',
                'waktu_selesai' => '12:30:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kegiatan' => 'Sholat Ashar',
                'jenis' => 'sholat_jamaah',
                'waktu_mulai' => '15:30:00',
                'waktu_selesai' => '16:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kegiatan' => 'Sholat Maghrib',
                'jenis' => 'sholat_jamaah',
                'waktu_mulai' => '18:15:00',
                'waktu_selesai' => '18:45:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama_kegiatan' => 'Sholat Isya',
                'jenis' => 'sholat_jamaah',
                'waktu_mulai' => '19:30:00',
                'waktu_selesai' => '20:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
