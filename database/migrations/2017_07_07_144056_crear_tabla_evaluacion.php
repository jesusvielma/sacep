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
            $table->enum('motivo',['regular','periodica','renovacion','ascenso','traslado']);
            $table->enum('tipo',['mensual','bimestral','trimestral','semestral','anual']);
            $table->integer('departamento_trabajador_evaluado')->unsigned();
            $table->integer('cargo_trabajador_evaluado')->unsigned();
            $table->foreign('departamento_trabajador_evaluado','dte_foreign')
                    ->references('id_departamento')->on('departamento')
                    ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cargo_trabajador_evaluado','cte_foreign')
                    ->references('id_cargo')->on('cargo')
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
        Schema::dropIfExists('evaluacion');
    }
}
