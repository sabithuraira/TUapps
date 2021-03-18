<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePemegangBmnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemegang_bmn', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pemegang');
            $table->string('nip_baru');
            $table->string('nama');
            $table->string('nama_barang');
            $table->string('serial_number');
            $table->text('deskripsi_barang')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemegang_bmn');
    }
}
