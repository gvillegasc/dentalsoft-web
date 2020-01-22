<?php

namespace DentalSoft\Http\Controllers;

use Illuminate\Http\Request;
use DentalSoft\Paciente;
use DentalSoft\Departamento;
use DentalSoft\RPago;
use DentalSoft\CAdicional;
use DentalSoft\Anamnesis;
use DentalSoft\Imagen;
use DentalSoft\Odontograma;
use DentalSoft\Pieza;
use DentalSoft\Consulta;
use DentalSoft\Cita;
use DentalSoft\Receta;
use DentalSoft\Superficie;
use DentalSoft\Diagnostico;
use DentalSoft\DOdontograma;
use DentalSoft\Tratamiento;
use DentalSoft\DTratamiento;
use DentalSoft\DTPieza;
use DentalSoft\Transaccion;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class PacienteController extends Controller
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
        $pacientes=Paciente::where('usuario_id',$usuario_id)->where('paciente_id','<>','1')->where('paciente_id','<>','1')->get();
        $departamentos=Departamento::all();
        return view('paciente.mostrar',['pacientes'=>$pacientes,'departamentos'=>$departamentos]);
    }

    public function postCrear(Request $request)
    {
        
        \DB::transaction(function() use ($request){
            $usuario_id=Auth::user()->id;
            $paciente=Paciente::create
            (
                [
                    'paciente_dni' => strtoupper($request->get('paciente_dni')),
                    'paciente_nombre' => strtoupper($request->get('paciente_nombre')),
                    'paciente_apellido' => strtoupper($request->get('paciente_apellido')),
                    'paciente_correo' => strtoupper($request->get('paciente_correo')),
                    'paciente_telefono' => $request->get('paciente_telefono'),
                    'paciente_fechanac' => $request->get('paciente_fechanac'),
                    'paciente_genero' => strtoupper($request->get('paciente_genero')),
                    'paciente_ocupacion' => strtoupper($request->get('paciente_ocupacion')),
                    'paciente_direccion' => strtoupper($request->get('paciente_direccion')),
                    'departamento_id' => $request->get('departamento_id'),
                    'provincia_id' => '1',
                    'distrito_id' => '1',
                    'clinica_id' => '1',
                    'usuario_id' => $usuario_id
                ]
            );

            CAdicional::create
            (
                [
                    'cadicional_nombre' => strtoupper($request->get('cadicional_nombre')),
                    'cadicional_parentesco' => strtoupper($request->get('cadicional_parentesco')),
                    'cadicional_telefono' => strtoupper($request->get('cadicional_telefono')),
                    'paciente_id' => $paciente->paciente_id
                ]
            );

            Rpago::create
            (
                [
                    'rpago_nombre' => strtoupper($request->get('rpago_nombre')),
                    'rpago_nota' => strtoupper($request->get('rpago_nota')),
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

        }); 

        return redirect('/pacientes')->with('creado','El paciente ha sido creado');
    }

    public function getEliminarPaciente($paciente_id)
    {
        $paciente=Paciente::find($paciente_id);

        \DB::transaction(function() use ($paciente,$paciente_id){
            CAdicional::where('paciente_id',$paciente_id)->delete();
            Rpago::where('paciente_id',$paciente_id)->delete();
            Anamnesis::where('paciente_id',$paciente_id)->delete();        
            Imagen::where('paciente_id',$paciente_id)->delete();
            Receta::where('paciente_id',$paciente_id)->delete();

            $citas=Consulta::select('cita_id')->where('paciente_id',$paciente_id)->get();
            $listacita=array();
            foreach ($citas as $cita) {
                array_push($listacita,$cita->cita_id);
            }
            Consulta::where('paciente_id',$paciente_id)->delete();
            Cita::whereIn('cita_id',$listacita)->delete();
            

            $odontogramas=Odontograma::select('odontograma_id')->where('paciente_id',$paciente_id)->get();
            $listaodontograma=array();
            foreach ($odontogramas as $odontograma) {
                array_push($listaodontograma,$odontograma->odontograma_id);
            }
            $dodontogramas=DOdontograma::whereIn('odontograma_id',$listaodontograma)->delete();
            Odontograma::where('paciente_id',$paciente_id)->delete();

            $tratamientos=Tratamiento::select('tratamiento_id')->where('paciente_id',$paciente_id)->get();
            $listatratamiento=array();
            foreach ($tratamientos as $tratamiento) {
                array_push($listatratamiento,$tratamiento->tratamiento_id);
            }
            $dtratamientos=DTratamiento::whereIn('tratamiento_id',$listatratamiento)->delete();

            Transaccion::whereIn('tratamiento_id',$listatratamiento)->delete();
            Tratamiento::where('paciente_id',$paciente_id)->delete();

            $paciente->delete();
        }); 

        return redirect('/pacientes')->with('creado','El paciente ha sido eliminado');

    }

    public function getDetallePaciente($paciente_id)
    {
        $usuario_id=Auth::user()->id;
        $pacientes=Paciente::where('usuario_id',$usuario_id)->where('paciente_id','<>','1')->get();
        $paciente=Paciente::find($paciente_id);
        $departamentos=Departamento::all();
        $imagenes=Imagen::where('paciente_id',$paciente_id)->get();

        $tratamiento_id=Tratamiento::select('tratamiento_id')->where('paciente_id',$paciente_id)->orderby('tratamiento_fecha','desc')->get()[0]['tratamiento_id'];   
        $tratamiento=Tratamiento::find($tratamiento_id);
        $dtratamientos=DTratamiento::select('t_dtratamiento.dtratamiento_id','t_dtratamiento.pieza_id','t_pieza.pieza_desc','t_pieza.pieza_codigo','t_dtratamiento.superficie_id','t_superficie.superficie_desc','t_diagnostico.diagnostico_desc','t_dtratamiento.dtratamiento_desc','t_dtratamiento.dtratamiento_subtotal','t_dtratamiento.dtratamiento_descuento','t_dtratamiento.dtratamiento_total')->join('t_pieza','t_dtratamiento.pieza_id','=','t_pieza.pieza_id')->join('t_superficie','t_dtratamiento.superficie_id','=','t_superficie.superficie_id')->join('t_diagnostico','t_dtratamiento.diagnostico_id','=','t_diagnostico.diagnostico_id')->where('t_dtratamiento.tratamiento_id','=',$tratamiento_id)->get();

        $odontogramas=Odontograma::where('paciente_id',$paciente_id)->orderby('odontograma_fecha','desc')->orderby('odontograma_id','desc')->get();
        $odontograma=$odontogramas[0];

        $dodontogramas=DOdontograma::where('odontograma_id',$odontograma->odontograma_id)->get();

        $superfPieza=array();

        foreach ($dodontogramas as $dodontograma) {
            $dodont=DOdontograma::find($dodontograma->dodontograma_id);
            array_push($superfPieza,array($dodont->superficie->superficie_codigo.$dodont->pieza->pieza_codigo,$dodont->diagnostico->diagnostico_desc));
        }

        $superfPieza=json_encode($superfPieza);


        return view('paciente.mostrarpaciente',['pacientes'=>$pacientes,'paciente'=>$paciente,'departamentos'=>$departamentos,'imagenes'=>$imagenes,'superfPieza'=>$superfPieza,'odontograma'=>$odontograma,'odontogramas'=>$odontogramas,'dtratamientos'=>$dtratamientos,'tratamiento_id'=>$tratamiento_id,'tratamiento'=>$tratamiento]);
    }

    public function postGuardarIPrincipal(Request $request, $paciente_id)
    {
        $paciente=Paciente::find($paciente_id);
        $paciente->paciente_dni = strtoupper($request->get('paciente_dni'));
        $paciente->paciente_nombre = strtoupper($request->get('paciente_nombre'));
        $paciente->paciente_apellido = strtoupper($request->get('paciente_apellido'));
        $paciente->paciente_correo = strtoupper($request->get('paciente_correo'));
        $paciente->paciente_telefono = $request->get('paciente_telefono');
        $paciente->paciente_fechanac = $request->get('paciente_fechanac');
        $paciente->paciente_genero = strtoupper($request->get('paciente_genero'));
        $paciente->paciente_ocupacion = strtoupper($request->get('paciente_ocupacion'));
        $paciente->paciente_direccion = strtoupper($request->get('paciente_direccion'));
        $paciente->departamento_id = $request->get('departamento_id');
        $paciente->provincia_id = '1';
        $paciente->distrito_id = '1';
        $paciente->clinica_id = '1';
        $paciente->usuario_id = '1';
        $paciente->save();

        $paciente->cadicional->cadicional_nombre =strtoupper($request->get('cadicional_nombre'));
        $paciente->cadicional->cadicional_parentesco =strtoupper($request->get('cadicional_parentesco'));
        $paciente->cadicional->cadicional_telefono =strtoupper($request->get('cadicional_telefono'));
        $paciente->cadicional->save();

        $paciente->rpago->rpago_nombre = strtoupper($request->get('rpago_nombre'));
        $paciente->rpago->rpago_nota = strtoupper($request->get('rpago_nota'));
        $paciente->rpago->save();


        return redirect('/paciente/'.$paciente_id.'/ver')->with('creado','La información fue actualizada');
    }

    public function postGuardarAnamnesis(Request $request,$paciente_id)
    {        
        $paciente=Paciente::find($paciente_id);

        $paciente->anamnesis->anamnesis_motivo =strtoupper($request->get('anamnesis_motivo'));
        $paciente->anamnesis->anamnesis_amedico =strtoupper($request->get('anamnesis_amedico'));
        $paciente->anamnesis->anamnesis_alergia =strtoupper($request->get('anamnesis_alergia'));
        $paciente->anamnesis->anamnesis_medicamento =strtoupper($request->get('anamnesis_medicamento'));
        $paciente->anamnesis->anamnesis_habito =strtoupper($request->get('anamnesis_habito'));
        $paciente->anamnesis->anamnesis_afamiliar =strtoupper($request->get('anamnesis_afamiliar'));
        $paciente->anamnesis->anamnesis_embarazo =strtoupper($request->get('anamnesis_embarazo'));
        $paciente->anamnesis->anamnesis_coagulacion =strtoupper($request->get('anamnesis_coagulacion'));
        $paciente->anamnesis->anamnesis_panestesia =strtoupper($request->get('anamnesis_panestesia'));
        $paciente->anamnesis->anamnesis_otros =strtoupper($request->get('anamnesis_otros'));

        $paciente->anamnesis->save();

        return redirect('/paciente/'.$paciente_id.'/ver')->with(['creado'=>'La información fue actualizada','moduloactivo'=>'anamnesis']);
    }

    public function postGuardarImagen(Request $request,$paciente_id)
    {
        $paciente_id=$paciente_id;
        $imagen=$request->file('file12');
        $ruta='/img/';
        $nombre=sha1(Carbon::now()).".".$imagen->guessExtension();
        $imagen->move(getcwd().$ruta,$nombre);
        Imagen::create(
        [
            'imagen_desc'=>$request->get('imagen_desc'),
            'imagen_url'=>$ruta.$nombre,
            'paciente_id'=>$paciente_id,
            'album_id'=>'1',
        ]);

        return redirect('/paciente/'.$paciente_id.'/ver')->with(['creado'=>'La información fue actualizada','moduloactivo'=>'imagenes']);
    }

    public function getEliminarImagen(Request $request,$paciente_id,$imagen_id)
    {
        $imagen=Imagen::find($imagen_id);
        $rutaanterior=getcwd().$imagen->imagen_url;

        if(file_exists($rutaanterior)){
            unlink(realpath($rutaanterior));
        }
        $imagen->delete();

        return redirect('/paciente/'.$paciente_id.'/ver')->with(['creado'=>'La imagen fue eliminada','moduloactivo'=>'imagenes']);
    }

    public function postGuardarOdontograma(Request $request,$paciente_id,$odontograma_id)
    {
        $odontograma=Odontograma::find($odontograma_id);

        $odontograma->odontograma_observ=$request->get('odontograma_observ');
        $odontograma->odontograma_fecha=date("Y-m-d");
        $odontograma->save();

        return redirect('/paciente/'.$paciente_id.'/ver')->with(['creado'=>'La información fue actualizada','moduloactivo'=>'odontogramadiag']);
    }

    public function getNuevoOdontograma($paciente_id)
    {
        Odontograma::create
        (
            [
                'odontograma_fecha' => date("Y-m-d"),
                'odontograma_estado' =>'',
                'odontograma_titulo' =>'',
                'odontograma_observ' =>'',
                'paciente_id' => $paciente_id
            ]
        );

        return redirect('/paciente/'.$paciente_id.'/ver')->with(['creado'=>'Se adicionó un nuevo odontograma','moduloactivo'=>'odontogramadiag']);
    }

    public function getVerOdontogramaDet($paciente_id,$odontograma_id)
    {
        $usuario_id=Auth::user()->id;
        $pacientes=Paciente::where('usuario_id',$usuario_id)->where('paciente_id','<>','1')->get();
        $paciente=Paciente::find($paciente_id);
        $departamentos=Departamento::all();
        $imagenes=Imagen::where('paciente_id',$paciente_id)->get();

        $dtratamientos=array();
        if(Tratamiento::where('paciente_id',$paciente_id)->count()>0)
        {
            $tratamiento_id=Tratamiento::select('tratamiento_id')->where('paciente_id',$paciente_id)->orderby('tratamiento_fecha','desc')->get()[0];
            $tratamiento=Tratamiento::find($tratamiento_id);
            $dtratamientos=DTratamiento::where('tratamiento_id',$tratamiento_id)->get();
        }

        $odontogramas=Odontograma::where('paciente_id',$paciente_id)->orderby('odontograma_fecha','desc')->get();
        $odontograma=Odontograma::find($odontograma_id);

        $dodontogramas=DOdontograma::where('odontograma_id',$odontograma_id)->get();

        $superfPieza=array();

        foreach ($dodontogramas as $dodontograma) {
            $dodont=DOdontograma::find($dodontograma->dodontograma_id);
            array_push($superfPieza,array($dodont->superficie->superficie_codigo.$dodont->pieza->pieza_codigo,$dodont->diagnostico->diagnostico_desc));
        }

        $superfPieza=json_encode($superfPieza);
        return view('paciente.mostrarpaciente',['pacientes'=>$pacientes,'paciente'=>$paciente,'departamentos'=>$departamentos,'imagenes'=>$imagenes,'superfPieza'=>$superfPieza,'odontograma'=>$odontograma,'odontogramas'=>$odontogramas,'dtratamientos'=>$dtratamientos,'tratamiento'=>$tratamiento,'tratamiento_id'=>$tratamiento_id])->with(['creado'=>'La información fue actualizada','moduloactivo'=>'odontogramadiag']);
    }

    public function getVerOdontograma($paciente_id,$odontograma_id)
    {
        return redirect('/paciente/'.$paciente_id.'/verodontogramadet/'.$odontograma_id)->with(['moduloactivo'=>'odontogramadiag']);
    }

    public function getEliminarOdontograma($paciente_id,$odontograma_id)
    {
        $odontograma=Odontograma::find($odontograma_id);
        $odontograma->dodontogramas->each->delete();
        $odontograma->delete();

        $odontogramas=Odontograma::where('paciente_id',$paciente_id)->get();
        if(sizeof($odontogramas)==0)
        {
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
        }

        return redirect('/paciente/'.$paciente_id.'/ver')->with(['creado'=>'La información fue actualizada','moduloactivo'=>'odontogramadiag']);
    }

    public function setSuperficie(Request $request,$paciente_id,$coddiag,$codpieza,$codsuperf)
    {
        $odontograma=Odontograma::find($request->get('odontograma_id'));
        $pieza=Pieza::where('pieza_codigo',$codpieza)->get()[0];
        $superficie=Superficie::where('superficie_codigo',$codsuperf)->get()[0];
        $diagnostico=Diagnostico::where('diagnostico_desc',$coddiag)->get()[0];

        $dodontograma=DOdontograma::where('odontograma_id',$odontograma->odontograma_id)->where('pieza_id',$pieza->pieza_id)->where('superficie_id',$superficie->superficie_id)->get()->each->delete();

        if($coddiag!="sano")
        {
            $paciente=DOdontograma::create
            (
                [
                    'dodontograma_observ' => '',
                    'pieza_id' => $pieza->pieza_id,
                    'superficie_id' => $superficie->superficie_id,
                    'diagnostico_id' => $diagnostico->diagnostico_id,
                    'odontograma_id' => $odontograma->odontograma_id,
                ]
            );
        }

        return redirect('/paciente/'.$paciente_id.'/ver',['moduloactivo'=>'odontogramadiag'])->with('creado','La información fue actualizada');
    }

    public function setSuperficie2(Request $request)
    {
        $odontograma=Odontograma::find($request->get('odontograma_id'));
        $pieza=Pieza::where('pieza_codigo',$request->get('pieza'))->get()[0];
        $superficie=Superficie::where('superficie_codigo',$request->get('superficie'))->get()[0];
        $diagnostico=Diagnostico::where('diagnostico_desc',$request->get('diagnostico'))->get()[0];

        $dodontograma=DOdontograma::where('odontograma_id',$odontograma->odontograma_id)->where('pieza_id',$pieza->pieza_id)->where('superficie_id',$superficie->superficie_id)->get()->each->delete();

        if($request->get('diagnostico')!="sano")
        {
            $paciente=DOdontograma::create
            (
                [
                    'dodontograma_observ' => '',
                    'pieza_id' => $pieza->pieza_id,
                    'superficie_id' => $superficie->superficie_id,
                    'diagnostico_id' => $diagnostico->diagnostico_id,
                    'odontograma_id' => $odontograma->odontograma_id,
                ]
            );
        }

        return $odontograma;
    }

    public function setPieza(Request $request)
    {
        $odontograma=Odontograma::find($request->get('odontograma_id'));
        $pieza=Pieza::where('pieza_codigo',$request->get('pieza'))->get()[0];
        $diagnostico=Diagnostico::where('diagnostico_desc',$request->get('diagnostico'))->get()[0];

        if($request->get('diagnostico')!="sano")
        {
            $paciente=DOdontograma::create
            (
                [
                    'dodontograma_observ' => '',
                    'pieza_id' => $pieza->pieza_id,
                    'superficie_id' => '1',
                    'diagnostico_id' => $diagnostico->diagnostico_id,
                    'odontograma_id' => $odontograma->odontograma_id,
                ]
            );
        }

        else
        {

            $dodontograma=DOdontograma::where('odontograma_id',$odontograma->odontograma_id)->where('pieza_id',$pieza->pieza_id)->get()->each->delete();
        }

        return $odontograma;
    }

    public function getTratamientoPieza(Request $request,$paciente_id,$odontograma_id,$tratamiento_id,$pieza)
    {
        $odontograma=Odontograma::find($odontograma_id);
        $pieza_id=Pieza::where('pieza_codigo',$pieza)->get()[0]['pieza_id'];

        $odontograma_id=$odontograma_id;
        $tratamiento_id=$tratamiento_id;

        $dodontogramas=DOdontograma::where('odontograma_id',$odontograma_id)->where('pieza_id',$pieza_id)->get();



        if(sizeof($dodontogramas)==0)
        {
            DTratamiento::create
            (
                [
                    'dtratamiento_desc' => '',
                    'dtratamiento_subtotal' => '0',
                    'dtratamiento_descuento' => '0',
                    'dtratamiento_total' => '0',
                    'pieza_id' => $pieza_id,
                    'superficie_id' => '1',
                    'diagnostico_id' => '1',
                    'tratamiento_id' => $tratamiento_id
                ]
            );
        }

        foreach ($dodontogramas as $dodontograma) {

            $diagnostico=Diagnostico::find($dodontograma->diagnostico_id);
            
            DTratamiento::create
            (
                [
                    'dtratamiento_desc' => $diagnostico->diagnostico_desc,
                    'dtratamiento_subtotal' => '0',
                    'dtratamiento_descuento' => '0',
                    'dtratamiento_total' => '0',
                    'pieza_id' => $dodontograma->pieza_id,
                    'superficie_id' => $dodontograma->superficie_id,
                    'diagnostico_id' => $dodontograma->diagnostico_id,
                    'tratamiento_id' => $tratamiento_id
                ]
            );
        }

        $tratamiento=Tratamiento::find($tratamiento_id);

        $subtotal=0;$descuento=0;$total=0;

        foreach ($tratamiento->dtratamientos as $dtratamiento) {
            $subtotal+=$dtratamiento->dtratamiento_subtotal;
            $total+=$dtratamiento->dtratamiento_total;
            $descuento+=$dtratamiento->dtratamiento_descuento;
        }
        
        $tratamiento->tratamiento_subtotal=$subtotal;
        $tratamiento->tratamiento_total=$total;
        $tratamiento->tratamiento_descuento=$descuento;
        $tratamiento->save();

        return redirect('/paciente/'.$paciente_id.'/ver')->with(['moduloactivo'=>'odontogramatrat']);
    }

    public function getEliminarTratamientoPieza(Request $request,$paciente_id,$dtratamiento_id)
    {
        $dtratamiento=DTratamiento::find($dtratamiento_id);
        $tratamiento_id=$dtratamiento->tratamiento_id;

        $dtratamiento->delete();
        $subtotal=0;$descuento=0;$total=0;


        $tratamiento=Tratamiento::find($tratamiento_id);

        foreach ($tratamiento->dtratamientos as $dtratamiento) {
            $subtotal+=$dtratamiento->dtratamiento_subtotal;
            $total+=$dtratamiento->dtratamiento_total;
            $descuento+=$dtratamiento->dtratamiento_descuento;
        }
        
        $tratamiento->tratamiento_subtotal=$subtotal;
        $tratamiento->tratamiento_total=$total;
        $tratamiento->tratamiento_descuento=$descuento;
        $tratamiento->save();

        return redirect('/paciente/'.$paciente_id.'/ver')->with(['moduloactivo'=>'odontogramatrat']);
    }

    public function setPrecioDTratamiento($dtratamiento_id,$subtotal,$descuento)
    {
        $dtratamiento=DTratamiento::find($dtratamiento_id);
        $dtratamiento->dtratamiento_subtotal=floatval($subtotal);
        $dtratamiento->dtratamiento_descuento=floatval($descuento);
        $dtratamiento->dtratamiento_total=floatval($subtotal)-floatval($descuento);
        $dtratamiento->save();

        $tratamiento_id=$dtratamiento->tratamiento_id;

        $tratsubtotal=0;$tratdescuento=0;$trattotal=0;

        $tratamiento=Tratamiento::find($tratamiento_id);

        foreach ($tratamiento->dtratamientos as $dtrat) {
            $tratsubtotal+=$dtrat->dtratamiento_subtotal;
            $trattotal+=$dtrat->dtratamiento_total;
            $tratdescuento+=$dtrat->dtratamiento_descuento;
        }
        
        $tratamiento->tratamiento_subtotal=$tratsubtotal;
        $tratamiento->tratamiento_total=$trattotal;
        $tratamiento->tratamiento_descuento=$tratdescuento;
        $tratamiento->save();

        $res=array($tratsubtotal,$tratdescuento,$trattotal);

        return $res;
    }

    public function setDescDTratamiento($dtratamiento_id,Request $request)
    {
        $dtratamiento=DTratamiento::find($dtratamiento_id);
        $dtratamiento->dtratamiento_desc=$request->get('desc');
        $dtratamiento->save();

        return 0;
    }

    public function getNuevoTratamiento($paciente_id)
    {
        Tratamiento::create
        (
            [
                'tratamiento_fecha' => date("Y-m-d"),
                'tratamiento_estado' =>'',
                'tratamiento_titulo' =>'',
                'tratamiento_observ' =>'',
                'tratamiento_subtotal' =>'0',
                'tratamiento_descuento' =>'0',
                'tratamiento_total' =>'0',
                'paciente_id' => $paciente_id
            ]
        );

        return redirect('/paciente/'.$paciente_id.'/ver')->with(['creado'=>'Se adicionó un nuevo tratamiento','moduloactivo'=>'odontogramatrat']);
    }

    public function getEliminarTratamiento($paciente_id,$tratamiento_id)
    {
        $tratamiento=Tratamiento::find($tratamiento_id);
        Transaccion::where('tratamiento_id',$tratamiento_id)->delete();
        DTratamiento::where('tratamiento_id',$tratamiento_id)->delete();

        /*$tratamiento->dtratamientos->each->delete();
        $tratamiento->transacciones->each->delete();
        */
        $tratamiento->delete();

        $tratamientos=Tratamiento::where('paciente_id',$paciente_id)->get();
        if(sizeof($tratamientos)==0)
        {
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
                    'paciente_id' => $paciente_id
                ]
            );
        }

        return redirect('/paciente/'.$paciente_id.'/ver')->with(['creado'=>'Se eliminó el presupuesto correctamente','moduloactivo'=>'presupuestos']);
    }

    public function postCrearTransaccion(Request $request,$paciente_id)
    {
        $tratamiento_id=$request->get('tratamiento_id');
        Transaccion::create
        (
            [
                'transaccion_fecha' => $request->get('transaccion_fecha'),
                'transaccion_monto' => $request->get('transaccion_monto'),
                'tratamiento_id' => $request->get('tratamiento_id')
            ]
        );

        return redirect('/paciente/'.$paciente_id.'/ver')->with('creado','La información fue actualizada',['moduloactivo'=>'presupuestos']);
    }

    public function getVerPresupuesto($paciente_id)
    {
        return redirect('/paciente/'.$paciente_id.'/ver')->with(['moduloactivo'=>'presupuestos']);
    }

    public function postGuardarTratamiento(Request $request,$paciente_id,$tratamiento_id)
    {
        $tratamiento=Tratamiento::find($tratamiento_id);


        $tratamiento->tratamiento_titulo=($request->get('tratamiento_titulo')) ?$request->get('tratamiento_titulo'):'';
        $tratamiento->tratamiento_observ=$request->get('tratamiento_observ');
        $tratamiento->save();

        return redirect('/paciente/'.$paciente_id.'/ver')->with(['creado'=>'La información fue actualizada','moduloactivo'=>'odontogramatrat']);
    }

}
