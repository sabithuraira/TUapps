<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratKmRincianMemorandumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_km_rincian_memorandum', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('induk_id');
            $table->text('dari');
            $table->text('isi');
            $table->text('tembusan');
            $table->string('kepada');

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
        Schema::dropIfExists('surat_km_rincian_memorandum');
    }
}
