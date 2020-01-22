<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table = 't_imagen';

    protected $primaryKey="imagen_id";
	protected $fillable = ['imagen_desc','imagen_url','paciente_id','album_id'];

	public function paciente(){
		return $this->belongsTo('DentalSoft\Paciente','paciente_id');
	}

	public function album(){
		return $this->belongsTo('DentalSoft\Album','album_id');
	}
}
