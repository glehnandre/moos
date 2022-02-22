<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->float('valor', 10, 2);
            $table->string('categoria')->nullable();
            $table->text('imagem')->nullable()->default(NULL);
            $table->string('imagem_type')->nullable()->default(NULL);
            $table->string('descricao')->nullable();
            $table->boolean('ativo')->default(true);  
            $table->integer('desconto')->nullable()->default(NULL);  
            $table->integer('evento_id')->unsigned()->nullable();
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
        Schema::dropIfExists('menus');
    }
}
