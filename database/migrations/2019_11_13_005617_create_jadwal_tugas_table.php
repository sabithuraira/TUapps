<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJadwalTugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_tugas', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('nama_kegiatan');
            $table->text('penjelasan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('pegawai_id');
            $table->string('nomor');
            $table->integer('unit_kerja');
            $table->integer('unit_kerja4');
            $table->integer('is_kepala');
            $table->string('pejabat_ttd');
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
        Schema::dropIfExists('jadwal_tugas');
    }
}
