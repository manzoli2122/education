<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioPerfilLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_perfil_log', function (Blueprint $table) {
            $table->increments('id');

            // $table->unsignedInteger('user_id'); 
            // $table->unsignedInteger('autor_id')->nullable();

            $table->char('user_id',11);
            $table->char('autor_id',11)->nullable();

            $table->string('acao');
            
             

            $table->unsignedInteger('perfil_id');
 
            $table->foreign('perfil_id')->references('id')->on('perfils')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('autor_id')->references('id')->on('users')->onDelete('set null'); 

           
            $table->timestamps();


            $table->string('ip_v4', 15)->nullable();
            $table->string('sistema_operacional', 15)->nullable();
            $table->string('navegador', 15)->nullable();
            $table->string('navegador_versao', 15)->nullable();
            $table->string('host')->nullable();


           // $table->integer('usuario_id')->unsigned();
           // $table->date('data');
           // $table->time('hora');

            //$table->dateTime('data_hora_logout')->nullable();
            
           // $table->boolean('senha');
            
           // $table->foreign('usuario_id')->references('id')->on('usuarios');
           // $table->primary(['usuario_id', 'data', 'hora']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario_perfil_log');
    }
}
