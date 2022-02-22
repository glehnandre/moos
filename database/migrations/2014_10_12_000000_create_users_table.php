<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('cpf');
            $table->string('email')->unique();
            $table->string('api_token', 60)->unique()->nullable();
            $table->string('password')->default('123456');
            $table->integer('telefone')->nullable()->default(NULL);  
            $table->boolean('bloqueado')->default(false);  
            $table->boolean('excluido')->default(false);  
            $table->boolean('ativo')->default(false);  
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
