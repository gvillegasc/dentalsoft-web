<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 't_cita';

    protected $primaryKey="cita_id";
	protected $fillable = ['cita_fecha','cita_hora','cita_duracion','cita_tiempo','ecita_id'];
	
	public function consulta(){
		return $this->hasOne('DentalSoft\Consulta');
	}

	public function nota(){
		return $this->hasOne('DentalSoft\Nota');
	}

	public function ecita(){
		return $this->belongsTo('DentalSoft\ECita','ecita_id');
	}
}
