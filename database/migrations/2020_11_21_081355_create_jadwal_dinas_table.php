<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJadwalDinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_dinas', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('nama_kegiatan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->text('penjelasan');
            $table->string('pegawai_id');
            $table->string('nomor_surat');
            $table->integer('unit_kerja');
            $table->integer('unit_kerja4');
            $table->integer('is_kepala');
            $table->string('pejabat_ttd');
            
            $table->integer('is_lpd');
            $table->integer('is_kelengkapan');
            $table->integer('is_lunas');

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
        Schema::dropIfExists('jadwal_dinas');
    }
}
