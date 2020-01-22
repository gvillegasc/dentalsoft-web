<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    protected $table = 't_tratamiento';

    protected $primaryKey="tratamiento_id";
	protected $fillable = ['tratamiento_fecha','tratamiento_estado','tratamiento_titulo','tratamiento_observ','tratamiento_subtotal','tratamiento_descuento','tratamiento_total','paciente_id'];
	
	public function dtratamientos(){
		return $this->hasMany('DentalSoft\DTratamiento','tratamiento_id');
	}

	public function transacciones(){
		return $this->hasMany('DentalSoft\Transaccion','tratamiento_id');
	}

	public function paciente(){
		return $this->belongsTo('DentalSoft\Paciente','paciente_id');
	}
}
