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

            $table->unsignedInteger('permissao_id')->nullable(); 

            $table->string('acao');

            $table->string('permissao_nome');
            
            //$table->unsignedInteger('autor_id')->nullable(); 
            $table->char('autor_id',11)->nullable();
            $table->unsignedInteger('perfil_id');
 
            $table->foreign('perfil_id')->references('id')->on('perfils')->onDelete('cascade');

            $table->foreign('permissao_id')->references('id')->on('permissoes')->onDelete('set null');

            $table->foreign('autor_id')->references('id')->on('users')->onDelete('set null'); 

             
            $table->string('ip_v4', 45)->nullable();
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
