<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhotoToRegsosekSlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('regsosek_sls', function (Blueprint $table) {
            $table->string("photo_file_id")->nullable();
            $table->string("photo_file_unique_id")->nullable();
            $table->string("photo_width")->nullable();
            $table->string("photo_height")->nullable();
            $table->string("photo_file_size")->nullable();
            $table->integer("photo_status_unduh")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('regsosek_sls', function (Blueprint $table) {
            //
        });
    }
}
