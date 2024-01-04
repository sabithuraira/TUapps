<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterPekerjaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('master_pekerjaan');
        Schema::create('master_pekerjaan', function (Blueprint $table) {
            $table->increments('id');
            $table->text('subkegiatan');
            $table->text('uraian_pekerjaan');
            $table->string('tahun');
            $table->timestamps();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->unique(['subkegiatan', 'uraian_pekerjaan', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
