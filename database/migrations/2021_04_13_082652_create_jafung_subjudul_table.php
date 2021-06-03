<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJafungSubjudulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jafung_subjudul', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_jabatan');
            $table->string('id_judul');
            $table->string('id_subjudul');
            $table->text('subjudul');
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
        Schema::dropIfExists('jafung_subjudul');
    }
}
