<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mahasantri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nim')->unique();
            $table->string('nama_lengkap');
            $table->string('alamat');
            $table->date('tanggal_lahir');
            $table->string('no_hp');
            $table->string('nama_wali');
            $table->string('kontak_wali');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasantri');
    }
};