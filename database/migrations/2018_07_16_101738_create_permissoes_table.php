<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 60);
            $table->string('descricao');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });



        Schema::create('permissao_perfils', function (Blueprint $table) {
            
            $table->increments('id');
            
            $table->unsignedInteger('permissao_id');

            $table->unsignedInteger('perfil_id');            

            $table->foreign('permissao_id')->references('id')->on('permissoes')->onDelete('restrict');

            $table->foreign('perfil_id')->references('id')->on('perfils')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('permissao_perfils');
       Schema::dropIfExists('permissoes');
   }
}
