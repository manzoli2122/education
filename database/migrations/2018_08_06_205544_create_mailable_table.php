<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailableTable extends Migration
{

 

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailable', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 60)->unique();
            $table->string('descricao');
            $table->timestamps();
        });


        Schema::create('users_mailable', function (Blueprint $table) { 
            $table->increments('id');
            $table->unsignedInteger('mailable_id'); 
            $table->char('user_id',11);  
            $table->foreign('mailable_id')->references('id')->on('mailable')->onDelete('cascade');
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
        Schema::dropIfExists('users_mailable');
        Schema::dropIfExists('mailable');
    }
}
