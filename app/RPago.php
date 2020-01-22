<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class RPago extends Model
{
    protected $table = 't_rpago';

    protected $primaryKey="rpago_id";
	protected $fillable = ['rpago_nombre','rpago_nota','paciente_id'];
	
	public function paciente(){
		return $this->belongsTo('DentalSoft\Paciente','paciente_id');
	}
}
