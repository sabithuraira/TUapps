<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePokMataAnggaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pok_mata_anggaran', function (Blueprint $table) {
            $table->increments('id');
            
            $table->char("kode_program",9);
            $table->char("kode_aktivitas", 4);
            $table->char("kode_kro",8);
            $table->char("kode_ro", 12);
            $table->char("kode_komponen",2);
            $table->char("kode_sub_komponen",1);
            $table->char("kode",1);
            $table->string("label",6);
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
        Schema::dropIfExists('pok_mata_anggaran');
    }
}
