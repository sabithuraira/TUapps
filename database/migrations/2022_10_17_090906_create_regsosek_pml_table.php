<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegsosekPmlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regsosek_pml', function (Blueprint $table) {
            $table->increments('id');

            $table->string("nama_petugas");
            $table->string("photo_file_id")->nullable();
            $table->string("photo_file_unique_id")->nullable();
            $table->string("photo_width")->nullable();
            $table->string("photo_height")->nullable();
            $table->string("photo_file_size")->nullable();
            $table->integer("photo_status_unduh")->default(0);

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
        Schema::dropIfExists('regsosek_pml');
    }
}
