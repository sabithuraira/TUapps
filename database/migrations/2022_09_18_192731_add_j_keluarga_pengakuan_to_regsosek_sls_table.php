<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJKeluargaPengakuanToRegsosekSlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('regsosek_sls', function (Blueprint $table) {
            $table->integer("j_keluarga_pengakuan")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('regsosek_sls', function (Blueprint $table) {
            //
        });
    }
}
