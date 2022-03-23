<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNksToSp2020lfBs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sp2020lf_bs', function (Blueprint $table) {
            $table->string("nks")->nullable();
            $table->integer("jenis_sampel")->nullable();
            $table->integer("jumlah_kk_lama")->nullable();
            $table->string("kode_sls")->nullable();
            $table->string("nama_sls")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sp2020lf_bs', function (Blueprint $table) {
            //
        });
    }
}
