<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratKmRincianDisposisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_km_rincian_disposisi', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('induk_id');
            $table->string('nomor_agenda');
            $table->date('tanggal_penerimaan');
            $table->date('tanggal_penyelesaian');
            $table->string('dari');
            $table->text('isi');
            $table->string('lampiran')->nullable();
            $table->string('isi_disposisi')->nullable();
            $table->string('diteruskan_kepada')->nullable();

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
        Schema::dropIfExists('surat_km_rincian_disposisi');
    }
}
