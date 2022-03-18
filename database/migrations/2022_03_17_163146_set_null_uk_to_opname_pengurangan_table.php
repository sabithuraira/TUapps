<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetNullUkToOpnamePenguranganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('opname_pengurangan', function (Blueprint $table) {
            $table->integer("unit_kerja4")->nullable()->change();
            $table->text("keterangan_usang")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('opname_pengurangan', function (Blueprint $table) {
            //
        });
    }
}
