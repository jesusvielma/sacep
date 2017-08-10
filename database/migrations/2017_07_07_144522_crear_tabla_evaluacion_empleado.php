<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaEvaluacionEmpleado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluacion_empleado', function (Blueprint $table) {
            $table->integer('id_evaluacion')->unsigned();
            $table->integer('cedula_empleado');
            $table->enum('tipo',['coordinador','supervisor','jefe','gerente','trabajador','evaluador','th']);
            $table->primary(['id_evaluacion','cedula_empleado','tipo']);
            $table->foreign('id_evaluacion')->references('id_evaluacion')->on('evaluacion')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cedula_empleado')->references('cedula_empleado')->on('empleado')
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
        Schema::dropIfExists('evaluacion_empleado');
    }
}
