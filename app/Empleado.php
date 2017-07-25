<?php

namespace sacep;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
	/**
	* Tabla a la cual hace referencia el modelo
	*
	* @var string
	*/
    protected $table = 'empleado';

	/**
	* Indica en campo clave primaria
	* @var string
	*
	*/
	protected $primaryKey = 'cedula_empleado';

	/**
	* Indica que si el modelo usara timestramps
	*
	* @var bool
	*/
	public $timestamps = false;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'cedula_empleado',
		'nombre_completo',
		'fecha_ingreso',
		'fecha_nacimiento',
		'estado',
		'id_cargo',
		'id_departamento',
		'id_usuario'
	];

	/**
     * Obtener el usuario al que esta asociado un Empleado
     */
    public function usuario()
    {
        return $this->belongsTo('sacep\Usuario','id_usuario','id_usuario');
    }

	/**
	* Obtener el cargo del empleado
	*/
	public function cargo()
	{
		return $this->belongsTo('sacep\Cargo','id_cargo','id_cargo');
	}

	/**
	* Obtener las evaluaciones del empleado
	*/
	public function evaluaciones()
	{
		return $this->belongsToMany('sacep\Evaluacion','evaluacion_empleado','cedula_empleado','id_evaluacion');
	}

	/**
	* Obtener el departamento al cual esta adscrito el empleado
	*/
	public function departamento()
	{
		return $this->hasOne('sacep\Departamento','id_departamento','id_departamento');
	}
}
