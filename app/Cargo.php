<?php

namespace sacep;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = 'cargo';

	protected $primaryKey = 'id_cargo';

	public $timestamps = false;

	protected $fillable = ['nombre','estado'];

    public function empleados()
    {
        return $this->hasMany('sacep\Empelado','id_cargo','cedula_empleado');
    }
}
