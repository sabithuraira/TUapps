<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPenilaianPimpinanToCkpLogBulananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ckp_log_bulanan', function (Blueprint $table) {
            $table->float('penilaian_pimpinan',8,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ckp_log_bulanan', function (Blueprint $table) {
            //
        });
    }
}
