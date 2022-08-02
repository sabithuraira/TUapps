<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengadaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengadaan', function (Blueprint $table) {
            $table->increments('id');
            // skf
            $table->string('kd_kab', 5);
            $table->string('judul');
            $table->string('kode_anggaran');
            $table->bigInteger('nilai_anggaran');
            $table->dateTime('waktu_pemakaian');
            $table->string('nota_dinas_skf');
            // ppk
            $table->string('konfirmasi_ppk')->nullable();
            $table->text('spek')->nullable();
            $table->string('spek_file')->nullable();
            $table->bigInteger('perkiraan_nilai')->nullable();
            $table->string('lk_hps')->nullable();
            $table->string('hps')->nullable();
            $table->string('alokasi_anggaran')->nullable();
            $table->string('nota_dinas_ppk')->nullable();
            $table->string('kak_ppk')->nullable();
            $table->dateTime('tgl_penolakan_ppk')->nullable();
            $table->text('alasan_penolakan_ppk')->nullable();

            //pbj
            $table->string('konfirmasi_pbj')->nullable();
            $table->bigInteger('nilai_kwitansi')->nullable();
            $table->dateTime('tgl_mulai_pelaksanaan')->nullable();
            $table->dateTime('tgl_akhir_pelaksanaan')->nullable();
            $table->integer('status_pengadaan')->nullable();
            $table->string('foto')->nullable();
            $table->string('bast')->nullable();
            $table->string('kontrak')->nullable();
            $table->dateTime('tgl_penolakan_pbj')->nullable();
            $table->text('alasan_penolakan_pbj')->nullable();

            $table->integer('status_aktif')->default(1);
            $table->integer("created_by");
            $table->integer("updated_by")->nullable();
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
        Schema::dropIfExists('pengadaan');
    }
}
