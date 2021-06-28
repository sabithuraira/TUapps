<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSp2020lfBsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp2020lf_bs', function (Blueprint $table) {
            $table->increments('id');
            $table->char('kd_prov',2);
            $table->char('kd_kab',2);
            $table->char('kd_kec',3);
            $table->char('kd_desa',3);
            $table->char('idbs',14);

            $table->integer('jumlah_ruta')->nullable();
            $table->integer('jumlah_laki')->nullable();
            $table->integer('jumlah_perempuan')->nullable();
            $table->integer('jumlah_ruta_ada_mati')->nullable();

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
        Schema::dropIfExists('sp2020lf_bs');
    }
}
