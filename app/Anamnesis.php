<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class Anamnesis extends Model
{
    protected $table = 't_anamnesis';

    protected $primaryKey="anamnesis_id";
	protected $fillable = ['anamnesis_motivo','anamnesis_amedico','anamnesis_alergia','anamnesis_medicamento','anamnesis_habito','anamnesis_afamiliar','anamnesis_embarazo','anamnesis_coagulacion','anamnesis_panestesia','anamnesis_otros','paciente_id'];
	
	public function paciente(){
		return $this->belongsTo('DentalSoft\Paciente','paciente_id');
	}
}
