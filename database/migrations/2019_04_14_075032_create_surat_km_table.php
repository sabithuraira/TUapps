<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratKmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_km', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nomor_urut');
            $table->string('alamat');
            $table->date('tanggal');
            $table->string('nomor')->nullable();
            $table->string('perihal');
            $table->string('nomor_petunjuk')->nullable();

            $table->integer('jenis_surat');
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
        Schema::dropIfExists('surat_km');
    }
}
