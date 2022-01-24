<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPemberiTugasToLogBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_books', function (Blueprint $table) {
            $table->integer("pemberi_tugas_id")->nullable();
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
        Schema::table('log_books', function (Blueprint $table) {
            //
        });
    }
}
