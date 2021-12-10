<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePokAktivitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pok_aktivitas', function (Blueprint $table) {
            $table->increments('id');
            
            $table->char("kode_program",9);
            $table->char("kode", 4);
            $table->string("label");
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
        Schema::dropIfExists('pok_aktivitas');
    }
}
