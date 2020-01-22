@extends('layouts.appadmin')

@section('javascript')

<script type="text/javascript">
	var paciente_id=0;
	var fecha=0;
	var hora=0;

    function consultarDNI(e,ipt)
    {
        var tecla = (document.all) ? e.keyCode : e.which;
        if (tecla==13){
            var params = {
                "dni" : ipt.value
            };

            var request = $.ajax({
                url: '/agenda/consultadni',
                type: 'GET',
                data: params,
                contentType: 'application/json; charset=utf-8'
            });

            request.done(function(data) {
                $('#crearCitaModal #paciente_nombre').val(data[0]);
                $('#crearCitaModal #paciente_apellido').val(data[1]);
            });

            request.fail(function(jqXHR, textStatus) {
                alert(textStatus);
            });
        } 


    }

	function openModalCita(btn){
	    paciente_id = $(btn).attr( "paciente_id" );
	    $('#crearCitaModal #paciente_id').val($(btn).attr( "paciente_id"));
	    $('#crearCitaModal #paciente_nombre').val($(btn).attr( "paciente_nombre"));
	    $('#crearCitaModal #paciente_apellido').val($(btn).attr( "paciente_apellido"));
	    $('#crearCitaModal #paciente_dni').val($(btn).attr( "paciente_dni"));
	    $('#crearCitaModal #paciente_telefono').val($(btn).attr( "paciente_telefono"));
	    $('#crearCitaModal #paciente_direccion').val($(btn).attr( "paciente_direccion"));
	    $('#crearCitaModal #paciente_fechanac').val($(btn).attr( "paciente_fechanac"));
	    

	    $('#crearCitaModal #paciente_nombre').attr('readonly',true);
	    $('#crearCitaModal #paciente_apellido').attr('readonly',true);
	    $('#crearCitaModal #paciente_dni').attr('readonly',true);
	    $('#crearCitaModal #paciente_telefono').attr('readonly',true);
	    $('#crearCitaModal #paciente_direccion').attr('readonly',true);
	    $('#crearCitaModal #paciente_fechanac').attr('readonly',true);
	    $('#crearCitaModal #inlineRadio1').attr('disabled', true);
	    $('#crearCitaModal #inlineRadio2').attr('disabled', true);
	    $('#crearCitaModal #inlineRadio3').attr('disabled', true);

	    $('#crearCitaModal #inlineRadio1').attr('checked', false);
	    $('#crearCitaModal #inlineRadio2').attr('checked', false);
	    $('#crearCitaModal #inlineRadio3').attr('checked', false);

	    if($(btn).attr( "paciente_genero")=="F")
			$('#crearCitaModal #inlineRadio1').attr('checked', true);
		if($(btn).attr( "paciente_genero")=="M")
			$('#crearCitaModal #inlineRadio2').attr('checked', true);
		if($(btn).attr( "paciente_genero")=="SE")
			$('#crearCitaModal #inlineRadio3').attr('checked', true);

	    if(fecha!=0){
	    	$('#crearCitaModal #cita_fecha').val(fecha);
	    }
	    if(hora!=0){
	    	$('#crearCitaModal #cita_hora').val(hora);
	    }

	    $('#seleccionarPacienteModal').modal('hide'); 
	    $('#crearCitaModal').modal('show'); 
	}

	function openModalCitaNuevo(btn){
		paciente_id = 0;
	    $('#crearCitaModal #paciente_id').val("0");
	    $('#crearCitaModal #paciente_nombre').val("");
	    $('#crearCitaModal #paciente_apellido').val("");
	    $('#crearCitaModal #paciente_dni').val("");
	    $('#crearCitaModal #paciente_telefono').val("");
	    $('#crearCitaModal #paciente_direccion').val("");
	    $('#crearCitaModal #paciente_fechanac').val("");

	    $('#crearCitaModal #paciente_nombre').attr('readonly',false);
	    $('#crearCitaModal #paciente_apellido').attr('readonly',false);
	    $('#crearCitaModal #paciente_dni').attr('readonly',false);
	    $('#crearCitaModal #paciente_telefono').attr('readonly',false);
	    $('#crearCitaModal #paciente_direccion').attr('readonly',false);
	    $('#crearCitaModal #paciente_fechanac').attr('readonly',false);
	    $('#crearCitaModal #inlineRadio1').attr('disabled', false);
	    $('#crearCitaModal #inlineRadio2').attr('disabled', false);
	    $('#crearCitaModal #inlineRadio3').attr('disabled', false);

	    $('#crearCitaModal #inlineRadio1').attr('checked', false);
	    $('#crearCitaModal #inlineRadio2').attr('checked', false);
	    $('#crearCitaModal #inlineRadio3').attr('checked', false);

	    if(fecha!=0)
	    	$('#crearCitaModal #cita_fecha').val(fecha);
	    if(hora!=0)
	    	$('#crearCitaModal #cita_hora').val(hora);

	    //$('#paciente_genero').val(paciente_genero);
	    $('#seleccionarPacienteModal').modal('hide'); 
	    $('#crearCitaModal').modal('show'); 
	} 

	function getVerCita(consulta_id){
	    var request = $.ajax({
	        url: '/agenda/vercita',
	        type: 'GET',
	        data: { consulta_id: consulta_id} ,
	        contentType: 'application/json; charset=utf-8'
	    });

	    request.done(function(data) {

	        $('#verCitaModal #paciente_id').val(data[0].paciente_id);
		    $('#verCitaModal #paciente_nombre').val(data[0].paciente_nombre);
		    $('#verCitaModal #paciente_apellido').val(data[0].paciente_apellido);
		    $('#verCitaModal #paciente_dni').val(data[0].paciente_dni);
		    $('#verCitaModal #paciente_telefono').val(data[0].paciente_telefono);
		    $('#verCitaModal #paciente_direccion').val(data[0].paciente_direccion);
		    $('#verCitaModal #paciente_fechanac').val(data[0].paciente_fechanac);

		    if(data[0].paciente_genero=="F")
				$('#verCitaModal #inlineRadio1').attr('checked', true);
			if(data[0].paciente_genero=="M")
				$('#verCitaModal #inlineRadio2').attr('checked', true);
			if(data[0].paciente_genero=="SE")
				$('#verCitaModal #inlineRadio3').attr('checked', true);

			$('#verCitaModal #cita_fecha').val(data[0].cita_fecha);
			$('#verCitaModal #cita_hora').val(data[0].cita_hora);
			$('#verCitaModal #cita_duracion').val(data[0].cita_duracion);
			$('#verCitaModal #mconsulta_id').val(data[0].mconsulta_id);
			$('#verCitaModal #ecita_id').val(data[0].ecita_id);
			$('#verCitaModal #consulta_observ').val(data[0].consulta_observ);

			$('#verCitaModal #cita_id').val(data[0].cita_id);
			$('#verCitaModal #consulta_id').val(data[0].consulta_id);

	    });

	    request.fail(function(jqXHR, textStatus) {
	          alert(textStatus);
	    });
	    $('#verCitaModal').modal('show'); 

	}  

	$(document).ready(function() {
    setTimeout(function() {
        $(".alert").fadeOut(500);
    },5000);


});
</script>
@endsection
@section('content')
<div class="content">
   		@if (Session::has('creado'))
		    <div class="alert alert-success" role="alert">
		        {{Session::get('creado')}}
		    </div>
		@endif
		@if (Session::has('editado'))
		    <div class="alert alert-success" role="alert">
                {{Session::get('editado')}}
            </div>
		@endif
		@if (Session::has('error'))
		    <div class="alert alert-danger" role="alert">
		        {{Session::get('error')}}
		    </div>
		@endif
		@if (Session::has('eliminado'))
		    <div class="alert alert-success" role="alert">
		        {{Session::get('eliminado')}}
		    </div>
		@endif
        <!-- CONTENT -->
		
		 <div class="modal fade" id="seleccionarPacienteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">

                <div class="modal-content">
                    <div class="modal-header bg-blue-600 text-auto">
                        <h5 class="modal-title" id="exampleModalLabel"><strong>NUEVA CITA</strong></h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="description">
                                <div class="description-text">
                                    <hr>
                                    <div class="row">
                                    <div class="col-10">
	                                    <h6><strong>Seleccionar Paciente</strong></h6>
	                                </div>
	                                <div class="col-2">
	                                    <button type="button" id="nuevopaciente" class="btn btn-secondary" onclick="openModalCitaNuevo(this)">Nuevo</button>
	                                </div>
                                	</div>
                                    <hr>
                                </div>                                
                            </div>
                            <div class="row">
                            	<div class="col-12">
                                        <table id="sample-data-table" class="table">
                                            <thead>
                                                <tr>
                                                    <th class="secondary-text">
                                                        <div class="table-header">
                                                            <span class="column-title">Id</span>
                                                        </div>
                                                    </th>
                                                    <th class="secondary-text">
                                                        <div class="table-header">
                                                            <span class="column-title">Nombre</span>
                                                        </div>
                                                    </th>
                                                    <th class="secondary-text">
                                                        <div class="table-header">
                                                            <span class="column-title">Apellido</span>
                                                        </div>
                                                    </th>
                                                    <th class="secondary-text">
                                                        <div class="table-header">
                                                            <span class="column-title">DNI</span>
                                                        </div>
                                                    </th>
                                                    <th class="secondary-text">
                                                        <div class="table-header">
                                                            <span class="column-title">Acciones</span>
                                                        </div>
                                                    </th>

                                                </tr>
                                            </thead>
                                            @if(sizeof($pacientes)>0)
                                            <tbody>                  
                                                @foreach ($pacientes as $paciente)
                                                    <tr>
                                                        <td>{{$paciente->paciente_id}}</td>
                                                        <td>{{$paciente->paciente_nombre}}</td>
                                                        <td>{{$paciente->paciente_apellido}}</td>
                                                        <td>{{$paciente->paciente_dni}}</td>

                                                        <td>
                                                            <!--<button type="button" class="btn btn-light fuse-ripple-ready" data-toggle="modal" data-target="#editarModal"  cement_id="{{$paciente->paciente_id}}" onclick="setCementerioModal(this)"><i class="icon-lead-pencil" data-toggle="tooltip" data-placement="top" data-original-title="Editar"></i>
                                                            </button>-->
                                                            <button class="btn btn-light" paciente_id="{{$paciente->paciente_id}}" paciente_nombre="{{$paciente->paciente_nombre}}" paciente_apellido="{{$paciente->paciente_apellido}}" paciente_dni="{{$paciente->paciente_dni}}" paciente_telefono="{{$paciente->paciente_telefono}}" paciente_direccion="{{$paciente->paciente_direccion}}" paciente_genero="{{$paciente->paciente_genero}}" onclick="openModalCita(this)" data-original-title="Seleccionar"><i class="icon-send"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <div class="alert alert-danger" role="alert">
                                                    No tiene pacientes creados
                                                </div>
                                            @endif
                                            </tbody>
                                        </table>
                                        <script type="text/javascript">
                                            $('#sample-data-table').DataTable({
                                            responsive: true
                                            });
                                        </script>  
                                </div>                    
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="crearCitaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">

                <div class="modal-content">
                    <div class="modal-header bg-blue-600 text-auto">
                        <h5 class="modal-title" id="exampleModalLabel"><strong>NUEVA CITA</strong></h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" class="container" action="/agenda/crearcita">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="paciente_id" id="paciente_id" value="0"/>

                            <div class="description">
                                <div class="description-text">
                                    <hr>
                                    <h6><strong>Detalle Cita</strong></h6>
                                    <hr>
                                </div>                                
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3 mb-5">
                                        <label for="cita_fecha" class="form-control-label">Fecha</label>
                                        <input type="date" class="form-control" aria-describedby="width" id="cita_fecha" name="cita_fecha" required="required" />
                                </div>
                                <div class="col-md-3 mb-5">
                                        <label for="cita_hora" class="form-control-label">Hora</label>
                                        <input type="time" class="form-control" aria-describedby="width" id="cita_hora" name="cita_hora" required="required"/>
                                </div>
                                <div class="col-md-3 mb-5">
                                    <label for="cita_duracion" class="form-control-label">Duración(min)</label>
                                    <input type="number" class="form-control" aria-describedby="width" id="cita_duracion" name="cita_duracion" value="0" />
                                </div>
                                <div class="col-md-3 mb-5">
                                    <label for="ecita_id" class="form-control-label">Estado de Consulta</label>
                                        <select class="form-control" aria-describedby="width"  id="ecita_id" name="ecita_id">
                                           @foreach ($ecitas as $ecita)
                                                <option  value='{{$ecita->ecita_id}}'>{{$ecita->ecita_desc}}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                            <br>
                            <div class="description">
                                <div class="description-text">
                                    <hr>
                                    <h6><strong>Detalle Consulta</strong></h6>
                                    <hr>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-5">
                                    <label for="paciente_dni" class="form-control-label">DNI</label>
                                    <input type="text" class="form-control" aria-describedby="width" id="paciente_dni" name="paciente_dni" required="required" onkeypress="consultarDNI(event,this);" />
                                </div>    
                                <div class="col-md-3 mb-5">
                                    <label for="paciente_nombre" class="form-control-label">Nombres</label>
                                    <input type="text" class="form-control" aria-describedby="width" id="paciente_nombre" name="paciente_nombre"
                                     required="required" />
                                </div>
                                <div class="col-md-3 mb-5">
                                    <label for="paciente_apellido" class="form-control-label">Apellidos</label>
                                    <input type="text" class="form-control" aria-describedby="width" id="paciente_apellido" name="paciente_apellido" required="required" />
                                </div>
                                <div class="col-md-3 mb-5">
                                    <label for="paciente_fechanac" class="form-control-label">Fecha Nac.</label>
                                    <input type="date" class="form-control" aria-describedby="width" id="paciente_fechanac" name="paciente_fechanac" required="required" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-5">
                                    <label for="paciente_telefono" class="form-control-label">Teléfono</label>
                                    <input type="text" class="form-control" aria-describedby="width" id="paciente_telefono" name="paciente_telefono" required="required"/>
                                </div>
                                <div class="col-md-5 mb-5">
                                    <label for="paciente_direccion" class="form-control-label">Dirección</label>
                                    <input type="text" class="form-control" aria-describedby="width" id="paciente_direccion" name="paciente_direccion" />
                                </div>
                                <div class="col-md-3 mb-5">
                                        <label class="form-control-label">Género</label>
                                        <div class="form-inline">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="paciente_genero" id="inlineRadio1" value="F" />
                                                <span class="radio-icon"></span>
                                                <span class="form-check-description">F</span>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="paciente_genero" id="inlineRadio2" value="M" />
                                                <span class="radio-icon"></span>
                                                <span class="form-check-description">M</span>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="paciente_genero" id="inlineRadio3" value="SE" />
                                                <span class="radio-icon"></span>
                                                <span class="form-check-description">SE</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>                               
                            </div>


                            <div class="row">
                                <div class="col-md-5 mb-5">
                                    <label for="mconsulta_id" class="form-control-label">Motivo Consulta</label>
                                        <select class="form-control" aria-describedby="width"  id="mconsulta_id" name="mconsulta_id">
                                           @foreach ($mconsultas as $mconsulta)
                                                <option  value='{{$mconsulta->mconsulta_id}}'>{{$mconsulta->mconsulta_desc}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="col-md-7 mb-5">
                                    <label for="consulta_observ" class="form-control-label">Observaciones</label>
                                    <textarea class="form-control" aria-describedby="width" rows="1" id="consulta_observ" name="consulta_observ"></textarea>
                                </div>
                               	
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary">Crear</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="verCitaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">

                <div class="modal-content">
                    <div class="modal-header bg-blue-600 text-auto">
                        <h5 class="modal-title" id="exampleModalLabel"><strong>EDITAR CITA</strong></h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" class="container" action="/agenda/editarcita">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="paciente_id" id="paciente_id" value="0"/>
                            <input type="hidden" name="cita_id" id="cita_id" value=""/>
                            <input type="hidden" name="consulta_id" id="consulta_id" value=""/>
                            <div class="description">
                                <div class="description-text">
                                    <hr>
                                    <h6><strong>Paciente</strong></h6>
                                    <hr>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-5">
                                    <label for="paciente_dni" class="form-control-label">DNI</label>
                                    <input type="text" class="form-control" aria-describedby="width" id="paciente_dni" name="paciente_dni" required="required" readonly="" />
                                </div>    
                                <div class="col-md-3 mb-5">
                                    <label for="paciente_nombre" class="form-control-label">Nombres</label>
                                    <input type="text" class="form-control" aria-describedby="width" id="paciente_nombre" name="paciente_nombre"
                                     required="required" readonly=""/>
                                </div>
                                <div class="col-md-3 mb-5">
                                    <label for="paciente_apellido" class="form-control-label">Apellidos</label>
                                    <input type="text" class="form-control" aria-describedby="width" id="paciente_apellido" name="paciente_apellido" required="required" readonly=""/>
                                </div>
                                <div class="col-md-3 mb-5">
                                    <label for="paciente_fechanac" class="form-control-label">Fecha Nac.</label>
                                    <input type="date" class="form-control" aria-describedby="width" id="paciente_fechanac" name="paciente_fechanac" required="required" readonly=""/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-5">
                                    <label for="paciente_telefono" class="form-control-label">Teléfono</label>
                                    <input type="text" class="form-control" aria-describedby="width" id="paciente_telefono" name="paciente_telefono" required="required" readonly=""/>
                                </div>
                                <div class="col-md-5 mb-5">
                                    <label for="paciente_direccion" class="form-control-label">Dirección</label>
                                    <input type="text" class="form-control" aria-describedby="width" id="paciente_direccion" name="paciente_direccion" readonly=""/>
                                </div>
                                <div class="col-md-3 mb-5">
                                        <label class="form-control-label">Género</label>
                                        <div class="form-inline">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="paciente_genero" id="inlineRadio1" value="F" disabled="" />
                                                <span class="radio-icon"></span>
                                                <span class="form-check-description">F</span>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="paciente_genero" id="inlineRadio2" value="M" disabled=""/>
                                                <span class="radio-icon"></span>
                                                <span class="form-check-description">M</span>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="paciente_genero" id="inlineRadio3" value="SE" disabled=""/>
                                                <span class="radio-icon"></span>
                                                <span class="form-check-description">SE</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>                               
                            </div>

                            <div class="description">
                                <div class="description-text">
                                    <hr>
                                    <h6><strong>Consulta</strong></h6>
                                    <hr>
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="col-md-4  mb-5">
                                        <label for="cita_fecha" class="form-control-label">Fecha</label>
                                        <input type="date" class="form-control" aria-describedby="width" id="cita_fecha" name="cita_fecha" required="required" />
                                </div>
                                <div class="col-md-4  mb-5">
                                        <label for="cita_hora" class="form-control-label">Hora</label>
                                        <input type="time" class="form-control" aria-describedby="width" id="cita_hora" name="cita_hora" required="required"/>
                                </div>
                                <div class="col-md-4  mb-5">
                                    <label for="cita_duracion" class="form-control-label">Duración(min)</label>
                                    <input type="number" class="form-control" aria-describedby="width" id="cita_duracion" name="cita_duracion" value="0" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-5">
                                    <label for="mconsulta_id" class="form-control-label">Motivo Consulta</label>
                                        <select class="form-control" aria-describedby="width"  id="mconsulta_id" name="mconsulta_id">
                                           @foreach ($mconsultas as $mconsulta)
                                                <option  value='{{$mconsulta->mconsulta_id}}'>{{$mconsulta->mconsulta_desc}}</option>
                                            @endforeach
                                        </select>
                                </div>
                               	<div class="col-md-6 mb-5">
                                    <label for="ecita_id" class="form-control-label">Estado de Consulta</label>
                                        <select class="form-control" aria-describedby="width"  id="ecita_id" name="ecita_id">
                                           @foreach ($ecitas as $ecita)
                                                <option  value='{{$ecita->ecita_id}}'>{{$ecita->ecita_desc}}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-5">
                                    <label for="consulta_observ" class="form-control-label">Observaciones</label>
                                    <textarea class="form-control" aria-describedby="width" id="consulta_observ" name="consulta_observ"></textarea>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary">Editar</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="calendar" class="page-layout simple full-width">

	        <!-- HEADER -->
	        <div class="page-header bg-secondary text-auto p-6">

	            <!-- HEADER CONTENT-->
	            <div class="header-content d-flex flex-column justify-content-between">

	                <!-- HEADER TOP -->
	                <div class="header-top row no-gutters align-items-center  justify-content-center justify-content-sm-between">

	                    <div class="logo row align-items-center no-gutters mb-4 mb-sm-0">
	                        <i class="logo-icon icon-calendar-today mr-4"></i>
	                        <span class="logo-text h4">Calendar</span>
	                    </div>

	                    <!-- TOOLBAR -->
	                    <div class="toolbar row no-gutters align-items-center">

	                        <button type="button" class="btn btn-icon" aria-label="Search">
	                            <i class="icon icon-magnify"></i>
	                        </button>

	                        <button id="calendar-today-button" type="button" class="btn btn-icon" aria-label="Today">
	                            <i class="icon icon-calendar-today"></i>
	                        </button>

	                        <button type="button" class="btn btn-icon change-view" data-view="agendaDay" aria-label="Day">
	                            <i class="icon icon-view-day"></i>
	                        </button>

	                        <button type="button" class="btn btn-icon change-view" data-view="agendaWeek" aria-label="Week">
	                            <i class="icon icon-view-week"></i>
	                        </button>

	                        <button type="button" class="btn btn-icon change-view" data-view="month" aria-label="Month">
	                            <i class="icon icon-view-module"></i>
	                        </button>
	                    </div>

	                    <!-- / TOOLBAR -->
	                </div>
	                <!-- / HEADER TOP -->

	                <!-- HEADER BOTTOM -->
	                <div class="header-bottom row align-items-center justify-content-center">

	                    <button id="calendar-previous-button" type="button" class="btn btn-icon" aria-label="Previous">
	                        <i class="icon icon-chevron-left"></i>
	                    </button>

	                    <div id="calendar-view-title" class="h5">
	                        Calendar title
	                    </div>

	                    <button id="calendar-next-button" type="button" class="btn btn-icon" aria-label="Next">
	                        <i class="icon icon-chevron-right"></i>
	                    </button>
	                </div>
	                <!-- / HEADER BOTTOM -->
	            </div>
	            <!-- / HEADER CONTENT -->

	            <!-- ADD EVENT BUTTON -->
	            <button id="add-event-button" type="button" class="btn btn-danger btn-fab" aria-label="Add event" data-toggle="modal" data-target="#seleccionarPacienteModal" data-whatever="@getbootstrap">
	                <i class="icon icon-plus"></i>
	            </button>
	            <!-- / ADD EVENT BUTTON -->

	        </div>
	        <!-- / HEADER -->

	        <!-- CONTENT -->
	        <div class="page-content p-6">
	            <div id="calendar-view"></div>
	        </div>
	        <!-- / CONTENT -->
	    </div>

	    <link type="text/css" rel="stylesheet" href="../assets/vendor/fullcalendar/dist/fullcalendar.min.css" />
	    <link type="text/css" rel="stylesheet" href="../assets/vendor/fullcalendar/dist/fullcalendar.print.min.css" media="print" />
		
	    <script type="text/javascript" src="../assets/vendor/moment/min/moment.min.js"></script>
	    <script type="text/javascript" src="../assets/vendor/fullcalendar/dist/fullcalendar.min.js"></script>

        <script type="text/javascript">

        var calendarView,
        calendar,
        currentMonthShort;

	    // Data

    	var citas='{{$citas}}';
    	citas= citas.replace(/&quot;/g,'"');
    	citas= JSON.parse(citas);

    	var colorcita=['#F4D03F','#27AE60','#E74C3C','#3498DB'];
		var events = [];
    	
    	for(var i = 0; i< citas.length ; i++)
	    {
	    	var date = citas[i]['cita_fecha'];
	    	var y = parseInt(date.substring(0,4));
		    var m = parseInt(date.substring(5,7));
		    var d = parseInt(date.substring(8,10));

		    var hora = citas[i]['cita_hora'];
		    var h = parseInt(hora.substring(0,2));
		    var mi = parseInt(hora.substring(3,5));

	    	events.push({
	            id   : citas[i]['consulta_id'],
	            title: citas[i]['paciente_nombre'],
	            start: new Date(y, m-1, d,h,mi),
	            end  : null,
	          	color: colorcita[parseInt(citas[i]['ecita_id'])-1]
	        });
	    }

	    

	    

    	$(document).ready(function(){
    		$('#calendar-view').fullCalendar({
		        events            : events,
		        monthNames        : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		        monthNamesShort   : ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		        dayNames          : ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
		        dayNamesShort     : ['Dom','Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
		        editable          : true,
		        eventLimit        : true,
		        header            : '',
		        handleWindowResize: false,
		        aspectRatio       : 1,
		        viewRender        : function (view)
		        {
		            console.log(view);
		            calendarView = view;
		            calendar = view.calendar;

		            $('#calendar-view-title').text(view.title);

		            $('#calendar > .page-header').removeClass(currentMonthShort);
		            currentMonthShort = calendar.getDate().format('MMM');
		            $('#calendar > .page-header').addClass(currentMonthShort);

		        },
		        // columnFormat      : {
		        //     month: 'ddd',
		        //     week : 'ddd D',
		        //     day  : 'ddd M'
		        // },
		        eventClick        : eventClick,
		        selectable        : true,
		        selectHelper      : true,
		        dayClick          : dayClick
		    });
    	})

        function eventClick(calEvent, jsEvent, view)
        {
	        getVerCita(calEvent.id);
	        // alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
	        // alert('View: ' + view.name);

	        // change the border color just for fun
	        // $(this).css('border-color', 'red');
	    }

	    function dayClick(date, jsEvent, view)
	    {
	    	fecha=date.format('Y-MM-DD');
	    	hora=date.format('hh:mm:ss');
	    	$('#seleccionarPacienteModal').modal('show'); 
	    }

	    $('#calendar-next-button').click(function ()
	    {
	        calendar.next();
	    });

	    $('#calendar-previous-button').click(function ()
	    {
	        calendar.prev();
	    });


	    $('#calendar-today-button').click(function ()
	    {
	        calendar.today();
	    });

	    $('#calendar .page-header .change-view').click(function ()
	    {
	        calendar.changeView($(this).data('view'));
	    });

    </script>

    </div>
</div>


@endsection
