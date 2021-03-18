<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToBps1674PerusahaanSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bps1674_perusahaan_survey', function (Blueprint $table) {
            $table->string('pemberi_jawaban')->nullable();
            $table->string('kegiatan_utama')->nullable();
            $table->string('produk_utama')->nullable();
            $table->integer('status_usaha')->nullable();
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
