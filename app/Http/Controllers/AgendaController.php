<?php

namespace DentalSoft\Http\Controllers;

use Illuminate\Http\Request;
use DentalSoft\Paciente;
use DentalSoft\MConsulta;
use DentalSoft\ECita;
use DentalSoft\Consulta;
use DentalSoft\Cita;
use DentalSoft\CAdicional;
use DentalSoft\Rpago;
use DentalSoft\Anamnesis;
use DentalSoft\Odontograma;
use DentalSoft\Tratamiento;

use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $usuario_id=Auth::user()->id;
        $pacientes=Paciente::where('usuario_id',$usuario_id)->where('paciente_id','<>','1')->get();
        $ecitas=ECita::all();
        $mconsultas=MConsulta::all();

        $citas=Paciente::select('t_cita.cita_id','t_cita.ecita_id','t_consulta.consulta_id','t_paciente.paciente_id','t_paciente.paciente_nombre','t_cita.cita_fecha','t_cita.cita_hora')->join('t_consulta', 't_paciente.paciente_id', '=', 't_consulta.paciente_id')->join('t_cita', 't_consulta.cita_id', '=', 't_cita.cita_id')->where('t_paciente.usuario_id',$usuario_id)->get();
       

        return view('agenda.mostrar',['pacientes'=>$pacientes,'citas'=>$citas,'ecitas'=>$ecitas,'mconsultas'=>$mconsultas]);
    }

    public function getVerCita(Request $request)
    {
        $consulta_id=$request->get('consulta_id');

        $citas=Paciente::select('t_cita.*','t_consulta.*','t_paciente.*',)->join('t_consulta', 't_paciente.paciente_id', '=', 't_consulta.paciente_id')->join('t_cita', 't_consulta.cita_id', '=', 't_cita.cita_id')->where('t_consulta.consulta_id',$consulta_id)->get();
       

        return $citas;
    }

    public function getConsultaDni(Request $request)
    {
        $dni=$request->get('dni');

        $urlContents=file_get_contents("http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI=$dni");
        $apellido=substr($urlContents,0,strripos($urlContents,'|'));
        $apellido=str_replace('|', ' ',$apellido);
        $nombre=substr($urlContents,strripos($urlContents,'|')+1,strlen($urlContents));
        $datos=array($nombre,$apellido);

        return $datos;
    }

    public function postCrearCita(Request $request)
    {
        $paciente_id=$request->get('paciente_id');
        $usuario_id=Auth::user()->id;

        if($paciente_id!=0)
        {
            \DB::transaction(function() use ($request){
                $cita=Cita::create
                (
                    [
                        'cita_fecha' => strtoupper($request->get('cita_fecha')),
                        'cita_hora' => strtoupper($request->get('cita_hora')),
                        'cita_duracion' => strtoupper($request->get('cita_duracion')),
                        'cita_tiempo' => 'min',
                        'ecita_id' => $request->get('ecita_id')
                    ]
                );

                Consulta::create
                (
                    [
                        'consulta_observ' => ($request->get('consulta_observ')!=null)? $request->get('consulta_observ'):'',
                        'cita_id' => $cita->cita_id,
                        'mconsulta_id' => $request->get('mconsulta_id'),
                        'paciente_id' => $request->get('paciente_id'),
                        'receta_id' => '1'
                    ]
                );

            });
        }
        else
        {
            \DB::transaction(function() use ($request){
                $usuario_id=Auth::user()->id;
                $paciente=Paciente::create
                (
                    [
                        'paciente_dni' => strtoupper($request->get('paciente_dni')),
                        'paciente_nombre' => strtoupper($request->get('paciente_nombre')),
                        'paciente_apellido' => strtoupper($request->get('paciente_apellido')),
                        'paciente_telefono' => $request->get('paciente_telefono'),
                        'paciente_fechanac' => $request->get('paciente_fechanac'),
                        'paciente_genero' => strtoupper($request->get('paciente_genero')),
                        'paciente_correo' => '',
                        'paciente_ocupacion' => '',
                        'paciente_direccion' => strtoupper($request->get('paciente_direccion')),
                        'departamento_id' => '1',
                        'provincia_id' => '1',
                        'distrito_id' => '1',
                        'clinica_id' => '1',
                        'usuario_id' => $usuario_id
                    ]
                );

                CAdicional::create
                (
                    [
                        'cadicional_nombre' => '',
                        'cadicional_parentesco' => '',
                        'cadicional_telefono' => '',
                        'paciente_id' => $paciente->paciente_id
                    ]
                );

                Rpago::create
                (
                    [
                        'rpago_nombre' => '',
                        'rpago_nota' => '',
                        'paciente_id' => $paciente->paciente_id
                    ]
                );

                Anamnesis::create
                (
                    [
                        'anamnesis_motivo' =>'',
                        'anamnesis_amedico' =>'',
                        'anamnesis_alergia' =>'',
                        'anamnesis_medicamento' =>'',
                        'anamnesis_habito' =>'',
                        'anamnesis_afamiliar' =>'',
                        'anamnesis_embarazo' =>'',
                        'anamnesis_coagulacion' =>'',
                        'anamnesis_panestesia' =>'',
                        'anamnesis_otros' =>'',
                        'paciente_id' => $paciente->paciente_id
                    ]
                );

                Odontograma::create
                (
                    [
                        'odontograma_fecha' => date("Y-m-d"),
                        'odontograma_estado' =>'',
                        'odontograma_titulo' =>'',
                        'odontograma_observ' =>'',
                        'paciente_id' => $paciente->paciente_id
                    ]
                );

                Tratamiento::create
                (
                    [
                        'tratamiento_fecha' => date("Y-m-d"),
                        'tratamiento_estado' =>'base',
                        'tratamiento_titulo' =>'',
                        'tratamiento_observ' =>'',
                        'tratamiento_subtotal' =>'0',
                        'tratamiento_descuento' =>'0',
                        'tratamiento_total' =>'0',
                        'paciente_id' => $paciente->paciente_id
                    ]
                );

                $cita=Cita::create
                (
                    [
                        'cita_fecha' => $request->get('cita_fecha'),
                        'cita_hora' => $request->get('cita_hora'),
                        'cita_duracion' => $request->get('cita_duracion'),
                        'cita_tiempo' => 'min',
                        'ecita_id' => $request->get('ecita_id')
                    ]
                );

                Consulta::create
                (
                    [
                        'consulta_observ' => ($request->get('consulta_observ')!=null)? $request->get('consulta_observ'):'',
                        'cita_id' => $cita->cita_id,
                        'mconsulta_id' => $request->get('mconsulta_id'),
                        'paciente_id' => $paciente->paciente_id,
                        'receta_id' => '1'
                    ]
                );

            });
        }

        return redirect('/agenda')->with('creado','La cita ha sido creado');
    }

    public function postEditarCita(Request $request)
    {

        $cita=Cita::find($request->get('cita_id'));
        $cita->cita_fecha = $request->get('cita_fecha');
        $cita->cita_hora = $request->get('cita_hora');
        $cita->cita_duracion = ($request->get('cita_duracion')!=null)? $request->get('cita_duracion'):'';
        $cita->ecita_id = $request->get('ecita_id');
        $cita->save();

        $consulta=Consulta::find($request->get('consulta_id'));
        $consulta->consulta_observ = ($request->get('consulta_observ')!=null)? $request->get('consulta_observ'):'';
        $consulta->mconsulta_id = $request->get('mconsulta_id');
        $consulta->save();


        return redirect('/agenda')->with('creado','La cita ha sido actualizada');
    }
}
