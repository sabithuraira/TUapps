<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKurangToOpnamePersediaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('opname_persediaan', function (Blueprint $table) {
            $table->integer('saldo_kurang');
            $table->decimal('harga_kurang', 13, 2);  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('opname_persediaan', function (Blueprint $table) {
            //
        });
    }
}
