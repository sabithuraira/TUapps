<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DelArtKelToSp2020lfRt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sp2020lf_rt', function (Blueprint $table) {
            $table->dropColumn(['pendidikan_krt', 'jumlah_perempuan', 'jumlah_laki']);
            $table->integer("jumlah_art");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sp2020lf_rt', function (Blueprint $table) {
            //
        });
    }
}
