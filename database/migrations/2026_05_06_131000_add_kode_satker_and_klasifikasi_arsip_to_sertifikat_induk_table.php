<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKodeSatkerAndKlasifikasiArsipToSertifikatIndukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sertifikat_induk', function (Blueprint $table) {
            $table->string('kode_satker');
            $table->string('klasifikasi_arsip');
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
            $table->dropColumn(['kode_satker', 'klasifikasi_arsip']);
        });
    }
}
