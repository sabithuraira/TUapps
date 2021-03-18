<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCutiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuti', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user');
            $table->string('nip');
            $table->string('nama');
            $table->string('jabatan');
            $table->string('masa_kerja');
            $table->string('unit_kerja');
            $table->string('jenis_cuti');
            $table->text('alasan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('lama_cuti');

            $table->json('catatan_cuti_pegawai');
            $table->text('alamat_cuti');
            $table->string('no_telp');
            $table->integer('status_atasan');
            $table->string('nama_atasan');
            $table->string('nip_atasan');
            $table->timestamps('tanggal_status_atasan')->nullable();
            $table->integer('status_pejabat');
            $table->string('nama_perjabat');
            $table->string('nip_pejabat');
            $table->timestamps('tanggal_status_pejabat')->nullable();
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
        Schema::dropIfExists('cuti');
    }
}
