<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreatePemesananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('pemesanan')) {
            Schema::create('pemesanan', function (Blueprint $table) {
                $table->id();
                $table->string('kode')->default(Str::uuid());
                $table->string('kursi')->nullable();
                $table->timestamp('waktu');
                $table->integer('total')->default(0);
                $table->enum('status', ['Belum Bayar', 'Sudah Bayar'])->default('Belum Bayar');
                $table->unsignedBigInteger('rute_id');
                $table->unsignedBigInteger('penumpang_id');
                $table->unsignedBigInteger('petugas_id')->nullable();
                $table->unsignedBigInteger('transportasi_id');
                $table->unsignedBigInteger('transportasi_id')->default(0);
                $table->timestamps();

                $table->foreign('rute_id')->references('id')->on('rute');
                $table->foreign('penumpang_id')->references('id')->on('penumpang');
                $table->foreign('petugas_id')->references('id')->on('petugas');
                $table->foreign('transportasi_id')->references('id')->on('transportasi');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemesanan');
    }
}
