<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTargetToSiraRincian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sira_rincian', function (Blueprint $table) {
            $table->integer("target_bukti")->default(0);
            $table->integer("realisasi_bukti")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sira_rincian', function (Blueprint $table) {
            //
        });
    }
}
