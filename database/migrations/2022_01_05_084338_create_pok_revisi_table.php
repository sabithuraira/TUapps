<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePokRevisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pok_revisi', function (Blueprint $table) {
            $table->increments('id');

            $table->text('judul');
            $table->text('keterangan');

            $table->string('kak')->nullable();
            $table->string('nota_dinas')->nullable();
            $table->string('matrik_anggaran')->nullable();
            $table->integer("status_revisi");
            $table->integer("approved_ppk_by")->nullable();
            $table->integer("execute_binagram_by")->nullable();

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
        Schema::dropIfExists('pok_revisi');
    }
}
