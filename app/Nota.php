<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $table = 't_nota';

    protected $primaryKey="nota_id";
	protected $fillable = ['nota_titulo','nota_observ','cita_id'];
	
	public function cita(){
		return $this->belongsTo('DentalSoft\Cita','cita_id');
	}
}
