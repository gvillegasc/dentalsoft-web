<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class Odontograma extends Model
{
    protected $table = 't_odontograma';

    protected $primaryKey="odontograma_id";
	protected $fillable = ['odontograma_fecha','odontograma_estado','odontograma_titulo','odontograma_observ','paciente_id'];
	
	public function dodontogramas(){
		return $this->hasMany('DentalSoft\DOdontograma','odontograma_id');
	}

	public function paciente(){
		return $this->belongsTo('DentalSoft\Paciente','paciente_id');
	}
}
