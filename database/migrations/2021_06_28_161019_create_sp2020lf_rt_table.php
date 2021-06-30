<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSp2020lfRtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp2020lf_rt', function (Blueprint $table) {
            $table->increments('id');
            
            $table->char('kd_prov',2);
            $table->char('kd_kab',2);
            $table->char('kd_kec',3);
            $table->char('kd_desa',3);
            $table->char('idbs',14);

            $table->integer('nurts');
            $table->integer('status_rt');
            $table->string('nama_krt');
            $table->integer('pendidikan_krt');

            $table->integer('jumlah_laki');
            $table->integer('jumlah_perempuan');
            $table->integer('jumlah_perempuan_1549');
            $table->integer('jumlah_mati');

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
        Schema::dropIfExists('sp2020lf_rt');
    }
}
