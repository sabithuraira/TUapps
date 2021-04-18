<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratKmRincianSuratLuarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_km_rincian_surat_luar', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('induk_id');
            $table->text('isi');
            $table->string('lampiran');
            $table->string('kepada');
            $table->string('kepada_di');
            $table->string('dibuat_di');
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
        Schema::dropIfExists('surat_km_rincian_surat_luar');
    }
}
