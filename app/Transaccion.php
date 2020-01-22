<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    protected $table = 't_transaccion';

    protected $primaryKey="transaccion_id";
	protected $fillable = ['transaccion_fecha','transaccion_monto','tratamiento_id'];
	
	public function tratamiento(){
		return $this->belongsTo('DentalSoft\Tratamiento','tratamiento_id');
	}

	/*public function pago(){
		return $this->belongsTo('DentalSoft\Pago','pago_id');
	}*/
}
