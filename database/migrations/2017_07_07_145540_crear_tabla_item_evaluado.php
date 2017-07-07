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
            $table->integer('id_evaluacion');
            $table->integer('id_item');
            $table->tinyInteger('puntaje');
            $table->foreign('id_evaluacion')->references('id_evaluacion')->on('evaluacion');
            $table->foreign('id_item')->references('id_item')->on('item_factor');
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
