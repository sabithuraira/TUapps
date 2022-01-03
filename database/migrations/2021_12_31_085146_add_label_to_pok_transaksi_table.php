<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLabelToPokTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pok_transaksi', function (Blueprint $table) {
            $table->string("label");
            $table->string("ket_estimasi")->nullable();
            $table->string("ket_realisasi")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pok_transaksi', function (Blueprint $table) {
            //
        });
    }
}
