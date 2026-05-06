<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSertifikatIndukAndPesertaTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sertifikat_induk', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kegiatan');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::create('sertifikat_peserta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sertifikat_induk_id')->unsigned();
            $table->string('nama_peserta');
            $table->unsignedInteger('nomor_urut');
            $table->string('nomor_sertifikat');
            $table->timestamps();

            $table->foreign('sertifikat_induk_id')->references('id')->on('sertifikat_induk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sertifikat_peserta');
        Schema::dropIfExists('sertifikat_induk');
    }
}
