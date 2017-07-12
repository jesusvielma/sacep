<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarEstadoDepartamentoTieneEmpleado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departamento_tiene_empleado', function (Blueprint $table) {
            $table->boolean('estado')->after('hasta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('departamento_tiene_empleado', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
}
