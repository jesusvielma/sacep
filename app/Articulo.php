<?php

namespace sacep;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
	protected $table = 'articulo';

	protected $primaryKey = 'id';

	public $timestamps = false;

	protected $fillable = ['identificador','contenido','ley','gravedad','tipo'];
}
