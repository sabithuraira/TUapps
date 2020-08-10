<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSp2020SlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp2020_sls', function (Blueprint $table) {
            $table->increments('id');
            $table->char('kd_prov',2);
            $table->char('kd_kab',2);
            $table->char('kd_kec',3);
            $table->char('kd_desa',3);
            $table->char('id_sls',16);
            $table->integer('peta_penduduk');
            $table->integer('target_penduduk');
            $table->integer('realisasi_penduduk');
            $table->string('updated_phone')->nullable();
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
        Schema::dropIfExists('sp2020_sls');
    }
}
