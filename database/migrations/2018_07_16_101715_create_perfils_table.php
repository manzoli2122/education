<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('perfils', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 60);
            $table->string('descricao');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });



        Schema::create('perfils_users', function (Blueprint $table) {
            
            $table->increments('id');
            $table->unsignedInteger('perfil_id');
            //$table->unsignedInteger('user_id');
            $table->char('user_id',11);



            $table->foreign('perfil_id')->references('id')->on('perfils')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('perfils_users', function (Blueprint $table) {
            $table->dropForeign(['perfil_id']);             
            $table->dropForeign(['user_id']);             
        });

        Schema::dropIfExists('perfils_users');

        Schema::dropIfExists('perfils');

    }
}
