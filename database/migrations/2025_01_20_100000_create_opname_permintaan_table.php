<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpnamePermintaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opname_permintaan', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_barang');
            $table->date('tanggal_permintaan');
            $table->date('tanggal_penyerahan')->nullable();
            $table->integer('jumlah_diminta');
            $table->integer('jumlah_disetujui')->nullable();
            $table->integer('unit_kerja');
            $table->integer('unit_kerja4');
            $table->tinyInteger('status_aktif')->default(1);
            $table->string('created_by');
            $table->string('updated_by');

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
        Schema::dropIfExists('opname_permintaan');
    }
}

