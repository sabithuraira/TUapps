<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditRincianToSuratTugasRincianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surat_tugas_rincian', function (Blueprint $table) {
            $table->dropColumn('status_kumpul_lpd');
            $table->dropColumn('status_kumpul_kelengkapan');
            $table->dropColumn('status_pembayaran');
            $table->string('pejabat_ttd_jabatan');
            $table->string('ppk_nip');
            $table->string('ppk_nama');
            $table->string('bendahara_nip');
            $table->string('bendahara_nama');
            $table->string('ppspm_nip');
            $table->string('ppspm_nama');
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
