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
            $table->char('user_id',11); 
            $table->char('responsavel_id',11)->default('00000000001');

            $table->foreign('perfil_id')->references('id')->on('perfils')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('responsavel_id')->references('id')->on('users')->onDelete('restrict');


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
