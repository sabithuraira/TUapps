<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_books', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('user_id');
            $table->date('tanggal');
            $table->text('isi');

            $table->integer('is_approve');
            $table->text('catatan_approve');

            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('log_books');
    }
}
