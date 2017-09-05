<?php

namespace sacep;

use Illuminate\Database\Eloquent\Model;

class ItemFactor extends Model
{
	protected $table = 'item_factor';

	protected $primaryKey = 'id_item';

	public $timestamps = false;

	protected $fillable = [
		'nombre',
		'visivilidad',
		'informacion',
		'id_factor'
	];

	/**
	 * La pertenencia de un ítem a un factor
	 */
	public function factor()
	{
		return $this->belongsTo('sacep\FactorDeEvaluacion','id_factor','id_factor');
	}

	/**
     * Los ítems que han sido usados en evaluaciones
     */
    public function item_usuados()
    {
        return $this->belongsToMany('sacep\Evaluacion','item_evaluado','id_item','id_evaluacion')
        ->withPivot('puntaje');
    }


}
