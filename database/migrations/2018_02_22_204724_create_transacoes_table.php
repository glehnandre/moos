<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cpf');
            $table->string('cartao');
            $table->string('tipo_transacao')->nullable();
            $table->string('transacao')->nullable();
            $table->string('bandeira')->nullable();
            $table->float('valor', 10, 2);
            $table->string('terminal');
            $table->string('latitude');
            $table->string('longitude');
            $table->String('data_transacao');
            $table->string('transacao_id');
            $table->integer('evento_id')->unsigned();
            $table->foreign('evento_id')->references('id')->on('eventos');
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
        Schema::dropIfExists('transacoes');
    }
}
