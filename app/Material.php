<?php

namespace sacep;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'material';

	protected $primaryKey = 'id_material';

	public $timestamps = false;

	protected $fillable = [
		'nombre',
		'codigo_material',
		'cantidad',
		'id_departamento'
	];

	/**
	 * Empleados que tiene un tmaterial
	 */
	public function empleados()
	{
		return $this->belongsToMany('sacep\Empleado','material_asignado_empleado','id_material','cedula_empleado')
		->withPivot(['fecha','tipo']);
	}

	/**
	 * A que departamento pertenece un material
	 */
	
	public function departamento()
	{
		return $this->belongsTo('sacep\Departamento','id_departamento','id_departamento');
	}
}
