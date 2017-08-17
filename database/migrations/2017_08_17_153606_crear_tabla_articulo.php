<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaArticulo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identificador',4);
            $table->text('contenido');
            $table->string('ley');
            $table->enum('gravedad',['amonestacion','inasistencia','falta']);
            $table->enum('tipo',['articulo','literal','parreafo']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulos');
    }
}
