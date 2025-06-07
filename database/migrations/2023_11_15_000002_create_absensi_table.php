<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasantri_id')->constrained('mahasantri')->onDelete('cascade');
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status', ['alfa', 'izin', 'sakit']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('absensi');
    }
};