<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatenessToAbsensiTable extends Migration
{
    public function up()
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->time('waktu_hadir')->nullable()->after('tanggal');
            $table->boolean('is_late')->default(false)->after('waktu_hadir');
        });
    }

    public function down()
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropColumn(['waktu_hadir', 'is_late']);
        });
    }
};
