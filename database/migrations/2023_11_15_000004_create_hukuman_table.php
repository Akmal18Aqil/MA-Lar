<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hukuman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasantri_id')->constrained('mahasantri')->onDelete('cascade');
            $table->string('jenis_hukuman');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->text('deskripsi');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hukuman');
    }
};