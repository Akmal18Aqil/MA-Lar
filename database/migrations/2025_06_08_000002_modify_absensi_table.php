<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpa'])->change();
            $table->text('keterangan')->nullable()->after('status');
            $table->foreignId('updated_by')->nullable()->after('keterangan')->constrained('users');
        });
    }

    public function down()
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->string('status')->change();
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['keterangan', 'updated_by']);
        });
    }
};
