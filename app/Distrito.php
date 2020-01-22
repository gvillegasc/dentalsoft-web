<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $table = 't_distrito';

    protected $primaryKey="distrito_id";
	protected $fillable = ['distrito_cod','distrito_desc','provincia_id'];
	
	public function pacientes(){
		return $this->hasMany('DentalSoft\Paciente');
	}

	public function provincia(){
		return $this->belongsTo('DentalSoft\Provincia','provincia_id');
	}
}
