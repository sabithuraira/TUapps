<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRencanaToLogBoookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_books', function (Blueprint $table) {
            $table->integer("is_rencana")->nullable();
            $table->integer("status_rencana")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_boook', function (Blueprint $table) {
            //
        });
    }
}
