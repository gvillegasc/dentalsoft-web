<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class ECita extends Model
{
    protected $table = 't_ecita';

    protected $primaryKey="ecita_id";
	protected $fillable = ['ecita_desc'];
	
	public function citas(){
		return $this->hasMany('DentalSoft\Cita');
	}
}
