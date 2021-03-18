<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifToCkpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ckps', function (Blueprint $table) {
            $table->integer('kecepatan')->nullable();
            $table->integer('ketepatan')->nullable();
            $table->integer('ketuntasan')->nullable();
            $table->integer('penilaian_pimpinan')->nullable();
            $table->integer('iki')->nullable();
            $table->string('catatan_koreksi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ckps', function (Blueprint $table) {
            //
        });
    }
}
