<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaEvaluacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluacion', function (Blueprint $table) {
            $table->increments('id_evaluacion');
            $table->dateTime('fecha_evaluacion');
            $table->date('periodo_desde');
            $table->date('periodo_hasta');
            $table->enum('estado',['guardada','procesada']);
            $table->string('motivo',100);
            $table->enum('tipo',['mensual','trimestral','semestral','anual']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluacion');
    }
}
