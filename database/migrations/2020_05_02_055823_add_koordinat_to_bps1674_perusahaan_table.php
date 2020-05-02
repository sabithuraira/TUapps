<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKoordinatToBps1674PerusahaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bps1674_perusahaan', function (Blueprint $table) {
            $table->string('long')->nullable();
            $table->string('lat')->nullable();
            $table->string('tahun_mulai')->nullable()->change();
            $table->string('deskripsi')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bps1674_perusahaan', function (Blueprint $table) {
            //
        });
    }
}
