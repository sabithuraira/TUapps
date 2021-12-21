<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCutiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('cuti', function (Blueprint $table) {
            $table->integer('lama_cuti_hari_kerja');
            $table->integer('lama_cuti_hari_libur');
            $table->integer('cuti_disetujui_pejabat');
            $table->text('keterangan_pejabat')->nullable();
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
