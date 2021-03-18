<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCkpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ckps', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id');
            $table->integer('month');
            $table->integer('year');
            $table->integer('type'); // target or realiassi
            $table->string('uraian');
            $table->string('satuan');
            $table->float('target_kuantitas',8,2);
            $table->float('realisasi_kuantitas',8,2);
            $table->float('kualitas',8,2);
            $table->integer('kode_butir');
            $table->float('angka_kredit', 8, 2);
            $table->string('keterangan');

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
        Schema::dropIfExists('ckps');
    }
}
