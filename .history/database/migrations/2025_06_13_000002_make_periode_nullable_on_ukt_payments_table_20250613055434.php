<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ukt_payments', function (Blueprint $table) {
            $table->string('periode')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('ukt_payments', function (Blueprint $table) {
            $table->string('periode')->nullable(false)->change();
        });
    }
};
