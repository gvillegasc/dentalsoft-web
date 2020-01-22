<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 't_provincia';

    protected $primaryKey="provincia_id";
	protected $fillable = ['provincia_cod','provincia_desc','departamento_id'];
	
	public function pacientes(){
		return $this->hasMany('DentalSoft\Paciente');
	}

	public function distritos(){
		return $this->hasMany('DentalSoft\Distrito');
	}

	public function departamento(){
		return $this->belongsTo('DentalSoft\Departamento','departamento_id');
	}
}
