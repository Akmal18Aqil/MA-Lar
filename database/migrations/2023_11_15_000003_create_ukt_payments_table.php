<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ukt_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasantri_id')->constrained('mahasantri')->onDelete('cascade');
            $table->decimal('jumlah', 12, 2);
            $table->date('tanggal_bayar');
            $table->enum('status', ['lunas', 'belum_lunas', 'tunggakan']);
            $table->string('periode');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ukt_payments');
    }
};