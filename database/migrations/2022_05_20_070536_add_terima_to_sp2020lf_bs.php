<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTerimaToSp2020lfBs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sp2020lf_bs', function (Blueprint $table) {
            $table->integer("terima_kortim")->default(0);
            $table->integer("terima_koseka")->defautl(0);
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
