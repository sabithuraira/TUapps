<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTerimaC2ToSp2020lfBsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sp2020lf_bs', function (Blueprint $table) {
            $table->integer("c2_terima_kortim")->default(0);
            $table->integer("c2_terima_koseka")->default(0);
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
