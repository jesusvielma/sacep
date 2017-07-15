<?php

namespace sacep;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamento';

	protected $primaryKey = 'id_departamento';

	public $timestamps = false;

	protected $fillable = [
		'nombre',
        'responsable',
	];

	public function encargado()
	{
		return $this->hasOne('sacep\Empleado','cedula_empleado','responsable');
	}

    public function empleados()
    {
        return $this->belongsToMany('sacep\Empleado','departamento_tiene_empleado','id_departamento','cedula_empleado')
        ->withPivot(['desde','hasta','estado']);
    }
}
