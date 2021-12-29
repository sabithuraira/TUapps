<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePokTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pok_transaksi', function (Blueprint $table) {
            $table->increments('id');

            $table->integer("id_rincian");

            $table->float("total_estimasi",15,2)->nullable();
            $table->datetime("waktu_estimasi")->nullable();
            $table->integer("estimasi_by")->nullable();
            $table->float("total_realisasi",15,2)->nullable();
            $table->datetime("waktu_realisasi")->nullable();
            $table->integer("realisasi_by")->nullable();

            $table->integer("created_by");
            $table->integer("updated_by");

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
        Schema::dropIfExists('pok_transaksi');
    }
}
