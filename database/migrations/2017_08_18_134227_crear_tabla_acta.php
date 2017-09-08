<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaActa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acta', function (Blueprint $table) {
            $table->smallIncrements('id_acta');
            $table->text('descripcion');
            $table->dateTime('fecha');
            $table->string('lugar');
            $table->enum('tipo',['inasistencia','falta','amonesstacion']);
            $table->string('palabra_clave',45);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acta');
    }
}
