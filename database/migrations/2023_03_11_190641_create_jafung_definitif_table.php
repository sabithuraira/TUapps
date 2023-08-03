<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJafungDefinitifTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jafung_definitif', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_wilayah', 5);
            $table->text('nama_jabatan');
            $table->integer('abk');
            $table->integer('existing');
            $table->integer('penugasan');
            $table->integer("created_by")->nullable();
            $table->integer("updated_by")->nullable();
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
        Schema::dropIfExists('jafung_definitif');
    }
}
