<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 't_departamento';

    protected $primaryKey="departamento_id";
	protected $fillable = ['departamento_cod','departamento_desc'];
	
	public function clinicas(){
		return $this->hasMany('DentalSoft\Clinica');
	}

	public function pacientes(){
		return $this->hasMany('DentalSoft\Paciente');
	}

	public function provincias(){
		return $this->hasMany('DentalSoft\Provincia');
	}
}
