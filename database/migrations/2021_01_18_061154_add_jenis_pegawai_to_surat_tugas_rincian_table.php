<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJenisPegawaiToSuratTugasRincianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surat_tugas_rincian', function (Blueprint $table) {
            $table->integer('jenis_petugas')->default(1);
            $table->string('nip')->nullable()->change();
            $table->string('jabatan')->nullable()->change();
            $table->string('nomor_spd')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surat_tugas_rincian', function (Blueprint $table) {
            //
        });
    }
}
