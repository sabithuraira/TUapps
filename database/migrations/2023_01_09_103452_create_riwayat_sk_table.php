<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRiwayatSkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayat_sk', function (Blueprint $table) {
            $table->increments('id');
            $table->string(10, 'niplama');
            $table->integer('flagstjab');
            $table->integer('kdstjab');
            $table->integer('urutreog');
            $table->string(6, 'kdorg');
            $table->string(3, 'flagwil');
            $table->string(3, 'kdprop');
            $table->string(3, 'kdkab');
            $table->string(4, 'kdkec');
            $table->date('tmt');
            $table->string(50,'nosk');
            $table->date('tglsk');
            $table->string('penugasan')->nullable();
            $table->string(3,'kdstkerja')->nullable();
            $table->string(50,'nmstjab');
            $table->string(100,'nmorg');
            $table->string(50,'nmwil');
            $table->integer("created_by");
            $table->integer("updated_by");
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
        Schema::dropIfExists('riwayat_sk');
    }
}
