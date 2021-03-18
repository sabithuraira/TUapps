<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldBps1674PerusahaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bps1674_perusahaan', function (Blueprint $table) {
            $table->string('desa')->nullable();
            $table->string('telepon')->nullable();
            $table->integer('badan_usaha');
            $table->integer('tahun_mulai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
