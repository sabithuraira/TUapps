<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArsipKlasifikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arsip_klasifikasi', function (Blueprint $table) {
            $table->increments('id');

            $table->char("kode", 2);
            $table->char("kode_2", 3)->nullable();
            $table->char("kode_3", 3)->nullable();
            $table->char("kode_4", 3)->nullable();
            $table->string("kode_gabung");
            $table->text("judul");

            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('arsip_klasifikasi');
    }
}
