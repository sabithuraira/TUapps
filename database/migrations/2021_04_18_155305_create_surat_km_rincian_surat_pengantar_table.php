<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratKmRincianSuratPengantarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_km_rincian_surat_pengantar', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('induk_id');
            $table->text('isi');
            $table->string('kepada');
            $table->string('kepada_di');
            $table->string('diterima_tanggal');
            $table->string('diterima_jabatan');
            $table->string('diterima_nama');
            $table->string('diterima_nip')->nullable();
            $table->string('diterima_no_hp')->nullable();
            $table->string('dibuat_di')->nullable();
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
        Schema::dropIfExists('surat_km_rincian_surat_pengantar');
    }
}
