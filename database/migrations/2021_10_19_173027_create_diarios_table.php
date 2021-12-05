<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diari', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('data');
            $table->decimal('num_ore',5,2);
            $table->string('note');
            $table->bigInteger('id_asseg')->unsigned();;
            $table->timestamps();

            $table->foreign('id_asseg')
                   ->references('id')
                   ->on('assegnazioni')
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
        Schema::dropIfExists('diari');
    }
}
