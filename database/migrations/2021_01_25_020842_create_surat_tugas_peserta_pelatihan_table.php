<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratTugasPesertaPelatihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_tugas_peserta_pelatihan', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_surtug');
            $table->string('nip');
            $table->string('nama');
            $table->string('gol');
            $table->string('jabatan');
            $table->string('jabatan_pelatihan');
            $table->string('asal_daerah');
            $table->integer('unit_kerja');
            $table->integer('jenis_peserta');
            $table->integer('tingkat_biaya');
            $table->integer('kendaraan');
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
        Schema::dropIfExists('surat_tugas_peserta_pelatihan');
    }
}
