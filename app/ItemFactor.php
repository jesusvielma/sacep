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
		'id_factor'
	];

	public function factor()
	{
		return $this->belongsTo('sacep\FactorDeEvaluacion','id_factor','id_factor');
	}
}
