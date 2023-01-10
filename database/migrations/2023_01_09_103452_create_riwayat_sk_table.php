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
            $table->string('niplama',10);
            $table->integer('flagstjab');
            $table->integer('kdstjab');
            $table->integer('urutreog');
            $table->string('kdorg', 6);
            $table->string('flagwil', 3);
            $table->string('kdprop',3);
            $table->string('kdkab',3);
            $table->string('kdkec',4);
            $table->date('tmt');
            $table->string('nosk',50);
            $table->date('tglsk');
            $table->string('penugasan')->nullable();
            $table->string('kdstkerja',3)->nullable();
            $table->string('nmstjab',50);
            $table->string('nmorg',100);
            $table->string('nmwil',50);
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
