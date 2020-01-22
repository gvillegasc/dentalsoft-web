<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 't_pago';

    protected $primaryKey="pago_id";
	protected $fillable = ['pago_fecha','pago_monto'];
	
	public function transacciones(){
		return $this->hasMany('DentalSoft\Transaccion');
	}
}
