<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratTugasKwitansiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_tugas_kwitansi', function (Blueprint $table) {
            $table->increments('id');

            $table->string('id_surtug');
            $table->string('id_surtug_pegawai');
            $table->string('rincian');
            $table->decimal('anggaran', 9, 2);
            $table->boolean('is_rill');
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
        Schema::dropIfExists('surat_tugas_kwitansi');
    }
}
