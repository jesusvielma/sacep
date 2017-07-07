<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaItemFactor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_factor', function (Blueprint $table) {
            $table->increments('id_item');
            $table->string('nombre');
            $table->integer('id_factor');
            $table->foreign('id_factor')->references('id_factor')->on('factor_de_evaluacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_factor');
    }
}
