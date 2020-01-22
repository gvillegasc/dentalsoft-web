@extends('layouts.appadmin')
@section('javascript')
<script type="text/javascript">


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
            $('#crearModal #paciente_nombre').val(data[0]);
            $('#crearModal #paciente_apellido').val(data[1]);
        });

        request.fail(function(jqXHR, textStatus) {
            alert(textStatus);
        });
    } 


}

</script>
@endsection

@section('content')
<div class="content">
    <div class="doc data-table-doc page-layout simple full-width">

        <!-- HEADER -->
        <div class="page-header text-auto p-6 row no-gutters align-items-center justify-content-between" style="background-color: #125285; color: white;">
            <h2 class="doc-title" id="content">PACIENTES</h2>
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#crearModal" data-whatever="@getbootstrap">Crear Paciente
                </button>

        </div>
         
        <div class="modal fade" id="crearModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-blue-600 text-auto">
                        <h5 class="modal-title" id="exampleModalLabel"><strong>NUEVO PACIENTE</strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="/paciente/crear">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="description">
                                <div class="description-text">
                                    <hr>
                                    <h6><strong>Datos Personales</strong></h6>
                                    <hr>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="paciente_dni" class="form-control-label">DNI</label>
                                        <input type="text" class="form-control" aria-describedby="width" id="paciente_dni" name="paciente_dni" required="required" onkeypress="consultarDNI(event,this);" />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="paciente_nombre" class="form-control-label">Nombres</label>
                                        <input type="text" class="form-control" aria-describedby="width" id="paciente_nombre" name="paciente_nombre"
                                         required="required" />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="paciente_apellido" class="form-control-label">Apellidos</label>
                                        <input type="text" class="form-control" aria-describedby="width" id="paciente_apellido" name="paciente_apellido" required="required" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="paciente_telefono" class="form-control-label">Teléfono</label>
                                        <input type="text" class="form-control" aria-describedby="width" id="paciente_telefono" name="paciente_telefono" required="required"/>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="paciente_correo" class="form-control-label">Correo</label>
                                        <input type="text" class="form-control" aria-describedby="width" id="paciente_correo" name="paciente_correo"
                                         />
                                    </div>
                                </div>

                                <div class="col-4">

                                    <div class="form-group">
                                        <label for="paciente_fechanac" class="form-control-label">Fecha de Nacimiento</label>
                                        <input class="form-control" type="date" aria-describedby="width" id="paciente_fechanac" name="paciente_fechanac" required="required" />
                                    </div>

                                </div>
                                
                            </div>
                            
                            <div class="row">

                                <div class="col-3">

                                    <div class="form-group">
                                        <label for="departamento_id" class="form-control-label">Ciudad</label>                                     
                                        <select class="form-control" aria-describedby="width"  id="departamento_id" name="departamento_id">
                                           @foreach ($departamentos as $departamento)
                                                <option  value='{{$departamento->departamento_id}}'>{{$departamento->departamento_desc}}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>

                                </div>

                                <div class="col-3">

                                    <div class="form-group">
                                        <label for="paciente_direccion" class="form-control-label">Dirección</label>
                                        <input type="text" class="form-control" aria-describedby="width" id="paciente_direccion" name="paciente_direccion" />
                                    </div>

                                </div>

                                <div class="col-3">

                                    <div class="form-group">
                                        <label for="paciente_ocupacion" class="form-control-label">Ocupación</label>
                                        <input type="text" class="form-control" aria-describedby="width" id="paciente_ocupacion" name="paciente_ocupacion" />     
                                    </div>

                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Género</label>
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
                                        <div class="form-check form-check-inline disabled">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="paciente_genero" id="inlineRadio3" value="SE" disabled="" />
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
                                    <h6><strong>Contacto Adicional</strong></h6>
                                    <hr>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="cadicional_nombre" class="form-control-label">Nombre</label>
                                        <input type="text" class="form-control" aria-describedby="width" id="cadicional_nombre" name="cadicional_nombre" />   
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="cadicional_parentesco" class="form-control-label">Parentesco</label>
                                        <input type="text" class="form-control" aria-describedby="width" id="cadicional_parentesco" name="cadicional_parentesco" />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="cadicional_telefono" class="form-control-label">Teléfono</label>
                                        <input type="text" class="form-control" aria-describedby="width" id="cadicional_telefono" name="cadicional_telefono" />
                                    </div>
                                </div>
                            </div>

                            <div class="description">
                                <div class="description-text">
                                    <hr>
                                    <h6><strong>Responsable Pago</strong></h6>
                                    <hr>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="rpago_nombre" class="form-control-label">Nombre</label>                                        
                                        <input type="text" class="form-control" aria-describedby="width" id="rpago_nombre" name="rpago_nombre" />
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="rpago_nota" class="form-control-label">Notas Paciente</label>
                                        <input type="text" class="form-control" aria-describedby="width" id="rpago_nota" name="rpago_nota" />
                                    </div>
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
        <div class="page-content p-6">
            <div class="content container">
                <div class="row">
                    <div class="col-12">
                        <div class="example ">
                            <div class="source-preview-wrapper">
                                <div class="preview">
                                    <div class="preview-elements">
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
                                                            <span class="column-title">Teléfono</span>
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
                                                        <td>{{$paciente->paciente_telefono}}</td>

                                                        <td>
                                                            <!--<button type="button" class="btn btn-light fuse-ripple-ready" data-toggle="modal" data-target="#editarModal"  cement_id="{{$paciente->paciente_id}}" onclick="setCementerioModal(this)"><i class="icon-lead-pencil" data-toggle="tooltip" data-placement="top" data-original-title="Editar"></i>
                                                            </button>-->
                                                                <a href="/paciente/{{$paciente->paciente_id}}/ver" class="btn btn-light fuse-ripple-ready" data-original-title="Ver Detalles"><i class="icon-format-list-bulleted"></i></a>
                                                                <a href="/paciente/{{$paciente->paciente_id}}/verpresupuesto" class="btn btn-light fuse-ripple-ready" data-original-title="Ver Presupuesto"><i class="icon-parking"></i></a>
                                                                <a href="/paciente/{{$paciente->paciente_id}}/eliminar" class="btn btn-light fuse-ripple-ready" data-original-title="Eliminar" onclick="return confirm('Está seguro que desea eliminar?');"><i class="icon-delete"></i></a>
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
            </div>
        </div>
                        <!-- CONTENT -->
    </div>
</div>

@endsection