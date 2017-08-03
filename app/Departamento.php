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
        'departamento_padre',
        'tipo',
	];

	public function encargado()
	{
		return $this->hasOne('sacep\Empleado','cedula_empleado','responsable');
	}

    public function empleados()
    {
        return $this->hasMany('sacep\Empleado','id_departamento','id_departamento');
    }

    public function hijo()
    {
        return $this->belongsTo('sacep\Departamento','departamento_padre','id_departamento');
    }

    public function padre()
    {
        return $this->hasMany('sacep\Departamento','departamento_padre','id_departamento');
    }
}
