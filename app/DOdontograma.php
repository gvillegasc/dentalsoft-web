<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class DOdontograma extends Model
{
    protected $table = 't_dodontograma';

    protected $primaryKey="dodontograma_id";
	protected $fillable = ['dodontograma_observ','pieza_id','superficie_id','diagnostico_id','odontograma_id'];
	
	public function pieza(){
		return $this->belongsTo('DentalSoft\Pieza','pieza_id');
	}

	public function superficie(){
		return $this->belongsTo('DentalSoft\Superficie','superficie_id');
	}

	public function diagnostico(){
		return $this->belongsTo('DentalSoft\Diagnostico','diagnostico_id');
	}

	public function odontograma(){
		return $this->belongsTo('DentalSoft\Odontograma','odontograma_id');
	}
}
