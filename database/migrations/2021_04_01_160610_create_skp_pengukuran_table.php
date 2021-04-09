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
            
            $table->integer('kode_point_kredit')->nullable();
            
            $table->string('target_satuan');
            $table->float('target_kuantitas');
            $table->float('target_kualitas');
            $table->integer('target_waktu')->nullable();
            $table->string('target_satuan_waktu')->nullable();
            $table->decimal('target_biaya',12,2)->nullable();
            $table->float('target_angka_kredit')->nullable();
            
            $table->string('realisasi_satuan');
            $table->float('realisasi_kuantitas');
            $table->float('realisasi_kualitas');
            $table->integer('realisasi_waktu')->nullable();
            $table->string('realisasi_satuan_waktu')->nullable();
            $table->decimal('realisasi_biaya',12,2)->nullable();
            $table->float('realisasi_angka_kredit')->nullable();

            $table->float('penghitungan')->nullable();
            $table->float('nilai_capaian_skp')->nullable();
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
