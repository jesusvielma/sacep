<?php

namespace sacep;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = 'cargo';

	protected $primaryKey = 'id_cargo';

	protected $timestamps = false;

	protected $fillable = ['nombre'];
}
