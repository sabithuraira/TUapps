<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBps1674PerusahaanSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bps1674_perusahaan_survey', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('perusahaan_id');
            $table->string('nama_survey');
            $table->integer('year');
            $table->integer('month');
            $table->string('nama_petugas');
            $table->string('hp_petugas');

            $table->decimal('pendapatan', 12, 2)->nullable();
            $table->decimal('pengeluaran', 12, 2)->nullable();
            $table->integer('jumlah_pegawai')->nullable();

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
        Schema::dropIfExists('bps1674_perusahaan_survey');
    }
}
