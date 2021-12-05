<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssegnazionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assegnazioni', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_progetto')->unsigned();
            $table->bigInteger('id_user')->unsigned();
            $table->timestamps();

            $table->unique(['id_progetto', 'id_user']);
            
            $table->foreign('id_progetto')
                   ->references('id')
                   ->on('projects')
                   ->onDelete('cascade');			
            
            $table->foreign('id_user')
                   ->references('id')
                   ->on('users')
                   ->onDelete('cascade');			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assegnazioni');
    }
}
