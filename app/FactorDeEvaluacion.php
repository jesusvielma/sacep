<?php

namespace sacep;

use Illuminate\Database\Eloquent\Model;

class FactorDeEvaluacion extends Model
{
	protected $table = 'factor_de_evaluacion';

	protected $primaryKey = 'id_factor';

	public $timestamps = false;

	protected $fillable = [
		'nombre',
		'estado',
		'porcentaje'
	];

	/**
	* obtener los item de un factor de evaluación
	*/
	public function items()
	{
		return $this->hasMany('sacep\ItemFactor','id_factor','id_factor');
	}


}
