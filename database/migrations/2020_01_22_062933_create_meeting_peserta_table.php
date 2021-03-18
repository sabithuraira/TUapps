<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingPesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_peserta', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('meeting_id')->unsigned();
            $table->integer('pegawai_id')->unsigned();
            $table->string('nip_lama_id');
            $table->text('keterangan');
            $table->integer('kehadiran');
            $table->integer('created_by');
            $table->integer('updated_by');

            $table->timestamps();
            
            $table->foreign('meeting_id')->references('id')->on('meeting');
            $table->foreign('pegawai_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meeting_peserta');
    }
}
