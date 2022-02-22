<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuHistoricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_historicos', function (Blueprint $table) {
            $table->increments('id');
            $table->float('valor_antigo', 10, 2);
            $table->float('valor_novo', 10, 2);
            $table->integer('desconto_antigo')->nullable()->default(NULL);  
            $table->integer('desconto_novo')->nullable()->default(NULL);  
            $table->integer('menu_id')->unsigned()->nullable();
            $table->foreign('menu_id')->references('id')->on('menus');  
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users'); 
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
        Schema::dropIfExists('menu_historicos');
    }
}
