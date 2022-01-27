<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRevisiTujuanToPokRincianAnggaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pok_rincian_anggaran', function (Blueprint $table) {
            $table->integer("revisi_tujuan_id")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pok_rincian_anggaran', function (Blueprint $table) {
            //
        });
    }
}
