<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetNullToSuratKmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surat_km', function (Blueprint $table) {
            $table->string('nomor_urut')->nullable()->change();
            $table->string('alamat')->nullable()->change();
            $table->string('tanggal')->nullable()->change();
            $table->text('perihal')->nullable()->change();
            $table->string('nomor_petunjuk')->nullable()->change();
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
