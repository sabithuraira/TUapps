<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNomorUrutStartAndNomorUrutEndToSertifikatIndukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sertifikat_induk', function (Blueprint $table) {
            $table->unsignedInteger('nomor_urut_start');
            $table->unsignedInteger('nomor_urut_end');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sertifikat_induk', function (Blueprint $table) {
            $table->dropColumn(['nomor_urut_start', 'nomor_urut_end']);
        });
    }
}
