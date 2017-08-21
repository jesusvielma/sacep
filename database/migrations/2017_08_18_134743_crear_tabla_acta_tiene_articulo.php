<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaActaTieneArticulo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acta_tiene_articulo', function (Blueprint $table) {
            $table->smallInteger('id_acta')->unsigned();
            $table->integer('id_articulo')->unsigned();
            $table->primary(['id_acta','id_articulo']);
            $table->foreign('id_acta')->references('id_acta')->on('acta')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_articulo')->references('id_articulo')->on('articulo')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acta_tiene_articulo');
    }
}
