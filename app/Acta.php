<?php

namespace sacep;

use Illuminate\Database\Eloquent\Model;

class Acta extends Model
{
	protected $table = 'acta';

	protected $primaryKey = 'id_acta';

	public $timestamps = false;

	protected $dates = ['fecha'];

	protected $fillable = ['descripcion','fecha','lugar','tipo','palabra_clave','estado'];

	/**
	 * Artículos en una sanción
	 */
	public function articulos()
	{
		return $this->belongsToMany('sacep\Articulo','acta_tiene_articulo','id_acta','id_articulo');
	}

	/**
	 * Empleados en una sanción
	 */
	public function empleados()
	{
		return $this->belongsToMany('sacep\Empleado','empleado_sancion','id_acta','cedula_empleado')->withPivot('tipo');
	}
}
