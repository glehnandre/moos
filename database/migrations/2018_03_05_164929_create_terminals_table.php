<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerminalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terminals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('terminal_id');
            $table->integer('evento_id')->unsigned()->nullable();
            $table->foreign('evento_id')->references('id')->on('eventos');  
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users'); 
            $table->boolean('sync_menu')->default(false); 
            $table->boolean('ativo')->default(true); 
            $table->boolean('bloqueado')->default(false); 
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
        Schema::dropIfExists('terminals');
    }
}
