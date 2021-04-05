<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkpPengukuranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skp_pengukuran', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_induk');
            $table->string('user_id');
            $table->string('uraian');
            
            $table->integer('kode_point_kredit');
            
            $table->string('target_satuan');
            $table->float('target_kuantitas');
            $table->float('target_kualitas');
            $table->integer('target_waktu');
            $table->string('target_satuan_waktu');
            $table->decimal('target_biaya',12,2);
            $table->float('target_angka_kredit');
            
            $table->string('realisasi_satuan');
            $table->float('realisasi_kuantitas');
            $table->float('realisasi_kualitas');
            $table->integer('realisasi_waktu');
            $table->string('realisasi_satuan_waktu');
            $table->decimal('realisasi_biaya',12,2);
            $table->float('realisasi_angka_kredit');

            $table->float('penghitungan');
            $table->float('nilai_capaian_skp');
            $table->integer('jenis');
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
        Schema::dropIfExists('skp_pengukuran');
    }
}
