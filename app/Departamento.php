<?php

namespace sacep;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamento';

	protected $primaryKey = 'id_departamento';

	protected $timestamps = false;

	protected $fillable = [
		'nombre',
		'responsable',
	];

	public function resonsable()
	{
		return $this->hasOne('sacep\Empleado','cedula_empleado');
	}

    public function empleados()
    {
        return $this->belongsToMany('sacep\Empleado','departamento_tiene_empleado','id_departamento','cedula_empleado')
        ->withPivot(['desde','hasta','estado']);
    }
}
