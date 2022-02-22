<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cartao_id');
            $table->string('terminal');
            $table->boolean('ativo')->default(true);  
            $table->boolean('bloqueado')->default(false);  
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('timestamp');
            $table->integer('evento_id')->unsigned()->nullable();
            $table->foreign('evento_id')->references('id')->on('eventos');  
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');  
            $table->unique(['cartao_id', 'cpf']);
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
        Schema::dropIfExists('cartoes');
    }
}
