<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->text('description');
            $table->text('note');
            $table->date('date_start');
            $table->date('date_end_prev')->nullable();
            $table->date('date_end_eff')->nullable();
            $table->bigInteger('id_cliente')->unsigned();
            $table->decimal('hour_cost', 5, 2);
            $table->timestamps();

            $table->foreign('id_cliente')
                   ->references('id')
                   ->on('clienti')
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
        Schema::dropIfExists('projects');
    }
}
