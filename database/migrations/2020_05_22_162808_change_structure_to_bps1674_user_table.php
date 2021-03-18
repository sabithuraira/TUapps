<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStructureToBps1674UserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bps1674_user', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('nama');
            $table->string('name');
            $table->string('email_verified_at')->nullable();
            $table->string('remember_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bps1674_user', function (Blueprint $table) {
            //
        });
    }
}
