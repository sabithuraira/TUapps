<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePokRoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pok_ro', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer("id_program");
            $table->integer("id_aktivitas");
            $table->integer("id_kro");
            $table->char("kode", 12);
            $table->string("label");
            $table->integer("tahun");
            $table->char("unit_kerja", 4);
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
        Schema::dropIfExists('pok_ro');
    }
}
