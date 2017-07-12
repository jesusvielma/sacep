<?php

namespace sacep;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Scalar\String_;

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
		'estado'
	];

	/**
     * obtener el usuario de un empleado
     */
    public function usuario()
    {
        return $this->belongsTo('sacep\Usuario','id_usuario');
    }
}
