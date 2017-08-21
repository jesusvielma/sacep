<?php

namespace sacep;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
	protected $table = 'articulo';

	protected $primaryKey = 'id_articulo';

	public $timestamps = false;

	protected $fillable = ['identificador','contenido','ley','gravedad','tipo'];

	public function art_padre()
	{
		return $this->belongsTo('sacep\Articulo','padre','id_articulo');
	}
}
