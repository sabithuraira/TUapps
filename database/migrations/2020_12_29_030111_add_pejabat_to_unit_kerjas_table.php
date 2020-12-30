<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPejabatToUnitKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_kerjas', function (Blueprint $table) {
            $table->string('kepala_nip')->nullable();
            $table->string('kepala_nama')->nullable();
            $table->string('ppk_nip')->nullable();
            $table->string('ppk_nama')->nullable();
            $table->string('bendahara_nip')->nullable();
            $table->string('bendahara_nama')->nullable();
            $table->string('ppspm_nip')->nullable();
            $table->string('ppspm_nama')->nullable();
            $table->string('ibu_kota')->nullable();
            $table->string('alamat_kantor')->nullable();
            $table->string('kontak_kantor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_kerjas', function (Blueprint $table) {
            //
        });
    }
}
