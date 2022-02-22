<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditosTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creditos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cpf');
            $table->string('nome');
            $table->string('cartao');
            $table->string('transacao');
            $table->string('bandeira')->nullable();
            $table->float('credito', 10, 2);
            $table->string('terminal');
            $table->string('latitude');
            $table->string('longitude');
            $table->String('data_transacao');
            $table->string('id_transacao');
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
        Schema::dropIfExists('creditos');
    }
}
