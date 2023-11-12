<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiraAkunRealisasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sira_akun_realisasi', function (Blueprint $table) {
            $table->increments('id');

            $table->string("kode_mak");
            $table->string("kode_akun");
            $table->integer("kode_fungsi");
            $table->string("keterangan");
            $table->float("realisasi",15,2)->nullable();
            $table->integer("created_by");
            $table->integer("updated_by");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sira_akun_realisasi');
    }
}
