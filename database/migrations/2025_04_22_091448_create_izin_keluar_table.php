<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIzinKeluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('izin_keluar', function (Blueprint $table) {
            $table->increments('id');

            $table->string("pegawai_nip");
            $table->char("kode_prov", 2);
            $table->char("kode_kab", 2);
            $table->date('tanggal');
            $table->time('start')->format('H:i');
            $table->time('end')->format('H:i')->nullable();
            $table->text('keterangan');
            $table->integer('total_minutes');
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
        Schema::dropIfExists('izin_keluar');
    }
}
