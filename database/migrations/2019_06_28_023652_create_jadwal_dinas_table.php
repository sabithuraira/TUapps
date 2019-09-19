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
            $table->string('tanggal_mulai');
            $table->string('tanggal_berakhir');
            $table->string('penjelasan');
            $table->string('print_no')->nullable();
            $table->string('print_unit_kerja')->nullable();
            $table->string('print_ttd')->nullable();
            $table->integer('print_is_kepala')->nullable();
            $table->string('print_ttd_nip')->nullable();
            $table->integer('is_lpd')->nullable();
            $table->integer('is_kelengkapan')->nullable();
            $table->integer('is_lunas_bayar')->nullable();
            $table->string('created_by');
            $table->string('updated_by');

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
