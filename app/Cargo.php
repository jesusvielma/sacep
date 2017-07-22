<?php

namespace sacep;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = 'cargo';

	protected $primaryKey = 'id_cargo';

	public $timestamps = false;

	protected $fillable = ['nombre'];
}
