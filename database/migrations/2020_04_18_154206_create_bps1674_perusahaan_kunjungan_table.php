<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBps1674PerusahaanKunjunganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bps1674_perusahaan_kunjungan', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('perusahaan_survey_id');
            $table->string('nama_pengantar')->nullable();
            $table->string('nama_penerima')->nullable();
            $table->date('tanggal_diserahkan');
            $table->date('tanggal_dikembalikan')->nullable();
            $table->integer('status_dokumen');
            $table->text('keterangan')->nullable();
            
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
        Schema::dropIfExists('bps1674_perusahaan_kunjungan');
    }
}
