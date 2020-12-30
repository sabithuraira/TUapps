<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mata_anggaran', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_uker');
            $table->string('kode_program');
            $table->string('label_program');
            $table->string('kode_aktivitas');
            $table->string('label_aktivitas');
            $table->string('kode_kro');
            $table->string('label_kro');
            $table->string('kode_ro');
            $table->string('label_ro');
            $table->string('kode_komponen');
            $table->string('label_komponen');
            $table->string('kode_subkomponen');
            $table->string('label_subkomponen');
            $table->integer('tahun');
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
        Schema::dropIfExists('mak');
    }
}
