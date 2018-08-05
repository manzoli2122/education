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
            
            $table->char('id', 11)->primary('id')->comment('CPF DO USUARIO');
            $table->string('name', 150);
            $table->integer('rg')->nullable()->unique()->comment('RG da PMES');
            $table->integer('nf')->nullable()->unique()->comment('NUMERO FUNCIONAL DO SIARHES');     
            $table->string('email')->unique();  
            $table->string('quadro_dsc', 50);
            $table->string('post_grad_dsc', 50);
            $table->integer('ome_qdi_id')->default('1')->unsigned()->comment('ID QDI OME DO EFETIVO');
            $table->string('ome_qdi_dsc', 50)->default('PMES')->comment('OME DO EFTIVO');
            $table->integer('ome_qdi_lft')->default('1')->unsigned()->comment('LFT de ACESSO');
            $table->integer('ome_qdi_rgt')->default('10000')->unsigned()->comment('RGT de ACESSO');            
            $table->enum('status', ['A', 'I'])->default('A')->comment('A->ATIVO, I-> INATIVO');
            $table->string('image', 200)->default('default.jpg');
            $table->string('obs', 200)->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->char('created_user',11)->default('00000000001');
            $table->string('created_ip',45)->nullable();
            $table->string('created_host',45)->nullable();  
            $table->char('updated_user',11)->default('00000000001');
            $table->string('updated_ip',45)->nullable();
            $table->string('updated_host',45)->nullable();
            $table->timestamps();
 
            // $table->increments('id');
            // $table->string('name');
            // $table->string('email')->unique();
            // $table->string('password');
            // $table->rememberToken();
            // $table->timestamps();
 
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
