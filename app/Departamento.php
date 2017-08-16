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

    /**
     * Encargado del departamento Jefe, supervisor o Coordinador
     */
	public function encargado()
	{
		return $this->hasOne('sacep\Empleado','cedula_empleado','responsable');
	}

    /**
     * Empleados que pertenecen a un departamento
     */
    public function empleados()
    {
        return $this->hasMany('sacep\Empleado','id_departamento','id_departamento');
    }

    /**
     * Saber la coordinación de la undiad
     * @return [type] [description]
     */
    public function hijo()
    {
        return $this->belongsTo('sacep\Departamento','departamento_padre','id_departamento');
    }

    /**
     * Saber que unidades tiene un coordinación
     */
    public function padre()
    {
        return $this->hasMany('sacep\Departamento','departamento_padre','id_departamento');
    }

    /**
     * Materiales de un departamento
     */
    public function materiales()
    {
        return $this->hasMany('sacep\Material','id_departamento','id_departamento');
    }
}
