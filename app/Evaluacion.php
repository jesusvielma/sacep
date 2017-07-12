<?php

namespace sacep;

use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $table = 'evaluacion';

	protected $primaryKey = 'id_evaluacion';

	protected $timestamps = false;

	protected $fillable = [
		'id_evaluacion',
		'fecha_evaluacion',
		'periodo_desde',
		'periodo_hasta',
		'estado',
		'motivo',
		'tipo'
	];

    public function empleado()
	{
		return $this->belongsToMany('sacep\Empleado','evaluacion_empleado','id_evaluacion','cedula_empleado')
        ->withPivot('tipo');
	}

    public function item_evaluado()
    {
        return $this->belongsToMany('sacep\FactorDeEvaluacion','item_evaluado','id_evaluacion','id_factor')
        ->withPivot('puntaje');
    }
}
