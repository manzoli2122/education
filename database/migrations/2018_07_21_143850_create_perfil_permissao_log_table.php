<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilPermissaoLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil_permissao_log', function (Blueprint $table) {
            
            $table->increments('id');

            $table->unsignedInteger('permissao_id'); 

            $table->string('acao');
            
            $table->unsignedInteger('autor_id')->nullable(); 

            $table->unsignedInteger('perfil_id');
 
            $table->foreign('perfil_id')->references('id')->on('perfils')->onDelete('cascade');

            $table->foreign('permissao_id')->references('id')->on('permissoes')->onDelete('cascade');

            $table->foreign('autor_id')->references('id')->on('users')->onDelete('set null'); 

             
            $table->string('ip_v4', 15)->nullable();
            $table->string('sistema_operacional', 15)->nullable();
            $table->string('navegador', 15)->nullable();
            $table->string('navegador_versao', 15)->nullable();
            $table->string('host')->nullable();

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
        Schema::dropIfExists('perfil_permissao_log');
    }
}
