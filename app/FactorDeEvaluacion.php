<?php

namespace sacep;

use Illuminate\Database\Eloquent\Model;

class FactorDeEvaluacion extends Model
{
	protected $table = 'factor_de_evaluacion';

	protected $primaryKey = 'id_factor';

	protected $timestamps = false;

	protected $fillable = [
		'nombre',
		'estado',
		'porcentaje'
	];

	public function items()
	{
		return $this->hasMany('sacep\Item','id_factor');
	}

	
}
