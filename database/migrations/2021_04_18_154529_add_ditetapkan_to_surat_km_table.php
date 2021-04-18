<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDitetapkanToSuratKmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surat_km', function (Blueprint $table) {
            $table->string('ditetapkan_di')->nullable();
            $table->date('ditetapkan_tanggal')->nullable();
            $table->string('ditetapkan_oleh')->nullable();
            $table->string('ditetapkan_nama')->nullable();
            $table->string('ditetapkan_nip')->nullable();
            $table->string('kode_unit_kerja')->nullable();
            $table->string('klasifikasi_arsip')->nullable();
            $table->integer('tingkat_keamanan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surat_km', function (Blueprint $table) {
            //
        });
    }
}
