<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArsipJraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arsip_jra', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label_jra', 255);
            $table->text('deskripsi_jra')->nullable();
            $table->integer('aktif_tahun')->nullable();
            $table->integer('inaktif_tahun')->nullable();
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('arsip_jra');
    }
}
