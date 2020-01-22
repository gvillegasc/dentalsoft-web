<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class DTPieza extends Model
{
    protected $table = 't_dtpieza';

    protected $primaryKey="dtpieza_id";
	protected $fillable = ['pieza_id','superficie_id','diagnostico_id','dtratamiento_id'];

	public function pieza(){
		return $this->belongsTo('DentalSoft\Pieza','pieza_id');
	}

	public function superficie(){
		return $this->belongsTo('DentalSoft\Superficie','superficie_id');
	}

	public function diagnostico(){
		return $this->belongsTo('DentalSoft\Diagnostico','diagnostico_id');
	}

	public function dtratamiento(){
		return $this->belongsTo('DentalSoft\DTratamiento','dtratamiento_id');
	}
}
