<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaItemEvaluado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_evaluado', function (Blueprint $table) {
            $table->integer('id_evaluacion')->unsigned();
            $table->integer('id_item')->unsigned();
            $table->primary(['id_evaluacion','id_item']);
            $table->tinyInteger('puntaje');
            $table->foreign('id_evaluacion')->references('id_evaluacion')->on('evaluacion')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_item')->references('id_item')->on('item_factor')
            ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_evaluado');
    }
}
