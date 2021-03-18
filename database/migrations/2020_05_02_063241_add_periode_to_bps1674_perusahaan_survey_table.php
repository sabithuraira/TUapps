<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPeriodeToBps1674PerusahaanSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bps1674_perusahaan_survey', function (Blueprint $table) {
            $table->integer('periode_pencacahan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bps1674_perusahaan_survey', function (Blueprint $table) {
            //
        });
    }
}
