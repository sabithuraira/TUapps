<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePokRincianAnggaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pok_rincian_anggaran', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer("id_mata_anggaran");
            $table->string("label");
            $table->integer("tahun");
            $table->float("volume",8,2)->nullable();
            $table->string("satuan")->nullable();
            $table->float("harga_satuan",8,2)->nullable();
            $table->float("harga_jumlah",14,2)->nullable();
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
        Schema::dropIfExists('pok_rincian_anggaran');
    }
}
