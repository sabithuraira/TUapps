<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPemberiTugasToCkpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ckps', function (Blueprint $table) {
            $table->string("pemberi_tugas_id")->nullable();
            $table->string("pemberi_tugas_nama")->nullable();
            $table->string("pemberi_tugas_jabatan")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ckps', function (Blueprint $table) {
            //
        });
    }
}
