<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratTugasRincianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_tugas_rincian', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('id_surtug');
            $table->string('nip');
            $table->string('nama');
            $table->string('jabatan');
            $table->string('tujuan_tugas');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('nomor_st');
            $table->string('nomor_sppd');
            $table->integer('status_kumpul_lpd');
            $table->integer('status_kumpul_kelengkapan');
            $table->integer('status_pembayaran');
            $table->string('pejabat_ttd_nip');
            $table->string('pejabat_ttd_nama');
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
        Schema::dropIfExists('surat_tugas_rincian');
    }
}
