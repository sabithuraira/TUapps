<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJafungKegiatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jafung_kegiatan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_jabatan');
            $table->string('id_judul');
            $table->string('id_subjudul');
            $table->string('id_kegiatan');
            $table->text('kegiatan');
            $table->string('satuan_hasil')->nullable();
            $table->string('angka_kredit')->nullable();
            $table->string('batasan_penilaian')->nullable();
            $table->string('pelaksana')->nullable();
            $table->string('bukti_fisik')->nullable();
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
        Schema::dropIfExists('jafung_kegiatan');
    }
}
