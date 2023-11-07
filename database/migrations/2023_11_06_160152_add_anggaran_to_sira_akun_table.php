<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAnggaranToSiraAkunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sira_akun', function (Blueprint $table) {
            $table->float("pagu",15,2)->nullable();
            $table->float("realisasi",15,2)->nullable();
            $table->string("kode_prov")->default('16');
            $table->string("kode_kab")->default('00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sira_akun', function (Blueprint $table) {
            //
        });
    }
}
