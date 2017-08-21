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

	protected $dates = [
		'fecha_ingreso',
		'fecha_nacimiento',
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
		return $this->belongsToMany('sacep\Evaluacion','evaluacion_empleado','cedula_empleado','id_evaluacion')->withPivot('tipo');
	}

	/**
	* Obtener el departamento al cual esta adscrito el empleado
	*/
	public function departamento()
	{
		return $this->belongsTo('sacep\Departamento','id_departamento','id_departamento');
	}

	/**
	 * Materiales que tiene un empleado
	 */
	public function materiales()
	{
		return $this->belongsToMany('sacep\Material','material_asignado_empleado','cedula_empleado','id_material')
		->withPivot(['fecha','tipo']);
	}

	public function actas()
	{
		return $this->belongsToMany('sacep\Acta','empleado_sancion','cedula_empleado','id_acta')->withPivot('tipo');
	}
}
