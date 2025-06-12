<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->boolean('is_shaf_pertama')->default(false)->after('is_late');
        });
    }

    public function down()
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropColumn('is_shaf_pertama');
        });
    }
};
