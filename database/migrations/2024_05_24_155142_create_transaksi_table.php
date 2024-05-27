?<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penumpang_id');
            $table->unsignedBigInteger('transportasi_id');
            $table->string('nomor_kursi')->nullable();
            $table->integer('sisa_kursi');
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('penumpang_id')->references('id')->on('penumpang')->onDelete('cascade');
            $table->foreign('transportasi_id')->references('id')->on('transportasi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
