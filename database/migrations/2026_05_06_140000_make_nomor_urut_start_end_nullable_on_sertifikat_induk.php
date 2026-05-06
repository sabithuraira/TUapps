<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeNomorUrutStartEndNullableOnSertifikatInduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sertifikat_induk', function (Blueprint $table) {
            $table->unsignedInteger('nomor_urut_start')->nullable()->change();
            $table->unsignedInteger('nomor_urut_end')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sertifikat_induk', function (Blueprint $table) {
            $table->unsignedInteger('nomor_urut_start')->nullable(false)->change();
            $table->unsignedInteger('nomor_urut_end')->nullable(false)->change();
        });
    }
}
