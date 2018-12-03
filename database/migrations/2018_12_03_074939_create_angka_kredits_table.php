<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAngkaKreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('angka_kredits', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('jenis'); //1. statistisi 2. prakom
            $table->string('kode',15);
            $table->string('butir_kegiatan');
            $table->string('satuan_hasil');
            $table->float('angka_kredit',8,2);
            $table->string('batas_penilaian');
            $table->string('pelaksana');
            $table->string('bukti_fisik');

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
        Schema::dropIfExists('angka_kredits');
    }
}
