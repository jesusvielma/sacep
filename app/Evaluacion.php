<?php

namespace sacep;

use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $table = 'evaluacion';

	protected $primaryKey = 'id_evaluacion';

	public $timestamps = false;

    protected $dates = [
        'fecha_evaluacion',
        'periodo_desde',
		'periodo_hasta',
    ];

	protected $fillable = [
		'id_evaluacion',
		'fecha_evaluacion',
		'periodo_desde',
		'periodo_hasta',
		'estado',
		'motivo',
		'tipo',
        'departamento_trabajador_evaluado',
        'cargo_trabajador_evaluado',
        'descripcion',
        'recomendacion',
        'comentario',
	];

    /**
     * Emplados que estan presentes en una evaluación
     */
    public function empleados()
	{
		return $this->belongsToMany('sacep\Empleado','evaluacion_empleado','id_evaluacion','cedula_empleado')
        ->withPivot('tipo');
	}

    /**
     * Los items que fueron evaluados
     */
    public function item_evaluado()
    {
        return $this->belongsToMany('sacep\ItemFactor','item_evaluado','id_evaluacion','id_item')
        ->withPivot('puntaje');
    }

    /**
     * El cargo del empleado en el momento de la evlauación
     */
    public function cargo_emp()
    {
        return $this->belongsTo('sacep\Cargo','cargo_trabajador_evaluado','id_cargo');
    }

    /**
     * El departamento en que estaba el empleado al momento de la evaluación
     */
    public function dep_emp()
    {
        return $this->belongsTo('sacep\Departamento','departamento_trabajador_evaluado','id_departamento');
    }
}
