<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePokKroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pok_kro', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer("id_program");
            $table->integer("id_aktivitas");
            $table->char("kode",8);
            $table->string("label");
            $table->integer("tahun");
            $table->float("volume",8,2)->nullable();
            $table->string("satuan")->nullable();
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
        Schema::dropIfExists('pok_kro');
    }
}
