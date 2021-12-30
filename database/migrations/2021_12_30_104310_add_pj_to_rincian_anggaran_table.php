<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPjToRincianAnggaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::table('pok_rincian_anggaran', function (Blueprint $table) {
            $table->integer("id_pj");
            $table->string("nip_pj");
            $table->string("nama_pj");
            $table->integer("jumlah_rincian_estimasi")->nullable();
            $table->float("total_estimasi",15,2)->nullable();
            $table->integer("jumlah_rincian_realisasi")->nullable();
            $table->float("total_realisasi",15,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rincian_anggaran', function (Blueprint $table) {
            //
        });
    }
}
