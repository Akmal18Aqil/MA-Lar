<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mahasantri', function (Blueprint $table) {
            $table->string('semester')->nullable()->after('kontak_wali');
            $table->enum('status_lulus', ['belum', 'lulus'])->default('belum')->after('semester');
            $table->year('tahun_lulus')->nullable()->after('status_lulus');
        });
    }

    public function down()
    {
        Schema::table('mahasantri', function (Blueprint $table) {
            $table->dropColumn(['semester', 'status_lulus', 'tahun_lulus']);
        });
    }
};
