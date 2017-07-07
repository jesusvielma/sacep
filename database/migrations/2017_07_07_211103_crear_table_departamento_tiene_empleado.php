<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTableDepartamentoTieneEmpleado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departamento_tiene_empleado', function (Blueprint $table) {
            $table->integer('id_departamento');
            $table->integer('cedula_empleado');
            $table->date('desde');
            $table->date('hasta');
            $table->foreign('id_departamento')->references('id_departamento')->on('departamento');
            $table->foreign('cedula_empleado')->references('cedula_empleado')->on('empleado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departamento_tiene_empleado');
    }
}
