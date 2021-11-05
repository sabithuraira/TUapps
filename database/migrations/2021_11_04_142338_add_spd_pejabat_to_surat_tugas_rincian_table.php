<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSpdPejabatToSuratTugasRincianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surat_tugas_rincian', function (Blueprint $table) {
            $table->string('spd_ttd_nip')->nullable();
            $table->string('spd_ttd_nama')->nullable();
            $table->string('spd_ttd_jabatan')->nullable();
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
