@extends('layouts.appadmin')
@section('javascript')

<script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"></script>


<script type="text/javascript">

function setCementerioModal(btn){
    var cement_id = $(btn).attr( "cement_id" )

    var request = $.ajax({
        url: '/admin/cementerio/editar',
        type: 'GET',
        data: { cement_id: cement_id} ,
        contentType: 'application/json; charset=utf-8'
    });

    request.done(function(data) {
        $('#cement_id_editar').val(data.cement_id);
        $('#cement_nom_editar').val(data.cement_nom);

    });

    request.fail(function(jqXHR, textStatus) {
          alert(textStatus);
    });

}


function imprimirElemento(elemento){
  var ventana = window.open('', 'PRINT', 'height=400,width=600');
  ventana.document.write('<html><head><title>' + document.title + '</title>');
  ventana.document.write('</head><body >');
  ventana.document.write(elemento.innerHTML);
  ventana.document.write('</body></html>');
  ventana.document.close();
  ventana.focus();
  ventana.print();
  ventana.close();
  return true;
}

function cambio(dtrat_id){
    
    var subtotal = document.getElementById('subtotal'+dtrat_id).value;
    var descuento = document.getElementById('descuento'+dtrat_id).value;

    var request = $.ajax({
        url: '/paciente/setPrecioDTratamiento/'+dtrat_id+'/'+subtotal+'/'+descuento,
        type: 'GET',
        contentType: 'application/json; charset=utf-8'
    });

    request.done(function(data) {
        document.getElementById('tratsubtotal').value=data[0].toFixed(2);
        document.getElementById('tratdescuento').value=data[1].toFixed(2);
        document.getElementById('trattotal').value=data[2].toFixed(2);
    });

    request.fail(function(jqXHR, textStatus) {
        alert(textStatus);
    });

    document.getElementById('total'+dtrat_id).value=parseFloat(document.getElementById('subtotal'+dtrat_id).value)-parseFloat(document.getElementById('descuento'+dtrat_id).value);

}

function cambiodesc(dtrat_id){
    
    var desc = document.getElementById('desc'+dtrat_id).value;

    var request = $.ajax({
        url: '/paciente/setDescDTratamiento/'+dtrat_id,
        type: 'GET',
        data: { desc: desc } ,
        contentType: 'application/json; charset=utf-8'
    });

    request.done(function(data) {
        document.getElementById('desc'+dtrat_id).value=desc;
    });

    request.fail(function(jqXHR, textStatus) {
        alert(textStatus);
    });
}  

function setSuperficieOdontograma(diagdesc,piezacod,superfcod){
    var params = {
        "superficie" : superfcod,
        "diagnostico" : diagdesc,
        "pieza" : piezacod,
        "odontograma_id" : '{{$odontograma->odontograma_id}}',
        "paciente_id" : '{{$paciente->paciente_id}}'
    };

    var request = $.ajax({
        url: '/paciente/setSuperficie',
        type: 'GET',
        data: params,
        contentType: 'application/json; charset=utf-8'
    });

    request.done(function(data) {
    });

    request.fail(function(jqXHR, textStatus) {
        alert(textStatus);
    });

}

function setPieza(diagdesc,piezacod){
    var params = {
        "diagnostico" : diagdesc,
        "pieza" : piezacod,        
        "odontograma_id" : '{{$odontograma->odontograma_id}}',
        "paciente_id" : '{{$paciente->paciente_id}}'
    };

    var request = $.ajax({
        url: '/paciente/setPieza',
        type: 'GET',
        data: params,
        contentType: 'application/json; charset=utf-8'
    });

    request.done(function(data) {
    });

    request.fail(function(jqXHR, textStatus) {
        alert(textStatus);
    });

}  


var colores={'sano' : '#fff', 'caries' : '#E74C3C', 'sellante' : '#33FF3E', 'amalgama' : '#33FAFF', 'composite' : '#2980B9', 'incrustacion' : '#F4D03F', 'fractura' : '#37883B', 'surco' : '#A569BD'};

$(document).ready(function(){
  $('body #odontograma_anamnesis').on('click', 'span', function(){
    var tratamiento = document.getElementsByName('tratamiento');
    for (var i = 0; i < tratamiento.length; i++) {    
        if (tratamiento[i].checked) {
            if(i<=7)
            {
                document.getElementById($(this).attr('id')).style.background=colores[(tratamiento[i].value)];
                document.getElementById('tra'+$(this).attr('id')).style.background=colores[(tratamiento[i].value)];
                setSuperficieOdontograma(tratamiento[i].value,($(this).attr('id')).substring(1),($(this).attr('id')).substring(0,1));
                /*window.location.href='/paciente/setSuperficie/{{$paciente->paciente_id}}/'+tratamiento[i].value+'/'+($(this).attr('id')).substring(1)+'/'+($(this).attr('id')).substring(0,1);*/
            }
        }
    }
  });
});

//piezas odontograma dibujar

$(document).ready(function(){
    var superfPieza = '{{$superfPieza}}';
    superfPieza= superfPieza.replace(/&quot;/g,'"');
    superfPieza = JSON.parse(superfPieza);
    for (var i = 0; i < superfPieza.length; i++) {
        var pieza = superfPieza[i][0];
        var nropieza = pieza.substring(1);
        var diagnostico = superfPieza[i][1];
        
        if(pieza.substring(0,1)!='n')
        {
            document.getElementById(pieza).style.background=colores[(diagnostico)];
        }
        else
        {
            pieza='t'+nropieza;
            if (diagnostico=="endodoncia") {

                if(parseInt(nropieza)<50)
                {
                    document.getElementById(pieza).innerHTML += '<img src="/img/dientes/endodoncia/e_d'+nropieza+'.png" class="endodoncia" alt="">';
                }
                else
                {
                    document.getElementById(pieza).innerHTML += '<img src="/img/dientes/endodoncia.png" class="endodoncia" alt="">';
                }
            }
            if (diagnostico=="ausente") {
                document.getElementById(pieza).innerHTML = '<img src="/img/dientes/d'+nropieza+'.png" class="relative">';
                $('#'+pieza).addClass("ausente");
            }
            if (diagnostico=="extraccion") {
                document.getElementById(pieza).innerHTML += '<img src="/img/dientes/cross.png" class="cross" alt="">';
            }
            if (diagnostico=="coronada") {
                if(parseInt(nropieza)<50)
                {
                    document.getElementById(pieza).innerHTML += '<img src="/img/dientes/corona/c_d'+nropieza+'.png" class="corona_sup" alt="">';
                }
                else
                {
                    if(parseInt(nropieza)<70)
                    {
                        document.getElementById(pieza).innerHTML += '<img src="/img/dientes/corona.png" class="corona_sup" alt="">';
                    }
                    else
                    {
                        document.getElementById(pieza).innerHTML += '<img src="/img/dientes/corona.png" class="corona_inf" alt="">';
                    }
                }
            }
            if (diagnostico=="implante") {
                if(parseInt(nropieza)<30)
                {
                    document.getElementById(pieza).innerHTML += '<img src="/img/dientes/implante/i_d'+nropieza+'.png" class="implante_sup" alt="">';
                }
                else
                {
                    if(parseInt(nropieza)<50)
                    {
                        document.getElementById(pieza).innerHTML += '<img src="/img/dientes/implante/i_d'+nropieza+'.png" class="implante_inf" alt="">';
                    }
                    else
                    {
                    }
                }
            }
            if (diagnostico=="lcnc") {
                if(parseInt(nropieza)<50)
                {
                    document.getElementById(pieza).innerHTML += '<img src="/img/dientes/lcnc/lc_d'+nropieza+'.png" class="lcnc" alt="">';
                }
                else
                {
                }
            }
        }
    }

});

//piezas tratamiento dibujar

$(document).ready(function(){
    var superfPieza = '{{$superfPieza}}';
    superfPieza= superfPieza.replace(/&quot;/g,'"');
    superfPieza = JSON.parse(superfPieza);
    for (var i = 0; i < superfPieza.length; i++) {
        var pieza = superfPieza[i][0];
        var nropieza = pieza.substring(1);
        var diagnostico = superfPieza[i][1];
        
        if(pieza.substring(0,1)!='n')
        {
            document.getElementById('tra'+pieza).style.background=colores[(diagnostico)];
        }
        else
        {
            pieza='t'+nropieza;
            if (diagnostico=="endodoncia") {

                if(parseInt(nropieza)<50)
                {
                    document.getElementById('tra'+pieza).innerHTML += '<img src="/img/dientes/endodoncia/e_d'+nropieza+'.png" class="endodoncia" alt="">';
                }
                else
                {
                    document.getElementById('tra'+pieza).innerHTML += '<img src="/img/dientes/endodoncia.png" class="endodoncia" alt="">';
                }
            }
            if (diagnostico=="ausente") {
                document.getElementById('tra'+pieza).innerHTML = '<img src="/img/dientes/d'+nropieza+'.png" class="relative">';
                $('#tra'+pieza).addClass("ausente");
            }
            if (diagnostico=="extraccion") {
                document.getElementById('tra'+pieza).innerHTML += '<img src="/img/dientes/cross.png" class="cross" alt="">';
            }
            if (diagnostico=="coronada") {
                if(parseInt(nropieza)<50)
                {
                    document.getElementById('tra'+pieza).innerHTML += '<img src="/img/dientes/corona/c_d'+nropieza+'.png" class="corona_sup" alt="">';
                }
                else
                {
                    if(parseInt(nropieza)<70)
                    {
                        document.getElementById('tra'+pieza).innerHTML += '<img src="/img/dientes/corona.png" class="corona_sup" alt="">';
                    }
                    else
                    {
                        document.getElementById('tra'+pieza).innerHTML += '<img src="/img/dientes/corona.png" class="corona_inf" alt="">';
                    }
                }
            }
            if (diagnostico=="implante") {
                if(parseInt(nropieza)<30)
                {
                    document.getElementById('tra'+pieza).innerHTML += '<img src="/img/dientes/implante/i_d'+nropieza+'.png" class="implante_sup" alt="">';
                }
                else
                {
                    if(parseInt(nropieza)<50)
                    {
                        document.getElementById('tra'+pieza).innerHTML += '<img src="/img/dientes/implante/i_d'+nropieza+'.png" class="implante_inf" alt="">';
                    }
                    else
                    {
                    }
                }
            }
            if (diagnostico=="lcnc") {
                if(parseInt(nropieza)<50)
                {
                    document.getElementById('tra'+pieza).innerHTML += '<img src="/img/dientes/lcnc/lc_d'+nropieza+'.png" class="lcnc" alt="">';
                }
                else
                {
                }
            }
        }
    }

});

$(document).ready(function(){
  $('body #odontograma_anamnesis_table').on('click', 'div', function(){
    var tratamiento = document.getElementsByName('tratamiento');
    var pieza = $(this).attr('id');
    var nropieza = pieza.substring(1);

    if (tratamiento[0].checked) {
        document.getElementById(pieza).innerHTML = '<img src="/img/dientes/d'+nropieza+'.png"class="relative">';
        document.getElementById('tra'+pieza).innerHTML = '<img src="/img/dientes/d'+nropieza+'.png"class="relative">';
        try{document.getElementById('v'+nropieza).style.background='#fff';}catch(e){}
        try{document.getElementById('d'+nropieza).style.background='#fff';}catch(e){}
        try{document.getElementById('o'+nropieza).style.background='#fff';}catch(e){}
        try{document.getElementById('m'+nropieza).style.background='#fff';}catch(e){}
        try{document.getElementById('p'+nropieza).style.background='#fff';}catch(e){}
        try{document.getElementById('i'+nropieza).style.background='#fff';}catch(e){}
        try{document.getElementById('l'+nropieza).style.background='#fff';}catch(e){}

        try{document.getElementById('trav'+nropieza).style.background='#fff';}catch(e){}
        try{document.getElementById('trad'+nropieza).style.background='#fff';}catch(e){}
        try{document.getElementById('trao'+nropieza).style.background='#fff';}catch(e){}
        try{document.getElementById('tram'+nropieza).style.background='#fff';}catch(e){}
        try{document.getElementById('trap'+nropieza).style.background='#fff';}catch(e){}
        try{document.getElementById('trai'+nropieza).style.background='#fff';}catch(e){}
        try{document.getElementById('tral'+nropieza).style.background='#fff';}catch(e){}

        setPieza(tratamiento[0].value,nropieza);

    }
    if (tratamiento[8].checked) {
        if(parseInt(nropieza)<50)
        {
            document.getElementById(pieza).innerHTML += '<img src="/img/dientes/endodoncia/e_d'+nropieza+'.png" class="endodoncia" alt="">';
            document.getElementById('tra'+pieza).innerHTML += '<img src="/img/dientes/endodoncia/e_d'+nropieza+'.png" class="endodoncia" alt="">';
        }
        else
        {
            document.getElementById(pieza).innerHTML += '<img src="/img/dientes/endodoncia.png" class="endodoncia" alt="">';
            document.getElementById('tra'+pieza).innerHTML += '<img src="/img/dientes/endodoncia.png" class="endodoncia" alt="">';
        }
        setPieza(tratamiento[8].value,nropieza);
    }
    if (tratamiento[9].checked) {
        document.getElementById(pieza).innerHTML = '<img src="/img/dientes/d'+nropieza+'.png" class="relative">';
        document.getElementById('tra'+pieza).innerHTML = '<img src="/img/dientes/d'+nropieza+'.png" class="relative">';
        $('#'+pieza).addClass("ausente");
        $('#tra'+pieza).addClass("ausente");
        setPieza(tratamiento[9].value,nropieza);
    }
    if (tratamiento[10].checked) {
        document.getElementById(pieza).innerHTML += '<img src="/img/dientes/cross.png" class="cross" alt="">';
        document.getElementById('tra'+pieza).innerHTML += '<img src="/img/dientes/cross.png" class="cross" alt="">';
        setPieza(tratamiento[10].value,nropieza);
    }
    if (tratamiento[11].checked) {
        if(parseInt(nropieza)<50)
        {
            document.getElementById(pieza).innerHTML += '<img src="/img/dientes/corona/c_d'+nropieza+'.png" class="corona_sup" alt="">';
            document.getElementById('tra'+pieza).innerHTML += '<img src="/img/dientes/corona/c_d'+nropieza+'.png" class="corona_sup" alt="">';
        }
        else
        {
            if(parseInt(nropieza)<70)
            {
                document.getElementById(pieza).innerHTML += '<img src="/img/dientes/corona.png" class="corona_sup" alt="">';
                document.getElementById('tra'+pieza).innerHTML += '<img src="/img/dientes/corona.png" class="corona_sup" alt="">';
            }
            else
            {
                document.getElementById(pieza).innerHTML += '<img src="/img/dientes/corona.png" class="corona_inf" alt="">';
                document.getElementById('tra'+pieza).innerHTML += '<img src="/img/dientes/corona.png" class="corona_inf" alt="">';
            }
        }
        setPieza(tratamiento[11].value,nropieza);
    }
    if (tratamiento[12].checked) {
        if(parseInt(nropieza)<30)
        {
            document.getElementById(pieza).innerHTML += '<img src="/img/dientes/implante/i_d'+nropieza+'.png" class="implante_sup" alt="">';
            document.getElementById('tra'+pieza).innerHTML += '<img src="/img/dientes/implante/i_d'+nropieza+'.png" class="implante_sup" alt="">';
            setPieza(tratamiento[12].value,nropieza);
        }
        else
        {
            if(parseInt(nropieza)<50)
            {
                document.getElementById(pieza).innerHTML += '<img src="/img/dientes/implante/i_d'+nropieza+'.png" class="implante_inf" alt="">';
                document.getElementById('tra'+pieza).innerHTML += '<img src="/img/dientes/implante/i_d'+nropieza+'.png" class="implante_inf" alt="">';
                setPieza(tratamiento[12].value,nropieza);
            }
            else
            {
                alert("no se puede");
            }
        }
    }
    if (tratamiento[13].checked) {
        if(parseInt(nropieza)<50)
        {
            document.getElementById(pieza).innerHTML += '<img src="/img/dientes/lcnc/lc_d'+nropieza+'.png" class="lcnc" alt="">';
            document.getElementById('tra'+pieza).innerHTML += '<img src="/img/dientes/lcnc/lc_d'+nropieza+'.png" class="lcnc" alt="">';
            setPieza(tratamiento[13].value,nropieza);
        }
        else
        {
            alert("no se puede");
        }
    }


  });
});

$(document).ready(function(){
  $('body #odontograma_tratamiento_table').on('click', 'div', function(){
    var tratamiento = '{{$tratamiento_id}}';
    var pieza = $(this).attr('id');
    var nropieza = pieza.substring(4);

    window.location.href='/paciente/getTratamientoPieza/{{$paciente->paciente_id}}/{{$odontograma->odontograma_id}}/{{$tratamiento_id}}/'+nropieza;
  });
});

function openModalPago(btn){
        $('#realizarpagoModal').modal('hide'); 
        tratamiento_id = $(btn).attr( "tratamiento_id" );
        $('#realizarpagoModal #transaccion_fecha').val('');
        $('#realizarpagoModal #transaccion_monto').val('');
        $('#realizarpagoModal #tratamiento_id').val($(btn).attr("tratamiento_id"));
 
        $('#realizarpagoModal').modal('show'); 
    }


$(document).ready(function(){
  $(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
    });
    
    $(".zoom").hover(function(){
        
        $(this).addClass('transition');
    }, function(){
        
        $(this).removeClass('transition');
    });
});

$(document).ready(function(){

    try{
    var moduloactivo="{{Session::get('moduloactivo')}}";
    }
    catch(e)
    {
    var moduloactivo="infoprinc";
    }
    $('#anamnesis-tab').removeClass("active");
    $('#odontogramadiag-tab').removeClass("active");
    $('#odontogramatrat-tab').removeClass("active");
    $('#informes-tab').removeClass("active");
    $('#imagenes-tab').removeClass("active");
    $('#presupuestos-tab').removeClass("active");
    $('#infoprinc-tab').removeClass("active");

    if(moduloactivo=="anamnesis")
    {
        $('#anamnesis-tab').addClass("active");
        $('#anamnesis-tab-pane').addClass("show active");
    }
    if(moduloactivo=="odontogramadiag")
    {
        $('#odontogramadiag-tab').addClass("active");
        $('#odontogramadiag-tab-pane').addClass("show active");
    }
    if(moduloactivo=="odontogramatrat")
    {
        $('#odontogramatrat-tab').addClass("active");
        $('#odontogramatrat-tab-pane').addClass("show active");
    }
    if(moduloactivo=="informes")
    {
        $('#informes-tab').addClass("active");
        $('#informes-tab-pane').addClass("show active");
    }
    if(moduloactivo=="imagenes")
    {
        $('#imagenes-tab').addClass("active");
        $('#imagenes-tab-pane').addClass("show active");
    }
    if(moduloactivo=="presupuestos")
    {
        $('#presupuestos-tab').addClass("active");
        $('#presupuestos-tab-pane').addClass("show active");
    }
    if(moduloactivo=="")
    {
        $('#infoprinc-tab').addClass("active");
        $('#infoprinc-tab-pane').addClass("show active");
    }
    
});

$(document).ready(function() {
    setTimeout(function() {
        $(".alert").fadeOut(500);
    },5000);
});

</script>    
@endsection

<link href="{{asset('assets/css/odontograma/dd_style.css')}}" rel='stylesheet' type='text/css' media='all'/>
<link href="{{asset('assets/css/odontograma/dd_style-responsive.css')}}" rel='stylesheet' type='text/css' media='screen'/>
<link href="{{asset('assets/css/odontograma/dd_style-print.css')}}" rel='stylesheet' type='text/css' media='print'/>
<link href="{{asset('assets/css/gallery/fancybox.min.css')}}" rel="stylesheet" type='text/css' media="screen"/>

<style type="text/css">
    
    @media print { 

        body, #odontogramatrat-tab-pane {
          background-color: blue;
        }

        .impre {display:none}
    }


    #demo {
      height:100%;
      position:relative;
      overflow:hidden;
    }

    .thumb{
        margin-bottom: 30px;
    }

    .page-top{
        margin-top:85px;
    }

       
    img.zoom {
        width: 100%;
        height: 200px;
        border-radius:5px;
        object-fit:cover;
        -webkit-transition: all .3s ease-in-out;
        -moz-transition: all .3s ease-in-out;
        -o-transition: all .3s ease-in-out;
        -ms-transition: all .3s ease-in-out;
    }
            
     
    .transition {
        -webkit-transform: scale(1.2); 
        -moz-transform: scale(1.2);
        -o-transform: scale(1.2);
        transform: scale(1.2);
    }
    .modal-header {
       
        border-bottom: none;
    }
    .modal-title {
        color:#000;
    }
    .modal-footer{
      display:none;  
    }


</style>
@section('content')

<div class="modal fade" id="realizarpagoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue-600">
                <h5 class="modal-title text-white-500" id="exampleModalLabel"><strong>REALIZAR PAGO</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="/paciente/{{$paciente->paciente_id}}/realizarpago" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="tratamiento_id" name="tratamiento_id">
                    <div class="form-group">
                        <label for="transaccion_fecha" class="form-control-label">Fecha</label>
                        <input type="date" class="form-control" aria-describedby="width" id="transaccion_fecha" name="transaccion_fecha" required="required" />
                    </div>
                    <div class="form-group">
                        <label for="transaccion_monto" class="form-control-label">Monto</label>
                        <input type="number" class="form-control" aria-describedby="width" id="transaccion_monto" name="transaccion_monto" required="required" />
                    </div>                                                     
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary">Guardar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="agregarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue-600">
                <h5 class="modal-title text-white-500" id="exampleModalLabel"><strong>AGREGAR IMAGEN</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="/paciente/{{$paciente->paciente_id}}/guardarimagen" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="imagen_desc" class="form-control-label">Descripción</label>
                        <input type="text" class="form-control" aria-describedby="width" id="imagen_desc" name="imagen_desc" required="required" />
                    </div>
                    <div class="form-group required">
                        <label class="control-label">Imagen max: 20Mb</label>
                        <div class="">
                            <input type="file" class="form-control" name="file12" required>
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

<div class="content" id="content">

    <div id="project-dashboard" class="page-layout simple right-sidebar tabbed">

        <div class="page-content-wrapper">

            <!-- HEADER -->
            <div class="page-header text-auto d-flex flex-column justify-content-between px-6 pt-4 pb-0" style="background-color: #125285; color: white;">

                <div class="row no-gutters align-items-start justify-content-between flex-nowrap">

                    <div>
                        <span class="h2">Paciente: {{$paciente->paciente_nombre.' '.$paciente->paciente_apellido}}</span>
                    </div>
                </div>

                <div class="impre row no-gutters align-items-center project-selection">

                    <div class="impre selected-project h6 px-4 py-2">Regresar</div>

                    <div class="impre project-selector">
                        <a href="/pacientes" class="btn btn-icon">
                            <i class="icon icon-keyboard-return"></i>
                        </a>
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
            <!-- / HEADER -->

            <!-- CONTENT -->
            <div class="page-content">
                <div  class="impre" style="background-color: white">
                <ul class="impre nav nav-tabs" id="myTab" role="tablist">
                    
                    <li class="nav-item">
                        <a class="nav-link btn" id="infoprinc-tab" data-toggle="tab" href="#infoprinc-tab-pane" role="tab" aria-controls="infoprinc-tab-pane">Información Principal</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link btn" id="anamnesis-tab" data-toggle="tab" href="#anamnesis-tab-pane" role="tab" aria-controls="anamnesis-tab-pane">Anamnesis General</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link btn" id="odontogramadiag-tab" data-toggle="tab" href="#odontogramadiag-tab-pane" role="tab" aria-controls="odontogramadiag-tab-pane">Odontograma</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link btn" id="odontogramatrat-tab" data-toggle="tab" href="#odontogramatrat-tab-pane" role="tab" aria-controls="odontogramatrat-tab-pane">Tratamiento</a>
                    </li>

                    <!--<li class="nav-item">
                        <a class="nav-link btn" id="informes-tab" data-toggle="tab" href="#informes-tab-pane" role="tab" aria-controls="informes-tab-pane" aria-expanded="false">Informes</a>
                    </li>-->

                    <li class="nav-item">
                        <a class="nav-link btn" id="imagenes-tab" data-toggle="tab" href="#imagenes-tab-pane" role="tab" aria-controls="imagenes-tab-pane">Imagenes</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link btn" id="presupuestos-tab" data-toggle="tab" href="#presupuestos-tab-pane" role="tab" aria-controls="presupuestos-tab-pane">Presupuesto</a>
                    </li>
                </ul></div>

                <div class="tab-content">
                    <div class="tab-pane fade" id="infoprinc-tab-pane" role="tabpanel" aria-labelledby="infoprinc-tab">

                        <!-- WIDGET GROUP -->
                        <div class="widget-group row">

                            <!-- WIDGET 5 -->
                            <div class="col-12 p-3">

                                <div class="widget widget5 card">

                                    <div class="widget-header px-4 row no-gutters align-items-center justify-content-between">
                                        <div class="col">
                                            <span class="h6">Información Principal</span>
                                        </div>                                        
                                    </div>
                                    <hr>
                                    <div class="widget-content">
                                        <div class="col-12 col-md-12">
                                            <div class="example small">
                                                <form method="post" action="/paciente/{{$paciente->paciente_id}}/guardariprincipal">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <div class="description">
                                                        <div class="description-text">
                                                            <hr>
                                                            <h6><strong>Datos Personales</strong></h6>
                                                            <hr>
                                                        </div>                                
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <div class="form-group">
                                                                <label for="paciente_dni" class="form-control-label">DNI</label>
                                                                <input type="text" class="form-control" aria-describedby="width" id="paciente_dni" name="paciente_dni" value="{{$paciente->paciente_dni}}" required="required" />
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <div class="form-group">
                                                                <label for="paciente_nombre" class="form-control-label">Nombres</label>
                                                                <input type="text" class="form-control" aria-describedby="width" id="paciente_nombre" name="paciente_nombre" value="{{$paciente->paciente_nombre}}" required="required" />
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <div class="form-group">
                                                                <label for="paciente_apellido" class="form-control-label">Apellidos</label>
                                                                <input type="text" class="form-control" aria-describedby="width" id="paciente_apellido" name="paciente_apellido"value="{{$paciente->paciente_apellido}}" required="required" />
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <div class="form-group">
                                                                <label for="paciente_fechanac" class="form-control-label">Fecha de Nacimiento</label>
                                                                <input class="form-control" type="date" aria-describedby="width" id="paciente_fechanac" name="paciente_fechanac" value="{{$paciente->paciente_fechanac}}" required="required" />
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <div class="form-group">
                                                                <label for="paciente_telefono" class="form-control-label">Teléfono</label>
                                                                <input type="text" class="form-control" aria-describedby="width" id="paciente_telefono" name="paciente_telefono"value="{{$paciente->paciente_telefono}}" required="required"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Género</label>
                                                                @if($paciente->paciente_genero=="F")
                                                                    <div class="form-check form-check-inline">
                                                                        <label class="form-check-label">
                                                                            <input class="form-check-input" type="radio" name="paciente_genero" id="inlineRadio1" value="F" checked="" />
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
                                                                            <input class="form-check-input" type="radio" name="paciente_genero" id="inlineRadio3" value="SE"/>
                                                                            <span class="radio-icon"></span>
                                                                            <span class="form-check-description">SE</span>
                                                                        </label>
                                                                    </div>
                                                                @endif  
                                                                @if($paciente->paciente_genero=="M")
                                                                    <div class="form-check form-check-inline">
                                                                        <label class="form-check-label">
                                                                            <input class="form-check-input" type="radio" name="paciente_genero" id="inlineRadio1" value="F" />
                                                                            <span class="radio-icon"></span>
                                                                            <span class="form-check-description">F</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <label class="form-check-label">
                                                                            <input class="form-check-input" type="radio" name="paciente_genero" id="inlineRadio2" value="M" checked="" />
                                                                            <span class="radio-icon"></span>
                                                                            <span class="form-check-description">M</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <label class="form-check-label">
                                                                            <input class="form-check-input" type="radio" name="paciente_genero" id="inlineRadio3" value="SE"/>
                                                                            <span class="radio-icon"></span>
                                                                            <span class="form-check-description">SE</span>
                                                                        </label>
                                                                    </div>
                                                                @endif  
                                                                @if($paciente->paciente_genero=="SE")
                                                                    <div class="form-check form-check-inline">
                                                                        <label class="form-check-label">
                                                                            <input class="form-check-input" type="radio" name="paciente_genero" id="inlineRadio1" value="F"/>
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
                                                                            <input class="form-check-input" type="radio" name="paciente_genero" id="inlineRadio3" value="SE" checked="" />
                                                                            <span class="radio-icon"></span>
                                                                            <span class="form-check-description">SE</span>
                                                                        </label>
                                                                    </div>
                                                                @endif  
                                                                @if($paciente->paciente_genero=="")
                                                                    <div class="form-check form-check-inline">
                                                                        <label class="form-check-label">
                                                                            <input class="form-check-input" type="radio" name="paciente_genero" id="inlineRadio1" value="F"/>
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
                                                                            <input class="form-check-input" type="radio" name="paciente_genero" id="inlineRadio3" value="SE"/>
                                                                            <span class="radio-icon"></span>
                                                                            <span class="form-check-description">SE</span>
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <label for="paciente_correo" class="form-control-label">Correo</label>
                                                                <input type="text" class="form-control" aria-describedby="width" id="paciente_correo" name="paciente_correo" value="{{$paciente->paciente_correo}}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-3">

                                                            <div class="form-group">
                                                                <label for="departamento_id" class="form-control-label">Departamento</label>
                                                                    <select class="form-control" aria-describedby="width"  id="departamento_id" name="departamento_id">
                                                                       @foreach ($departamentos as $departamento)
                                                                            @if($departamento->departamento_id==$paciente->departamento_id)
                                                                                <option selected="" value='{{$departamento->departamento_id}}'>{{$departamento->departamento_desc}}</option>
                                                                            @else
                                                                                <option  value='{{$departamento->departamento_id}}'>{{$departamento->departamento_desc}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                            </div>

                                                        </div>

                                                        <div class="col-3">

                                                            <div class="form-group">
                                                                <label for="paciente_direccion" class="form-control-label">Dirección</label>
                                                                <input type="text" class="form-control" aria-describedby="width" id="paciente_direccion" name="paciente_direccion" value="{{$paciente->paciente_direccion}}"/>
                                                            </div>

                                                        </div>

                                                        <div class="col-3">

                                                            <div class="form-group">
                                                                <label for="paciente_ocupacion" class="form-control-label">Ocupación</label>
                                                                <input type="text" class="form-control" aria-describedby="width" id="paciente_ocupacion" name="paciente_ocupacion" value="{{$paciente->paciente_ocupacion}}"/>     
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
                                                                <input type="text" class="form-control" aria-describedby="width" id="cadicional_nombre" name="cadicional_nombre" value="{{$paciente->cadicional->cadicional_nombre}}" />   
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label for="cadicional_parentesco" class="form-control-label">Parentesco</label>
                                                                <input type="text" class="form-control" aria-describedby="width" id="cadicional_parentesco" name="cadicional_parentesco" value="{{$paciente->cadicional->cadicional_parentesco}}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label for="cadicional_telefono" class="form-control-label">Teléfono</label>
                                                                <input type="text" class="form-control" aria-describedby="width" id="cadicional_telefono" name="cadicional_telefono" value="{{$paciente->cadicional->cadicional_telefono}}" />
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
                                                                <input type="text" class="form-control" aria-describedby="width" id="rpago_nombre" name="rpago_nombre" value="{{$paciente->rpago->rpago_nombre}}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-8">
                                                            <div class="form-group">
                                                                <label for="rpago_nota" class="form-control-label">Notas Paciente</label>
                                                                <input type="text" class="form-control" aria-describedby="width" id="rpago_nota" name="rpago_nota" value="{{$paciente->rpago->rpago_nota}}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-secondary">Guardar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / WIDGET 5 -->
                            
                        </div>
                        <!-- / WIDGET GROUP -->
                    </div>
                    <div class="tab-pane fade" id="anamnesis-tab-pane" role="tabpanel" aria-labelledby="anamnesis-tab">
                        <!-- WIDGET GROUP -->
                        <div class="widget-group row">

                            <!-- WIDGET 5 -->
                            <div class="col-12 p-3">

                                <div class="widget widget5 card">

                                    <div class="widget-header px-4 row no-gutters align-items-center justify-content-between">
                                        <div class="col">
                                            <span class="h6">Anamnesis General</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="widget-content">
                                        <div class="col-12 col-md-12">
                                            <div class="example">

                                                <div class="source-preview-wrapper">
                                                    <div class="preview">
                                                        <div class="preview-elements">
                                                            <form method="post" action="/paciente/{{$paciente->paciente_id}}/guardaranamnesis">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <div class="description">
                                                                    <div class="description-text">
                                                                    </div>                                
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="anamnesis_motivo" class="form-control-label">Motivo de Consulta</label>
                                                                            <textarea class="form-control" aria-describedby="width" id="anamnesis_motivo" name="anamnesis_motivo"> {{$paciente->anamnesis->anamnesis_motivo}} </textarea>   
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="anamnesis_amedico" class="form-control-label">Antecedentes Médicos</label>
                                                                            <textarea class="form-control" aria-describedby="width" id="anamnesis_amedico" name="anamnesis_amedico"> {{$paciente->anamnesis->anamnesis_amedico}} </textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="anamnesis_alergia" class="form-control-label">Alergias</label>
                                                                            <textarea class="form-control" aria-describedby="width" id="anamnesis_alergia" name="anamnesis_alergia"> {{$paciente->anamnesis->anamnesis_alergia}} </textarea>   
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="anamnesis_medicamento" class="form-control-label">Medicamentos</label>
                                                                            <textarea class="form-control" aria-describedby="width" id="anamnesis_medicamento" name="anamnesis_medicamento"> {{$paciente->anamnesis->anamnesis_medicamento}} </textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="anamnesis_habito" class="form-control-label">Hábitos</label>
                                                                            <textarea class="form-control" aria-describedby="width" id="anamnesis_habito" name="anamnesis_habito"> {{$paciente->anamnesis->anamnesis_habito}} </textarea>   
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="anamnesis_afamiliar" class="form-control-label">Antecedentes Familiares</label>
                                                                            <textarea class="form-control" aria-describedby="width" id="anamnesis_afamiliar" name="anamnesis_afamiliar"> {{$paciente->anamnesis->anamnesis_afamiliar}} </textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="anamnesis_otros" class="form-control-label">Otros</label>
                                                                            <textarea class="form-control" aria-describedby="width" id="anamnesis_otros" name="anamnesis_otros"> {{$paciente->anamnesis->anamnesis_otros}} </textarea>   
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <div class="form-group">
                                                                            <label for="anamnesis_embarazo" class="form-control-label">Embarazo</label>
                                                                            <div class="form-check form-check-inline">
                                                                                <label class="form-check-label">
                                                                                    @if($paciente->anamnesis->anamnesis_embarazo=="SI")
                                                                                        <input class="form-check-input" type="radio" checked="" name="anamnesis_embarazo" id="inlineRadio2" value="SI" />
                                                                                    @else
                                                                                        <input class="form-check-input" type="radio" name="anamnesis_embarazo" id="inlineRadio2" value="SI" />
                                                                                    @endif
                                                                                    <span class="radio-icon"></span>
                                                                                    <span class="form-check-description">SI</span>
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <label class="form-check-label">
                                                                                    @if($paciente->anamnesis->anamnesis_embarazo=="NO")
                                                                                        <input class="form-check-input" type="radio" checked="" name="anamnesis_embarazo" id="inlineRadio2" value="NO" />
                                                                                    @else
                                                                                        <input class="form-check-input" type="radio" name="anamnesis_embarazo" id="inlineRadio2" value="NO" />
                                                                                    @endif
                                                                                    <span class="radio-icon"></span>
                                                                                    <span class="form-check-description">NO</span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <div class="form-group">
                                                                            <label for="anamnesis_coagulacion" class="form-control-label">Coagulación</label>
                                                                            <div class="form-check form-check-inline">
                                                                                <label class="form-check-label">
                                                                                    @if($paciente->anamnesis->anamnesis_coagulacion=="SI")
                                                                                        <input class="form-check-input" type="radio" checked="" name="anamnesis_coagulacion" id="inlineRadio2" value="SI" />
                                                                                    @else
                                                                                        <input class="form-check-input" type="radio" name="anamnesis_coagulacion" id="inlineRadio2" value="SI" />
                                                                                    @endif
                                                                                    <span class="radio-icon"></span>
                                                                                    <span class="form-check-description">SI</span>
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <label class="form-check-label">
                                                                                    @if($paciente->anamnesis->anamnesis_coagulacion=="NO")
                                                                                        <input class="form-check-input" type="radio" checked="" name="anamnesis_coagulacion" id="inlineRadio2" value="NO" />
                                                                                    @else
                                                                                        <input class="form-check-input" type="radio" name="anamnesis_coagulacion" id="inlineRadio2" value="NO" />
                                                                                    @endif
                                                                                    <span class="radio-icon"></span>
                                                                                    <span class="form-check-description">NO</span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <div class="form-group">
                                                                            <label for="anamnesis_panestesia" class="form-control-label">Problema Anestesia</label>
                                                                            <div class="form-check form-check-inline">
                                                                                <label class="form-check-label">
                                                                                    @if($paciente->anamnesis->anamnesis_panestesia=="SI")
                                                                                        <input class="form-check-input" type="radio" checked="" name="anamnesis_panestesia" id="inlineRadio2" value="SI" />
                                                                                    @else
                                                                                        <input class="form-check-input" type="radio" name="anamnesis_panestesia" id="inlineRadio2" value="SI" />
                                                                                    @endif
                                                                                    <span class="radio-icon"></span>
                                                                                    <span class="form-check-description">SI</span>
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <label class="form-check-label">
                                                                                    @if($paciente->anamnesis->anamnesis_panestesia=="NO")
                                                                                        <input class="form-check-input" type="radio" checked="" name="anamnesis_panestesia" id="inlineRadio2" value="NO" />
                                                                                    @else
                                                                                        <input class="form-check-input" type="radio" name="anamnesis_panestesia" id="inlineRadio2" value="NO" />
                                                                                    @endif
                                                                                    <span class="radio-icon"></span>
                                                                                    <span class="form-check-description">NO</span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <button type="submit" class="btn btn-secondary">Guardar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / WIDGET 5 -->
                            
                        </div>
                        <!-- / WIDGET GROUP -->
                    </div>
                    <div class="tab-pane fade" id="odontogramadiag-tab-pane" role="tabpanel" aria-labelledby="odontogramadiag-tab">

                        <div id="previewImage">
                            <img src="" id="resultimg">
                                                </div>

                        <!-- WIDGET GROUP -->
                        <div class="widget-group row">

                            <!-- WIDGET 5 -->
                            <div class="col-12 p-3">

                                <div class="widget widget5 card">

                                    <div class="widget-header px-4 row no-gutters align-items-center justify-content-between">
                                        <div class="col">
                                            <span class="h6">Odontograma</span>

                                            <div class="float-right">
                                                <div>


                                                <a href="/paciente/{{$paciente->paciente_id}}/nuevoodontograma" class="btn btn-primary fuse-ripple-ready">Nuevo</a>
                                                <!-- <button class="btn btn-primary fuse-ripple-ready" id="btnPrint" onclick="imprimirElemento(previewImage)">Imprimir</button>
                                                <input id="btn-Preview-Image" type="button"  class="btn btn-primary fuse-ripple-ready" value="Preview"/>
                                                <a id="btn-Convert-Html2Image" href="#">Download</a> -->
                                                

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="widget-content">
                                        <div class="col-12 col-md-12">
                                            <div class="tab-content">
                                                <div id="ficha_odontograma" class="tab-pane sub_menu_tab active">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div id="odontograma_diagnosticos" class="odontograma">
                                                                <p class="font-weight-bold">SELECCIONE DIAGNÓSTICO:</p>
                                                                <hr>
                                                                <div class="radio-item">
                                                                    <input type="radio" name="tratamiento" value="sano" id="tsano" class="tsano" checked=""><label for="tsano" class="tsano">Sano</label>
                                                                </div>
                                                                <div class="radio-item">
                                                                    <input type="radio" name="tratamiento" value="caries" id="tcaries" class="tcaries"><label for="tcaries" class="tcaries">Caries</label>
                                                                </div>
                                                                <div class="radio-item">
                                                                    <input type="radio" name="tratamiento" value="sellante" id="tsellante" class="tsellante"><label for="tsellante" class="tsellante">Sellante</label>
                                                                </div>
                                                                <div class="radio-item">
                                                                    <input type="radio" name="tratamiento" value="amalgama" id="tamalgama" class="tamalgama" checked=""><label for="tamalgama" class="tamalgama">Amalgama</label>
                                                                </div>
                                                                <div class="radio-item">
                                                                    <input type="radio" name="tratamiento" value="composite" id="tcomposite" class="tcomposite"><label for="tcomposite" class="tcomposite">Composite</label>
                                                                </div>
                                                                <div class="radio-item">
                                                                    <input type="radio" name="tratamiento" value="incrustacion" id="tincrustacion" class="tincrustacion"><label for="tincrustacion" class="tincrustacion">Incrustación</label>
                                                                </div>
                                                                <div class="radio-item">
                                                                    <input type="radio" name="tratamiento" value="fractura" id="tfractura" class="tfractura" checked=""><label for="tfractura" class="tfractura">Fractura Dentaria</label>
                                                                </div>
                                                                <div class="radio-item">
                                                                    <input type="radio" name="tratamiento" value="surco" id="tsurco" class="tsurco"><label for="tsurco" class="tsurco">Surco Profundo</label>
                                                                </div>
                                                                <div class="radio-item">
                                                                    <input type="radio" name="tratamiento" value="endodoncia" id="tendodoncia" class="tendodoncia"><label for="tendodoncia" class="tendodoncia">Endodoncia</label>
                                                                </div>
                                                                <div class="radio-item">
                                                                    <input type="radio" name="tratamiento" value="ausente" id="tausente" class="tausente"><label for="tausente" class="tausente">Pieza Ausente</label>
                                                                </div>
                                                                <div class="radio-item">
                                                                    <input type="radio" name="tratamiento" value="extraccion" id="textraccion" class="textraccion"><label for="textraccion" class="textraccion">Extracción Indicada</label>
                                                                </div>
                                                                <div class="radio-item">
                                                                    <input type="radio" name="tratamiento" value="coronada" id="tcoronada" class="tcoronada"><label for="tcoronada" class="tcoronada">Pieza Coronada</label>
                                                                </div>
                                                                <div class="radio-item">
                                                                    <input type="radio" name="tratamiento" value="implante" id="timplante" class="timplante"><label for="timplante" class="timplante">Implante</label>
                                                                </div>
                                                                <div class="radio-item">
                                                                    <input type="radio" name="tratamiento" value="lcnc" id="tlcnc" class="tlcnc"><label for="tlcnc" class="tlcnc">Lesión Cervical No Cariosa</label>
                                                                </div>
                                                            </div>

                                                            <div id="odontograma_anamnesis" class="odontograma relative">
                                                                <div class="section-loader" style="display: none;"></div>
                                                                    <table id="odontograma_anamnesis_table">
                                                                        <input type="hidden" id="id_odontograma" name="id_odontograma" value="933">
                                                                        <!-- ADULTO SUPERIOR -->
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="t18">
                                                                                        <img src="{{asset('img/dientes/d18.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="18" class="n_diente">1.8</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t18"><span class="cara" id="v18">V</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label class="cara_diente cara_t18"><span class="cara" id="d18">D</span></label></td>
                                                                                            <td><label class="cara_diente cara_t18"><span class="cara" id="o18">O</span></label></td>
                                                                                            <td><label class="cara_diente cara_t18"><span class="cara" id="m18">M</span></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t18"><span class="cara" id="p18">P</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody></table>
                                                                                </td>
                                                                                <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="t17"><img src="{{asset('img/dientes/d17.png')}}" class="relative"></div>
                                                                                    <label data-ndiente="17" class="n_diente">1.7</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t17"><span class="cara sano" id="v17">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t17"><span class="cara sano" id="d17">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t17"><span class="cara sano" id="o17">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t17"><span class="cara sano" id="m17">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t17"><span class="cara sano" id="p17">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="t16"><img src="{{asset('img/dientes/d16.png')}}" class="relative"></div>
                                                                                    <label data-ndiente="16" class="n_diente">1.6</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t16"><span class="cara sano" id="v16">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t16"><span class="cara sano" id="d16">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t16"><span class="cara sano" id="o16">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t16"><span class="cara sano" id="m16">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t16"><span class="cara sano" id="p16">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="t15">
                                                                                        <img src="{{asset('img/dientes/d15.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="15" class="n_diente">1.5</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t15"><span class="cara" id="v15">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t15"><span class="cara" id="d15">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t15"><span class="cara" id="o15">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t15"><span class="cara" id="m15">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t15"><span class="cara" id="p15">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="t14">
                                                                                        <img src="{{asset('img/dientes/d14.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="14" class="n_diente">1.4</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t14"><span class="cara" id="v14">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t14"><span class="cara" id="d14">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t14"><span class="cara" id="o14">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t14"><span class="cara" id="m14">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t14"><span class="cara" id="p14">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="t13">
                                                                                        <img src="{{asset('img/dientes/d13.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="13" class="n_diente">1.3</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t13"><span class="cara" id="v13">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t13"><span class="cara" id="d13">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t13"><span class="cara" id="i13">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t13"><span class="cara" id="m13">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t13"><span class="cara" id="p13">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="t12">
                                                                                        <img src="{{asset('img/dientes/d12.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="12" class="n_diente">1.2</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t12"><span class="cara" id="v12">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t12"><span class="cara" id="d12">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t12"><span class="cara" id="i12">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t12"><span class="cara" id="m12">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t12"><span class="cara" id="p12">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center border_right">
                                                                                    <div class="relative diente_adulto" id="t11">
                                                                                        <img src="{{asset('img/dientes/d11.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="11" class="n_diente">1.1</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t11"><span class="cara" id="v11">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t11"><span class="cara" id="d11">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t11"><span class="cara" id="i11">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t11"><span class="cara" id="m11">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t11"><span class="cara" id="p11">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="t21">
                                                                                        <img src="{{asset('img/dientes/d21.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="21" class="n_diente">2.1</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t21"><span class="cara" id="v21">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t21"><span class="cara" id="m21">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t21"><span class="cara" id="i21">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t21"><span class="cara" id="d21">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t21"><span class="cara" id="p21">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="t22">
                                                                                        <img src="{{asset('img/dientes/d22.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="22" class="n_diente">2.2</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t22"><span class="cara" id="v22">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t22"><span class="cara" id="m22">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t22"><span class="cara" id="i22">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t22"><span class="cara" id="d22">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t22"><span class="cara" id="p22">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="t23">
                                                                                        <img src="{{asset('img/dientes/d23.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="23" class="n_diente">2.3</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t23"><span class="cara" id="v23">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t23"><span class="cara" id="m23">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t23"><span class="cara" id="i23">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t23"><span class="cara" id="d23">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t23"><span class="cara" id="p23">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="t24"><img src="{{asset('img/dientes/d24.png')}}" class="relative"></div>
                                                                                    <label data-ndiente="24" class="n_diente">2.4</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t24"><span class="cara sano" id="v24">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t24"><span class="cara sano" id="m24">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t24"><span class="cara sano" id="o24">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t24"><span class="cara sano" id="d24">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t24"><span class="cara sano" id="p24">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="t25">
                                                                                        <img src="{{asset('img/dientes/d25.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="25" class="n_diente">2.5</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t25"><span class="cara" id="v25">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t25"><span class="cara" id="m25">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t25"><span class="cara" id="o25">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t25"><span class="cara" id="d25">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t25"><span class="cara" id="p25">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="t26"><img src="{{asset('img/dientes/d26.png')}}" class="relative"></div>
                                                                                    <label data-ndiente="26" class="n_diente">2.6</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t26"><span class="cara sano" id="v26">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t26"><span class="cara sano" id="m26">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t26"><span class="cara sano" id="o26">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t26"><span class="cara sano" id="d26">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t26"><span class="cara sano" id="p26">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="t27"><img src="{{asset('img/dientes/d27.png')}}" class="relative"></div>
                                                                                    <label data-ndiente="27" class="n_diente">2.7</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t27"><span class="cara sano" id="v27">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t27"><span class="cara sano" id="m27">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t27"><span class="cara sano" id="o27">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t27"><span class="cara sano" id="d27">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t27"><span class="cara sano" id="p27">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="t28">
                                                                                        <img src="{{asset('img/dientes/d28.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="28" class="n_diente">2.8</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t28"><span class="cara" id="v28">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t28"><span class="cara" id="m28">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t28"><span class="cara" id="o28">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t28"><span class="cara" id="d28">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t28"><span class="cara" id="p28">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        <!-- NINIO SUPERIOR -->
                                                                            <tr class="border_bottom">
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td class="text-center padding_bottom border_bottom ">
                                                                                    <div class="relative diente_ninio" id="t55">
                                                                                        <img src="{{asset('img/dientes/d55.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="55" class="n_diente">5.5</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t55"><span class="cara" id="v55">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t55"><span class="cara" id="d55">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t55"><span class="cara" id="o55">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t55"><span class="cara" id="m55">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t55"><span class="cara" id="p55">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_bottom border_bottom ">
                                                                                    <div class="relative diente_ninio" id="t54">
                                                                                        <img src="{{asset('img/dientes/d54.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="54" class="n_diente">5.4</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t54"><span class="cara" id="v54">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t54"><span class="cara" id="d54">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t54"><span class="cara" id="o54">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t54"><span class="cara" id="m54">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t54"><span class="cara" id="p54">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_bottom border_bottom ">
                                                                                    <div class="relative diente_ninio" id="t53">
                                                                                        <img src="{{asset('img/dientes/d53.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="53" class="n_diente">5.3</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t53"><span class="cara" id="v53">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t53"><span class="cara" id="d53">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t53"><span class="cara" id="i53">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t53"><span class="cara" id="m53">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t53"><span class="cara" id="p53">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_bottom border_bottom ">
                                                                                    <div class="relative diente_ninio" id="t52">
                                                                                        <img src="{{asset('img/dientes/d52.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="52" class="n_diente">5.2</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t52"><span class="cara" id="v52">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t52"><span class="cara" id="d52">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t52"><span class="cara" id="i52">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t52"><span class="cara" id="m52">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t52"><span class="cara" id="p52">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_bottom border_bottom border_right">
                                                                                    <div class="relative diente_ninio" id="t51">
                                                                                        <img src="{{asset('img/dientes/d51.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="51" class="n_diente">5.1</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t51"><span class="cara" id="v51">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t51"><span class="cara" id="d51">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t51"><span class="cara" id="i51">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t51"><span class="cara" id="m51">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t51"><span class="cara" id="p51">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_bottom border_bottom">
                                                                                    <div class="relative diente_ninio" id="t61">
                                                                                        <img src="{{asset('img/dientes/d61.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="61" class="n_diente">6.1</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t61"><span class="cara" id="v61">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t61"><span class="cara" id="m61">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t61"><span class="cara" id="i61">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t61"><span class="cara" id="d61">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t61"><span class="cara" id="p61">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_bottom border_bottom">
                                                                                    <div class="relative diente_ninio" id="t62">
                                                                                        <img src="{{asset('img/dientes/d62.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="62" class="n_diente">6.2</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t62"><span class="cara" id="v62">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t62"><span class="cara" id="m62">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t62"><span class="cara" id="i62">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t62"><span class="cara" id="d62">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t62"><span class="cara" id="p62">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_bottom border_bottom">
                                                                                    <div class="relative diente_ninio" id="t63">
                                                                                        <img src="{{asset('img/dientes/d63.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="63" class="n_diente">6.3</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t63"><span class="cara" id="v63">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t63"><span class="cara" id="m63">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t63"><span class="cara" id="i63">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t63"><span class="cara" id="d63">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t63"><span class="cara" id="p63">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_bottom border_bottom">
                                                                                    <div class="relative diente_ninio" id="t64">
                                                                                        <img src="{{asset('img/dientes/d64.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="64" class="n_diente">6.4</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t64"><span class="cara" id="v64">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t64"><span class="cara" id="m64">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t64"><span class="cara" id="o64">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t64"><span class="cara" id="d64">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t64"><span class="cara" id="p64">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_bottom border_bottom">
                                                                                    <div class="relative diente_ninio" id="t65">
                                                                                        <img src="{{asset('img/dientes/d65.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="65" class="n_diente">6.5</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t65"><span class="cara" id="v65">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t65"><span class="cara" id="m65">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t65"><span class="cara" id="o65">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t65"><span class="cara" id="d65">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t65"><span class="cara" id="p65">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        <!-- NINIO INFERIOR -->
                                                                            <tr>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td class="text-center padding_top ">
                                                                                    <div class="relative diente_ninio" id="t85">
                                                                                        <img src="{{asset('img/dientes/d85.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="85" class="n_diente">8.5</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t85"><span class="cara" id="l85">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t85"><span class="cara" id="d85">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t85"><span class="cara" id="o85">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t85"><span class="cara" id="m85">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t85"><span class="cara" id="v85">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_top ">
                                                                                    <div class="relative diente_ninio" id="t84">
                                                                                        <img src="{{asset('img/dientes/d84.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="84" class="n_diente">8.4</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t84"><span class="cara" id="l84">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t84"><span class="cara" id="d84">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t84"><span class="cara" id="o84">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t84"><span class="cara" id="m84">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t84"><span class="cara" id="v84">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_top ">
                                                                                    <div class="relative diente_ninio" id="t83">
                                                                                        <img src="{{asset('img/dientes/d83.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="83" class="n_diente">8.3</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t83"><span class="cara" id="l83">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t83"><span class="cara" id="d83">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t83"><span class="cara" id="i83">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t83"><span class="cara" id="m83">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t83"><span class="cara" id="v83">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_top ">
                                                                                    <div class="relative diente_ninio" id="t82">
                                                                                        <img src="{{asset('img/dientes/d82.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="82" class="n_diente">8.2</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t82"><span class="cara" id="l82">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t82"><span class="cara" id="d82">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t82"><span class="cara" id="i82">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t82"><span class="cara" id="m82">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t82"><span class="cara" id="v82">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_top border_right">
                                                                                    <div class="relative diente_ninio" id="t81">
                                                                                        <img src="{{asset('img/dientes/d81.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="81" class="n_diente">8.1</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t81"><span class="cara" id="l81">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t81"><span class="cara" id="d81">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t81"><span class="cara" id="i81">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t81"><span class="cara" id="m81">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t81"><span class="cara" id="v81">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_top">
                                                                                    <div class="relative diente_ninio" id="t71">
                                                                                        <img src="{{asset('img/dientes/d71.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="71" class="n_diente">7.1</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t71"><span class="cara" id="l71">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t71"><span class="cara" id="m71">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t71"><span class="cara" id="i71">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t71"><span class="cara" id="d71">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t71"><span class="cara" id="v71">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_top">
                                                                                    <div class="relative diente_ninio" id="t72">
                                                                                        <img src="{{asset('img/dientes/d72.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="72" class="n_diente">7.2</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t72"><span class="cara" id="l72">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t72"><span class="cara" id="m72">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t72"><span class="cara" id="i72">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t72"><span class="cara" id="d72">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t72"><span class="cara" id="v72">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_top">
                                                                                    <div class="relative diente_ninio" id="t73">
                                                                                        <img src="{{asset('img/dientes/d73.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="73" class="n_diente">7.3</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t73"><span class="cara" id="l73">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t73"><span class="cara" id="m73">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t73"><span class="cara" id="i73">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t73"><span class="cara" id="d73">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t73"><span class="cara" id="v73">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_top">
                                                                                    <div class="relative diente_ninio" id="t74">
                                                                                        <img src="{{asset('img/dientes/d74.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="74" class="n_diente">7.4</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t74"><span class="cara" id="l74">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t74"><span class="cara" id="m74">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t74"><span class="cara" id="o74">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t74"><span class="cara" id="d74">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t74"><span class="cara" id="v74">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_top">
                                                                                    <div class="relative diente_ninio" id="t75">
                                                                                        <img src="{{asset('img/dientes/d75.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="75" class="n_diente">7.5</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t75"><span class="cara" id="l75">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t75"><span class="cara" id="m75">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t75"><span class="cara" id="o75">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t75"><span class="cara" id="d75">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t75"><span class="cara" id="v75">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        <!-- ADULTO INFERIOR -->
                                                                            <tr>
                                                                                 <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="t48">
                                                                                        <img src="{{asset('img/dientes/d48.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="48" class="n_diente">4.8</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t48"><span class="cara" id="l48">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t48"><span class="cara" id="d48">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t48"><span class="cara" id="o48">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t48"><span class="cara" id="m48">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t48"><span class="cara" id="v48">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="t47">
                                                                                        <img src="{{asset('img/dientes/d47.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="47" class="n_diente">4.7</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t47"><span class="cara" id="l47">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t47"><span class="cara" id="d47">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t47"><span class="cara" id="o47">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t47"><span class="cara" id="m47">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t47"><span class="cara" id="v47">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="t46">
                                                                                        <img src="{{asset('img/dientes/d46.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="46" class="n_diente">4.6</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t46"><span class="cara" id="l46">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t46"><span class="cara" id="d46">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t46"><span class="cara" id="o46">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t46"><span class="cara" id="m46">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t46"><span class="cara" id="v46">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="t45">
                                                                                        <img src="{{asset('img/dientes/d45.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="45" class="n_diente">4.5</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t45"><span class="cara" id="l45">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t45"><span class="cara" id="d45">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t45"><span class="cara" id="o45">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t45"><span class="cara" id="m45">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t45"><span class="cara" id="v45">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="t44">
                                                                                        <img src="{{asset('img/dientes/d44.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="44" class="n_diente">4.4</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t44"><span class="cara" id="l44">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t44"><span class="cara" id="d44">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t44"><span class="cara" id="o44">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t44"><span class="cara" id="m44">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t44"><span class="cara" id="v44">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="t43"><img src="{{asset('img/dientes/d43.png')}}" class="relative"></div>
                                                                                    <label data-ndiente="43" class="n_diente">4.3</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t43"><span class="cara sano" id="l43">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t43"><span class="cara sano" id="d43">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t43"><span class="cara sano" id="i43">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t43"><span class="cara sano" id="m43">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t43"><span class="cara sano" id="v43">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="t42">
                                                                                        <img src="{{asset('img/dientes/d42.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="42" class="n_diente">4.2</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t42"><span class="cara" id="l42">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t42"><span class="cara" id="d42">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t42"><span class="cara" id="i42">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t42"><span class="cara" id="m42">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t42"><span class="cara" id="v42">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center border_right">
                                                                                    <div class="relative diente_adulto" id="t41"><img src="{{asset('img/dientes/d41.png')}}" class="relative"></div>
                                                                                    <label data-ndiente="41" class="n_diente">4.1</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t41"><span class="cara sano" id="l41">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t41"><span class="cara sano" id="d41">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t41"><span class="cara sano" id="i41">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t41"><span class="cara sano" id="m41">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t41"><span class="cara sano" id="v41">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="t31"><img src="{{asset('img/dientes/d31.png')}}" class="relative"></div>
                                                                                    <label data-ndiente="31" class="n_diente">3.1</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t31"><span class="cara sano" id="l31">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t31"><span class="cara sano" id="m31">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t31"><span class="cara sano" id="i31">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t31"><span class="cara sano" id="d31">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t31"><span class="cara sano" id="v31">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="t32"><img src="{{asset('img/dientes/d32.png')}}" class="relative"></div>
                                                                                    <label data-ndiente="32" class="n_diente">3.2</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t32"><span class="cara sano" id="l32">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t32"><span class="cara sano" id="m32">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t32"><span class="cara sano" id="i32">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t32"><span class="cara sano" id="d32">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t32"><span class="cara sano" id="v32">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="t33"><img src="{{asset('img/dientes/d33.png')}}" class="relative"></div>
                                                                                    <label data-ndiente="33" class="n_diente">3.3</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t33"><span class="cara sano" id="l33">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t33"><span class="cara sano" id="m33">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t33"><span class="cara sano" id="i33">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t33"><span class="cara sano" id="d33">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t33"><span class="cara sano" id="v33">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="t34"><img src="{{asset('img/dientes/d34.png')}}" class="relative"></div>
                                                                                    <label data-ndiente="34" class="n_diente">3.4</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t34"><span class="cara sano" id="l34">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t34"><span class="cara sano" id="m34">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t34"><span class="cara sano" id="o34">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t34"><span class="cara sano" id="d34">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t34"><span class="cara sano" id="v34">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="t35">
                                                                                        <img src="{{asset('img/dientes/d35.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="35" class="n_diente">3.5</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t35"><span class="cara" id="l35">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t35"><span class="cara" id="m35">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t35"><span class="cara" id="o35">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t35"><span class="cara" id="d35">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t35"><span class="cara" id="v35">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="t36">
                                                                                        <img src="{{asset('img/dientes/d36.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="36" class="n_diente">3.6</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t36"><span class="cara" id="l36">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t36"><span class="cara" id="m36">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t36"><span class="cara" id="o36">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t36"><span class="cara" id="d36">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t36"><span class="cara" id="v36">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="t37">
                                                                                        <img src="{{asset('img/dientes/d37.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="37" class="n_diente">3.7</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t37"><span class="cara" id="l37">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t37"><span class="cara" id="m37">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t37"><span class="cara" id="o37">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t37"><span class="cara" id="d37">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t37"><span class="cara" id="v37">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="t38"><img src="{{asset('img/dientes/d38.png')}}" class="relative"></div>
                                                                                    <label data-ndiente="38" class="n_diente">3.8</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t38"><span class="cara sano" id="l38">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t38"><span class="cara sano" id="m38">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t38"><span class="cara sano" id="o38">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t38"><span class="cara sano" id="d38">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t38"><span class="cara sano" id="v38">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br/>
                                                        <div class="col-md-12">
                                                            <form method="POST" action="/paciente/{{$paciente->paciente_id}}/guardarodontograma/{{$odontograma->odontograma_id}}">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <div class="form-row align-items-center">
                                                                    <div class="col-md-11">
                                                                      <textarea class="form-control mb-2" name="odontograma_observ" style="border-width: 1px; border-color: black;" placeholder="Observaciones">{{$odontograma->odontograma_observ}}</textarea>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                      <button type="submit" class="btn btn-primary mb-2">Guardar</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>

                                                        <hr><br/>
                                                        <div class="col-md-12">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    Odontogramas
                                                                </div>
                                                                <div class="card-body">
                                                                    <table class="table table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Fecha</th>
                                                                                <th>Observaciones</th>
                                                                                <th>Acciones</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($odontogramas as $odont)
                                                                                <tr>
                                                                                    <td>{{$odont->odontograma_fecha}}</td>
                                                                                    <td>{{$odont->odontograma_observ}}</td>
                                                                                    <td><a href="/paciente/{{$paciente->paciente_id}}/verodontograma/{{$odont->odontograma_id}}" class="btn btn-icon fuse-ripple-ready"><i class="icon-eye"></i></a><a href="/paciente/{{$paciente->paciente_id}}/eliminarodontograma/{{$odont->odontograma_id}}" class="btn btn-icon fuse-ripple-ready" onclick="return confirm('Está seguro que desea eliminar?');"><i class="icon-delete"></i></a></td>
                                                                                </tr>
                                                                            @endforeach
                                                                            
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <!-- / WIDGET 5 -->
                            
                        </div>
                        <!-- / WIDGET GROUP -->
                    </div>
                    <div class="tab-pane fade" id="odontogramatrat-tab-pane" role="tabpanel" aria-labelledby="odontogramatrat-tab">
                        <div class="widget-group row">

                            <!-- WIDGET 5 -->
                            <div class="col-12 p-3">

                                <div class="widget widget5 card">

                                    <div class="widget-header px-4 row no-gutters align-items-center justify-content-between">
                                        <div class="col">
                                            <span class="h6">Tratamiento</span>
                                            <div class="float-right">
                                                <div>
                                                <a href="/paciente/{{$paciente->paciente_id}}/nuevotratamiento" class="btn btn-primary fuse-ripple-ready">Nuevo</a>
                                                <!-- <a href="/paciente/{{$paciente->paciente_id}}/imprimirtratamiento" class="btn btn-primary fuse-ripple-ready">Imprimir</a>--></div> 
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="widget-content">
                                        <div class="col-12 col-md-12">
                                            <div class="tab-content">
                                                <div id="ficha_tratamiento" class="tab-pane sub_menu_tab active">
                                                    <div class="row">
                                                        <div class="col-md-12" id="ficha_tratamiento_imp">

                                                            <div id="odontograma_tratamiento" class="odontograma relative">
                                                                <div class="section-loader" style="display: none;"></div>
                                                                    <table id="odontograma_tratamiento_table">
                                                                        <input type="hidden" id="id_odontograma" name="id_odontograma" value="933">
                                                                        <!-- ADULTO SUPERIOR -->
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="trat18">
                                                                                        <img src="{{asset('img/dientes/d18.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="18" class="n_diente">1.8</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t18"><span class="cara" id="trav18">V</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label class="cara_diente cara_t18"><span class="cara" id="trad18">D</span></label></td>
                                                                                            <td><label class="cara_diente cara_t18"><span class="cara" id="trao18">O</span></label></td>
                                                                                            <td><label class="cara_diente cara_t18"><span class="cara" id="tram18">M</span></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t18"><span class="cara" id="trap18">P</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody></table>
                                                                                </td>
                                                                                <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="trat17"><img src="{{asset('img/dientes/d17.png')}}" class="relative"></div>
                                                                                    <label data-ndiente="17" class="n_diente">1.7</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t17"><span class="cara sano" id="v17">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t17"><span class="cara" id="trad17">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t17"><span class="cara" id="trao17">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t17"><span class="cara" id="tram17">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t17"><span class="cara" id="trap17">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="trat16"><img src="{{asset('img/dientes/d16.png')}}" class="relative"></div>
                                                                                    <label data-ndiente="16" class="n_diente">1.6</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t16"><span class="cara" id="trav16">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t16"><span class="cara" id="trad16">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t16"><span class="cara" id="trao16">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t16"><span class="cara" id="tram16">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t16"><span class="cara" id="trap16">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="trat15">
                                                                                        <img src="{{asset('img/dientes/d15.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="15" class="n_diente">1.5</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t15"><span class="cara" id="trav15">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t15"><span class="cara" id="trad15">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t15"><span class="cara" id="trao15">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t15"><span class="cara" id="tram15">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t15"><span class="cara" id="trap15">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="trat14">
                                                                                        <img src="{{asset('img/dientes/d14.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="14" class="n_diente">1.4</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t14"><span class="cara" id="trav14">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t14"><span class="cara" id="trad14">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t14"><span class="cara" id="trao14">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t14"><span class="cara" id="tram14">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t14"><span class="cara" id="trap14">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="trat13">
                                                                                        <img src="{{asset('img/dientes/d13.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="13" class="n_diente">1.3</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t13"><span class="cara" id="trav13">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t13"><span class="cara" id="trad13">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t13"><span class="cara" id="trai13">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t13"><span class="cara" id="tram13">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t13"><span class="cara" id="trap13">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center ">
                                                                                    <div class="relative diente_adulto" id="trat12">
                                                                                        <img src="{{asset('img/dientes/d12.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="12" class="n_diente">1.2</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t12"><span class="cara" id="trav12">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t12"><span class="cara" id="trad12">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t12"><span class="cara" id="trai12">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t12"><span class="cara" id="tram12">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t12"><span class="cara" id="trap12">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center border_right">
                                                                                    <div class="relative diente_adulto" id="trat11">
                                                                                        <img src="{{asset('img/dientes/d11.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="11" class="n_diente">1.1</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t11"><span class="cara" id="trav11">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t11"><span class="cara" id="trad11">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t11"><span class="cara" id="trai11">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t11"><span class="cara" id="tram11">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t11"><span class="cara" id="trap11">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="trat21">
                                                                                        <img src="{{asset('img/dientes/d21.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="21" class="n_diente">2.1</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t21"><span class="cara" id="trav21">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t21"><span class="cara" id="tram21">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t21"><span class="cara" id="trai21">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t21"><span class="cara" id="trad21">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t21"><span class="cara" id="trap21">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="trat22">
                                                                                        <img src="{{asset('img/dientes/d22.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="22" class="n_diente">2.2</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t22"><span class="cara" id="trav22">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t22"><span class="cara" id="tram22">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t22"><span class="cara" id="trai22">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t22"><span class="cara" id="trad22">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t22"><span class="cara" id="trap22">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="trat23">
                                                                                        <img src="{{asset('img/dientes/d23.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="23" class="n_diente">2.3</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t23"><span class="cara" id="trav23">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t23"><span class="cara" id="tram23">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t23"><span class="cara" id="trai23">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t23"><span class="cara" id="trad23">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t23"><span class="cara" id="trap23">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="trat24"><img src="{{asset('img/dientes/d24.png')}}" class="relative"></div>
                                                                                    <label data-ndiente="24" class="n_diente">2.4</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t24"><span class="cara" id="trav24">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t24"><span class="cara" id="tram24">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t24"><span class="cara" id="trao24">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t24"><span class="cara" id="trad24">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t24"><span class="cara" id="trap24">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="trat25">
                                                                                        <img src="{{asset('img/dientes/d25.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="25" class="n_diente">2.5</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t25"><span class="cara" id="trav25">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t25"><span class="cara" id="tram25">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t25"><span class="cara" id="trao25">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t25"><span class="cara" id="trad25">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t25"><span class="cara" id="trap25">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="trat26"><img src="{{asset('img/dientes/d26.png')}}" class="relative"></div>
                                                                                    <label data-ndiente="26" class="n_diente">2.6</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t26"><span class="cara" id="trav26">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t26"><span class="cara" id="tram26">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t26"><span class="cara" id="trao26">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t26"><span class="cara" id="trad26">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t26"><span class="cara" id="trap26">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="trat27"><img src="{{asset('img/dientes/d27.png')}}" class="relative"></div>
                                                                                    <label data-ndiente="27" class="n_diente">2.7</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t27"><span class="cara" id="trav27">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t27"><span class="cara" id="tram27">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t27"><span class="cara" id="trao27">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t27"><span class="cara" id="trad27">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t27"><span class="cara" id="trap27">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="relative diente_adulto" id="trat28">
                                                                                        <img src="{{asset('img/dientes/d28.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="28" class="n_diente">2.8</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t28"><span class="cara" id="trav28">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t28"><span class="cara" id="tram28">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t28"><span class="cara" id="trao28">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t28"><span class="cara" id="trad28">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t28"><span class="cara" id="trap28">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        <!-- NINIO SUPERIOR -->
                                                                            <tr>
                                                                                <td></td>
                                                                                <td>
                                                                                    <div class='relative boca boca_completa' id='trat100'>
                                                                                        <img src="{{asset('img/dientes/boca.png')}}" alt='Boca' title='Boca'/>
                                                                                    </div>
                                                                                </td>
                                                                                <td></td>
                                                                                <td class="text-center padding_bottom border_bottom ">
                                                                                    <div class="relative diente_ninio" id="trat55">
                                                                                        <img src="{{asset('img/dientes/d55.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="55" class="n_diente">5.5</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t55"><span class="cara" id="trav55">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t55"><span class="cara" id="trad55">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t55"><span class="cara" id="trao55">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t55"><span class="cara" id="tram55">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t55"><span class="cara" id="trap55">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_bottom border_bottom ">
                                                                                    <div class="relative diente_ninio" id="trat54">
                                                                                        <img src="{{asset('img/dientes/d54.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="54" class="n_diente">5.4</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t54"><span class="cara" id="trav54">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t54"><span class="cara" id="trad54">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t54"><span class="cara" id="trao54">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t54"><span class="cara" id="tram54">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t54"><span class="cara" id="trap54">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_bottom border_bottom ">
                                                                                    <div class="relative diente_ninio" id="trat53">
                                                                                        <img src="{{asset('img/dientes/d53.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="53" class="n_diente">5.3</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t53"><span class="cara" id="trav53">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t53"><span class="cara" id="trad53">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t53"><span class="cara" id="trai53">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t53"><span class="cara" id="tram53">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t53"><span class="cara" id="trap53">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_bottom border_bottom ">
                                                                                    <div class="relative diente_ninio" id="trat52">
                                                                                        <img src="{{asset('img/dientes/d52.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="52" class="n_diente">5.2</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t52"><span class="cara" id="trav52">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t52"><span class="cara" id="trad52">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t52"><span class="cara" id="trai52">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t52"><span class="cara" id="tram52">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t52"><span class="cara" id="trap52">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_bottom border_bottom border_right">
                                                                                    <div class="relative diente_ninio" id="trat51">
                                                                                        <img src="{{asset('img/dientes/d51.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="51" class="n_diente">5.1</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t51"><span class="cara" id="trav51">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t51"><span class="cara" id="trad51">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t51"><span class="cara" id="trai51">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t51"><span class="cara" id="tram51">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t51"><span class="cara" id="trap51">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_bottom border_bottom">
                                                                                    <div class="relative diente_ninio" id="trat61">
                                                                                        <img src="{{asset('img/dientes/d61.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="61" class="n_diente">6.1</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t61"><span class="cara" id="trav61">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t61"><span class="cara" id="tram61">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t61"><span class="cara" id="trai61">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t61"><span class="cara" id="trad61">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t61"><span class="cara" id="trap61">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_bottom border_bottom">
                                                                                    <div class="relative diente_ninio" id="trat62">
                                                                                        <img src="{{asset('img/dientes/d62.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="62" class="n_diente">6.2</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t62"><span class="cara" id="trav62">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t62"><span class="cara" id="tram62">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t62"><span class="cara" id="trai62">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t62"><span class="cara" id="trad62">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t62"><span class="cara" id="trap62">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_bottom border_bottom">
                                                                                    <div class="relative diente_ninio" id="trat63">
                                                                                        <img src="{{asset('img/dientes/d63.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="63" class="n_diente">6.3</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t63"><span class="cara" id="trav63">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t63"><span class="cara" id="tram63">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t63"><span class="cara" id="trai63">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t63"><span class="cara" id="trad63">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t63"><span class="cara" id="trap63">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_bottom border_bottom">
                                                                                    <div class="relative diente_ninio" id="trat64">
                                                                                        <img src="{{asset('img/dientes/d64.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="64" class="n_diente">6.4</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t64"><span class="cara" id="trav64">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t64"><span class="cara" id="tram64">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t64"><span class="cara" id="trao64">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t64"><span class="cara" id="trad64">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t64"><span class="cara" id="trap64">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_bottom border_bottom">
                                                                                    <div class="relative diente_ninio" id="trat65">
                                                                                        <img src="{{asset('img/dientes/d65.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="65" class="n_diente">6.5</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t65"><span class="cara" id="trav65">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t65"><span class="cara" id="tram65">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t65"><span class="cara" id="trao65">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t65"><span class="cara" id="trad65">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t65"><span class="cara" id="trap65">P</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td></td>
                                                                                <td>
                                                                                    <div class='relative boca boca_mitad' id='trat101'>
                                                                                        <img src="{{asset('img/dientes/boca_sup.png')}}" alt='Maxilar' title='Maxilar'/>
                                                                                    </div>
                                                                                </td>
                                                                                <td></td>
                                                                            </tr>
                                                                        <!-- NINIO INFERIOR -->
                                                                            <tr>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td class="text-center padding_top ">
                                                                                    <div class="relative diente_ninio" id="trat85">
                                                                                        <img src="{{asset('img/dientes/d85.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="85" class="n_diente">8.5</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t85"><span class="cara" id="tral85">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t85"><span class="cara" id="trad85">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t85"><span class="cara" id="trao85">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t85"><span class="cara" id="tram85">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t85"><span class="cara" id="trav85">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_top ">
                                                                                    <div class="relative diente_ninio" id="trat84">
                                                                                        <img src="{{asset('img/dientes/d84.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="84" class="n_diente">8.4</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t84"><span class="cara" id="tral84">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t84"><span class="cara" id="trad84">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t84"><span class="cara" id="trao84">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t84"><span class="cara" id="tram84">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t84"><span class="cara" id="trav84">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_top ">
                                                                                    <div class="relative diente_ninio" id="trat83">
                                                                                        <img src="{{asset('img/dientes/d83.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="83" class="n_diente">8.3</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t83"><span class="cara" id="tral83">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t83"><span class="cara" id="trad83">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t83"><span class="cara" id="trai83">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t83"><span class="cara" id="tram83">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t83"><span class="cara" id="trav83">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_top ">
                                                                                    <div class="relative diente_ninio" id="trat82">
                                                                                        <img src="{{asset('img/dientes/d82.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="82" class="n_diente">8.2</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t82"><span class="cara" id="tral82">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t82"><span class="cara" id="trad82">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t82"><span class="cara" id="trai82">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t82"><span class="cara" id="tram82">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t82"><span class="cara" id="trav82">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_top border_right">
                                                                                    <div class="relative diente_ninio" id="trat81">
                                                                                        <img src="{{asset('img/dientes/d81.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="81" class="n_diente">8.1</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t81"><span class="cara" id="tral81">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t81"><span class="cara" id="trad81">D</span></label></td>
                                                                                                <td><label class="cara_diente cara_t81"><span class="cara" id="trai81">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t81"><span class="cara" id="tram81">M</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t81"><span class="cara" id="trav81">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_top">
                                                                                    <div class="relative diente_ninio" id="trat71">
                                                                                        <img src="{{asset('img/dientes/d71.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="71" class="n_diente">7.1</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t71"><span class="cara" id="tral71">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t71"><span class="cara" id="tram71">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t71"><span class="cara" id="trai71">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t71"><span class="cara" id="trad71">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t71"><span class="cara" id="trav71">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_top">
                                                                                    <div class="relative diente_ninio" id="trat72">
                                                                                        <img src="{{asset('img/dientes/d72.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="72" class="n_diente">7.2</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t72"><span class="cara" id="tral72">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t72"><span class="cara" id="tram72">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t72"><span class="cara" id="trai72">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t72"><span class="cara" id="trad72">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t72"><span class="cara" id="trav72">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_top">
                                                                                    <div class="relative diente_ninio" id="trat73">
                                                                                        <img src="{{asset('img/dientes/d73.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="73" class="n_diente">7.3</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t73"><span class="cara" id="tral73">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t73"><span class="cara" id="tram73">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t73"><span class="cara" id="trai73">I</span></label></td>
                                                                                                <td><label class="cara_diente cara_t73"><span class="cara" id="trad73">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t73"><span class="cara" id="trav73">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_top">
                                                                                    <div class="relative diente_ninio" id="trat74">
                                                                                        <img src="{{asset('img/dientes/d74.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="74" class="n_diente">7.4</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t74"><span class="cara" id="tral74">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t74"><span class="cara" id="tram74">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t74"><span class="cara" id="trao74">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t74"><span class="cara" id="trad74">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t74"><span class="cara" id="trav74">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td class="text-center padding_top">
                                                                                    <div class="relative diente_ninio" id="trat75">
                                                                                        <img src="{{asset('img/dientes/d75.png')}}" class="relative">
                                                                                    </div>
                                                                                    <label data-ndiente="75" class="n_diente">7.5</label>
                                                                                    <table class="caras">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t75"><span class="cara" id="tral75">L</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label class="cara_diente cara_t75"><span class="cara" id="tram75">M</span></label></td>
                                                                                                <td><label class="cara_diente cara_t75"><span class="cara" id="trao75">O</span></label></td>
                                                                                                <td><label class="cara_diente cara_t75"><span class="cara" id="trad75">D</span></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td><label class="cara_diente cara_t75"><span class="cara" id="trav75">V</span></label></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td></td>
                                                                                <td>
                                                                                    <div class='relative boca boca_mitad' id='trat102'>
                                                                                        <img src="{{asset('img/dientes/boca_inf.png')}}" alt='Mand&iacute;bula' title='Mand&iacute;bula'/>
                                                                                    </div>
                                                                                </td>
                                                                                <td></td>
                                                                            </tr>
                                                                        <!-- ADULTO INFERIOR -->
                                                                        <tr>
                                                                             <td class="text-center ">
                                                                                <div class="relative diente_adulto" id="trat48">
                                                                                    <img src="{{asset('img/dientes/d48.png')}}" class="relative">
                                                                                </div>
                                                                                <label data-ndiente="48" class="n_diente">4.8</label>
                                                                                <table class="caras">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t48"><span class="cara" id="tral48">L</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label class="cara_diente cara_t48"><span class="cara" id="trad48">D</span></label></td>
                                                                                            <td><label class="cara_diente cara_t48"><span class="cara" id="trao48">O</span></label></td>
                                                                                            <td><label class="cara_diente cara_t48"><span class="cara" id="tram48">M</span></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t48"><span class="cara" id="trav48">V</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td class="text-center ">
                                                                                <div class="relative diente_adulto" id="trat47">
                                                                                    <img src="{{asset('img/dientes/d47.png')}}" class="relative">
                                                                                </div>
                                                                                <label data-ndiente="47" class="n_diente">4.7</label>
                                                                                <table class="caras">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t47"><span class="cara" id="tral47">L</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label class="cara_diente cara_t47"><span class="cara" id="trad47">D</span></label></td>
                                                                                            <td><label class="cara_diente cara_t47"><span class="cara" id="trao47">O</span></label></td>
                                                                                            <td><label class="cara_diente cara_t47"><span class="cara" id="tram47">M</span></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t47"><span class="cara" id="trav47">V</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td class="text-center ">
                                                                                <div class="relative diente_adulto" id="trat46">
                                                                                    <img src="{{asset('img/dientes/d46.png')}}" class="relative">
                                                                                </div>
                                                                                <label data-ndiente="46" class="n_diente">4.6</label>
                                                                                <table class="caras">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t46"><span class="cara" id="tral46">L</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label class="cara_diente cara_t46"><span class="cara" id="trad46">D</span></label></td>
                                                                                            <td><label class="cara_diente cara_t46"><span class="cara" id="trao46">O</span></label></td>
                                                                                            <td><label class="cara_diente cara_t46"><span class="cara" id="tram46">M</span></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t46"><span class="cara" id="trav46">V</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td class="text-center ">
                                                                                <div class="relative diente_adulto" id="trat45">
                                                                                    <img src="{{asset('img/dientes/d45.png')}}" class="relative">
                                                                                </div>
                                                                                <label data-ndiente="45" class="n_diente">4.5</label>
                                                                                <table class="caras">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t45"><span class="cara" id="tral45">L</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label class="cara_diente cara_t45"><span class="cara" id="trad45">D</span></label></td>
                                                                                            <td><label class="cara_diente cara_t45"><span class="cara" id="trao45">O</span></label></td>
                                                                                            <td><label class="cara_diente cara_t45"><span class="cara" id="tram45">M</span></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t45"><span class="cara" id="trav45">V</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td class="text-center ">
                                                                                <div class="relative diente_adulto" id="trat44">
                                                                                    <img src="{{asset('img/dientes/d44.png')}}" class="relative">
                                                                                </div>
                                                                                <label data-ndiente="44" class="n_diente">4.4</label>
                                                                                <table class="caras">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t44"><span class="cara" id="tral44">L</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label class="cara_diente cara_t44"><span class="cara" id="trad44">D</span></label></td>
                                                                                            <td><label class="cara_diente cara_t44"><span class="cara" id="trao44">O</span></label></td>
                                                                                            <td><label class="cara_diente cara_t44"><span class="cara" id="tram44">M</span></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t44"><span class="cara" id="trav44">V</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td class="text-center ">
                                                                                <div class="relative diente_adulto" id="trat43"><img src="{{asset('img/dientes/d43.png')}}" class="relative"></div>
                                                                                <label data-ndiente="43" class="n_diente">4.3</label>
                                                                                <table class="caras">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t43"><span class="cara" id="tral43">L</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label class="cara_diente cara_t43"><span class="cara" id="trad43">D</span></label></td>
                                                                                            <td><label class="cara_diente cara_t43"><span class="cara" id="trai43">I</span></label></td>
                                                                                            <td><label class="cara_diente cara_t43"><span class="cara" id="tram43">M</span></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t43"><span class="cara" id="trav43">V</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td class="text-center ">
                                                                                <div class="relative diente_adulto" id="trat42">
                                                                                    <img src="{{asset('img/dientes/d42.png')}}" class="relative">
                                                                                </div>
                                                                                <label data-ndiente="42" class="n_diente">4.2</label>
                                                                                <table class="caras">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t42"><span class="cara" id="tral42">L</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label class="cara_diente cara_t42"><span class="cara" id="trad42">D</span></label></td>
                                                                                            <td><label class="cara_diente cara_t42"><span class="cara" id="trai42">I</span></label></td>
                                                                                            <td><label class="cara_diente cara_t42"><span class="cara" id="tram42">M</span></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t42"><span class="cara" id="trav42">V</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td class="text-center border_right">
                                                                                <div class="relative diente_adulto" id="trat41"><img src="{{asset('img/dientes/d41.png')}}" class="relative"></div>
                                                                                <label data-ndiente="41" class="n_diente">4.1</label>
                                                                                <table class="caras">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t41"><span class="cara" id="tral41">L</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label class="cara_diente cara_t41"><span class="cara" id="trad41">D</span></label></td>
                                                                                            <td><label class="cara_diente cara_t41"><span class="cara" id="trai41">I</span></label></td>
                                                                                            <td><label class="cara_diente cara_t41"><span class="cara" id="tram41">M</span></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t41"><span class="cara" id="trav41">V</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <div class="relative diente_adulto" id="trat31"><img src="{{asset('img/dientes/d31.png')}}" class="relative"></div>
                                                                                <label data-ndiente="31" class="n_diente">3.1</label>
                                                                                <table class="caras">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t31"><span class="cara" id="tral31">L</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label class="cara_diente cara_t31"><span class="cara" id="tram31">M</span></label></td>
                                                                                            <td><label class="cara_diente cara_t31"><span class="cara" id="trai31">I</span></label></td>
                                                                                            <td><label class="cara_diente cara_t31"><span class="cara" id="trad31">D</span></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t31"><span class="cara" id="trav31">V</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <div class="relative diente_adulto" id="trat32"><img src="{{asset('img/dientes/d32.png')}}" class="relative"></div>
                                                                                <label data-ndiente="32" class="n_diente">3.2</label>
                                                                                <table class="caras">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t32"><span class="cara" id="tral32">L</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label class="cara_diente cara_t32"><span class="cara" id="tram32">M</span></label></td>
                                                                                            <td><label class="cara_diente cara_t32"><span class="cara" id="trai32">I</span></label></td>
                                                                                            <td><label class="cara_diente cara_t32"><span class="cara" id="trad32">D</span></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t32"><span class="cara" id="trav32">V</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <div class="relative diente_adulto" id="trat33"><img src="{{asset('img/dientes/d33.png')}}" class="relative"></div>
                                                                                <label data-ndiente="33" class="n_diente">3.3</label>
                                                                                <table class="caras">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t33"><span class="cara" id="tral33">L</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label class="cara_diente cara_t33"><span class="cara" id="tram33">M</span></label></td>
                                                                                            <td><label class="cara_diente cara_t33"><span class="cara" id="trai33">I</span></label></td>
                                                                                            <td><label class="cara_diente cara_t33"><span class="cara" id="trad33">D</span></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t33"><span class="cara" id="trav33">V</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <div class="relative diente_adulto" id="trat34"><img src="{{asset('img/dientes/d34.png')}}" class="relative"></div>
                                                                                <label data-ndiente="34" class="n_diente">3.4</label>
                                                                                <table class="caras">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t34"><span class="cara" id="tral34">L</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label class="cara_diente cara_t34"><span class="cara" id="tram34">M</span></label></td>
                                                                                            <td><label class="cara_diente cara_t34"><span class="cara" id="trao34">O</span></label></td>
                                                                                            <td><label class="cara_diente cara_t34"><span class="cara" id="trad34">D</span></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t34"><span class="cara" id="trav34">V</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <div class="relative diente_adulto" id="trat35">
                                                                                    <img src="{{asset('img/dientes/d35.png')}}" class="relative">
                                                                                </div>
                                                                                <label data-ndiente="35" class="n_diente">3.5</label>
                                                                                <table class="caras">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t35"><span class="cara" id="tral35">L</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label class="cara_diente cara_t35"><span class="cara" id="tram35">M</span></label></td>
                                                                                            <td><label class="cara_diente cara_t35"><span class="cara" id="trao35">O</span></label></td>
                                                                                            <td><label class="cara_diente cara_t35"><span class="cara" id="trad35">D</span></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t35"><span class="cara" id="trav35">V</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <div class="relative diente_adulto" id="trat36">
                                                                                    <img src="{{asset('img/dientes/d36.png')}}" class="relative">
                                                                                </div>
                                                                                <label data-ndiente="36" class="n_diente">3.6</label>
                                                                                <table class="caras">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t36"><span class="cara" id="tral36">L</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label class="cara_diente cara_t36"><span class="cara" id="tram36">M</span></label></td>
                                                                                            <td><label class="cara_diente cara_t36"><span class="cara" id="trao36">O</span></label></td>
                                                                                            <td><label class="cara_diente cara_t36"><span class="cara" id="trad36">D</span></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t36"><span class="cara" id="trav36">V</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <div class="relative diente_adulto" id="trat37">
                                                                                    <img src="{{asset('img/dientes/d37.png')}}" class="relative">
                                                                                </div>
                                                                                <label data-ndiente="37" class="n_diente">3.7</label>
                                                                                <table class="caras">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t37"><span class="cara" id="tral37">L</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label class="cara_diente cara_t37"><span class="cara" id="tram37">M</span></label></td>
                                                                                            <td><label class="cara_diente cara_t37"><span class="cara" id="trao37">O</span></label></td>
                                                                                            <td><label class="cara_diente cara_t37"><span class="cara" id="trad37">D</span></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t37"><span class="cara" id="trav37">V</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <div class="relative diente_adulto" id="trat38"><img src="{{asset('img/dientes/d38.png')}}" class="relative"></div>
                                                                                <label data-ndiente="38" class="n_diente">3.8</label>
                                                                                <table class="caras">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t38"><span class="cara" id="tral38">L</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label class="cara_diente cara_t38"><span class="cara" id="tram38">M</span></label></td>
                                                                                            <td><label class="cara_diente cara_t38"><span class="cara" id="trao38">O</span></label></td>
                                                                                            <td><label class="cara_diente cara_t38"><span class="cara" id="trad38">D</span></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td><label class="cara_diente cara_t38"><span class="cara" id="trav38">V</span></label></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br/>
                                                        

                                                        <hr><br/>
                                                        <div class="col-md-12">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h4>Tratamiento </h4>
                                                                    <div class="col-md-12">
                                                                    <form method="POST" action="/paciente/{{$paciente->paciente_id}}/guardartratamiento/{{$tratamiento->tratamiento_id}}">
                                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                        <div class="row">
                                                                            <div class="col-md-2">
                                                                              <label>Titulo:</label>
                                                                            </div>
                                                                            <div class="col-md-10">
                                                                              <input type="text" class="form-control mb-2" name="tratamiento_titulo" placeholder="Titulo" value="{{$tratamiento->tratamiento_titulo}}"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-2">
                                                                              <label>Fecha Ultima Actualización:</label>
                                                                            </div>
                                                                            <div class="col-md-10">
                                                                              <input type="text" class="form-control mb-2" name="tratamiento_updated_at" value=" {{$tratamiento->updated_at}}" disabled="" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-2">
                                                                              <label>Observaciones:</label>
                                                                            </div>
                                                                            <div class="col-md-10">
                                                                              <textarea class="form-control mb-2" name="tratamiento_observ" style="border-width: 1px; border-color: #8F8F8F;" placeholder="Observaciones">{{$tratamiento->tratamiento_observ}}</textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row float-right">
                                                                            <div class="col-md-1">
                                                                              <button type="submit" class="btn btn-primary mb-2">Guardar</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                </div>
                                                                <div class="card-body col-md-12">
                                                                    <table id="table_desctratamiento" class="table table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Área</th>
                                                                                <th>Superficie</th>
                                                                                <th>Descripción</th>
                                                                                <th>Subtotal</th>
                                                                                <th>Dcto.</th>
                                                                                <th>Total</th>
                                                                                <th>Acciones</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @if(sizeof($dtratamientos)>0)
                                                                            @foreach ($dtratamientos as $dtratamiento)
                                                                                <tr>
                                                                                    @if($dtratamiento->pieza_codigo>=100)
                                                                                        <td>{{$dtratamiento->pieza_desc}}</td>
                                                                                    @else
                                                                                        <td>{{$dtratamiento->pieza_codigo}}</td>
                                                                                    @endif
                                                                                    <td>{{$dtratamiento->superficie_desc}}</td>
                                                                                    <td><input style="width: 100%;" type="text" onchange="cambiodesc({{$dtratamiento->dtratamiento_id}})" id="desc{{$dtratamiento->dtratamiento_id}}" value="{{$dtratamiento->dtratamiento_desc}}"></td>
                                                                                    <td style="text-align: right;"><input style="width: 100%; text-align: right;" type="text" onchange="cambio({{$dtratamiento->dtratamiento_id}})" id="subtotal{{$dtratamiento->dtratamiento_id}}" value="{{number_format($dtratamiento->dtratamiento_subtotal,2,'.',',')}}"></td>
                                                                                    <td style="text-align: right;"><input style="width: 100%; text-align: right;" type="text" onchange="cambio({{$dtratamiento->dtratamiento_id}})" id="descuento{{$dtratamiento->dtratamiento_id}}" value="{{number_format($dtratamiento->dtratamiento_descuento,2,'.',',')}}"></td>
                                                                                    <td style="text-align: right;"><input style="width: 100%; text-align: right;" readonly="" type="text" id="total{{$dtratamiento->dtratamiento_id}}" value="{{number_format($dtratamiento->dtratamiento_total,2,'.',',')}}"></td>
                                                                                    <td style="text-align: right;"><a href="/paciente/{{$paciente->paciente_id}}/eliminardtratamiento/{{$dtratamiento->dtratamiento_id}}" class="btn btn-icon fuse-ripple-ready" onclick="return confirm('Está seguro que desea eliminar?');"><i class="icon-delete"></i></a></td>
                                                                                </tr>
                                                                            @endforeach
                                                                            @endif
                                                                            
                                                                        </tbody>
                                                                        <hr>
                                                                        <tfoot>
                                                                            <th hidden="">id</th>
                                                                            <th></th>
                                                                            <th></th>
                                                                            <th></th>
                                                                            <th style="text-align: right; font-style:inherit;"><input style="font-style:inherit;text-align: right;" type="text" readonly="" id="tratsubtotal" value="{{$tratamiento->tratamiento_subtotal}}"></th>
                                                                            <th style="text-align: right; font-style:inherit;"><input style="font-style:inherit;text-align: right;" type="text" readonly="" id="tratdescuento" value="{{$tratamiento->tratamiento_descuento}}"></th>
                                                                            <th style="text-align: right; font-style:inherit;"><input style="font-style:inherit;text-align: right;" type="text" readonly="" id="trattotal" value="{{$tratamiento->tratamiento_total}}"></th>
                                                                            <th></th>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <!-- / WIDGET 5 -->
                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="informes-tab-pane" role="tabpanel" aria-labelledby="informes-tab">
                        <!-- WIDGET GROUP -->
                        
                        <!-- / WIDGET GROUP -->
                    </div>
                    <div class="tab-pane fade" id="imagenes-tab-pane" role="tabpanel" aria-labelledby="imagenes-tab">
                        <!-- WIDGET GROUP -->
                        <div class="widget-group row">

                            <!-- WIDGET 5 -->
                            <div class="col-12 p-3">

                                <div class="widget widget5 card">

                                    <div class="widget-header px-4 row no-gutters align-items-center justify-content-between">
                                        <div class="col">
                                            <span class="h6">Imagenes</span>
                                            <div class="float-right"><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#agregarModal" data-whatever="@getbootstrap">Agregar</button></div>
                                            
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="widget-content">
                                        <div class="col-12 col-md-12">
                                            <div class="example">

                                                <div class="source-preview-wrapper">
                                                    <div class="preview">
                                                        <div class="preview-elements">
                                                            <div class="row">
                                                                @foreach($imagenes as $imagen)
                                                                    <div class="card" style="width: 30rem;">
                                                                        <a href="{{$imagen->imagen_url}}" class="fancybox" rel="ligthbox">
                                                                            <img  src="{{$imagen->imagen_url}}" class="zoom img-fluid "  alt="">
                                                                           
                                                                        </a>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-10">
                                                                            <p class="card-text">{{$imagen->imagen_desc}}</p></div><div class="col-2">
                                                                            <a href="/paciente/{{$paciente->paciente_id}}/eliminarimagen/{{$imagen->imagen_id}}" class="btn btn-icon fuse-ripple-ready" onclick="return confirm('Está seguro que desea eliminar?');"><i class="icon-delete"></i></a></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>  
                                                                @endforeach
                                                                                                                  
                                                           </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / WIDGET 5 -->
                            
                        </div>
                        <!-- / WIDGET GROUP -->
                    </div>
                    <div class="tab-pane fade" id="presupuestos-tab-pane" role="tabpanel" aria-labelledby="presupuestos-tab">
                        <div class="widget-group row">

                            <!-- WIDGET 5 -->
                            <div class="col-12 p-3">

                                <div class="widget widget5 card">

                                    <div class="widget-header px-4 row no-gutters align-items-center justify-content-between">
                                        <div class="col">
                                            <span class="h6">Presupuestos</span>                                            
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="widget-content">
                                        <div class="col-12 col-md-12">
                                            <div class="example">

                                                <div class="source-preview-wrapper">
                                                    <div class="preview">
                                                        <div class="preview-elements">
                                                                    <table id="sample-data-table" class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Fecha</th>
                                                                                <th>Título</th>
                                                                                <th>Observaciones</th>
                                                                                <th>Total Tratamiento</th>
                                                                                <th>Total Abono</th>
                                                                                <th>Saldo Pendiente</th>
                                                                                <th>Acciones</th>

                                                                            </tr>
                                                                        </thead>
                                                                        @if(sizeof($pacientes)>0)
                                                                        <tbody>                  
                                                                            @foreach ($paciente->tratamientos as $trat)
                                                                                <?php $totalpago=0; ?>
                                                                                @foreach ($trat->transacciones as $trans)
                                                                                    <?php
                                                                                        $totalpago+=(float)$trans->transaccion_monto;
                                                                                    ?>
                                                                                @endforeach
                                                                                <tr>
                                                                                    <td>{{$trat->tratamiento_fecha}}</td>
                                                                                    <td>{{($trat->tratamiento_titulo)?$trat->tratamiento_titulo:'---'}}</td>
                                                                                    <td>{{($trat->tratamiento_observ)?$trat->tratamiento_observ:'---'}}</td>
                                                                                    <td style="text-align: right;">{{number_format($trat->tratamiento_total,2,'.',',')}}</td>
                                                                                    <td style="text-align: right;">{{number_format($totalpago,2,'.',',')}}</td>
                                                                                    <td style="text-align: right;">{{number_format($trat->tratamiento_total-$totalpago,2,'.',',')}}</td>

                                                                                    <td>
                                                                                        <!--<button type="button" class="btn btn-light fuse-ripple-ready" data-toggle="modal" data-target="#editarModal"  cement_id="{{$paciente->paciente_id}}" onclick="setCementerioModal(this)"><i class="icon-lead-pencil" data-toggle="tooltip" data-placement="top" data-original-title="Editar"></i>
                                                                                        </button>-->
                                                                                            <button data-toggle="collapse" href="#verDetalle{{$trat->tratamiento_id}}" aria-expanded="true" aria-controls="verDetalle{{$trat->tratamiento_id}}" class="btn btn-light fuse-ripple-ready" data-original-title="Ver Detalle Tratamiento"><i class="icon-library-books"></i></button>
                                                                                            <button data-toggle="collapse" href="#verPago" aria-expanded="true" aria-controls="verPago" class="btn btn-light fuse-ripple-ready" data-original-title="Ver Detalle Pago"><i class="icon-format-list-bulleted"></i></button>
                                                                                            <button data-toggle="modal" data-target="#crearModal" class="btn btn-light fuse-ripple-ready" data-original-title="Realizar Abono" tratamiento_id="{{$trat->tratamiento_id}}" onclick="openModalPago(this)"><i class="icon-currency-usd" ></i></button>
                                                                                            <button href="/paciente/{{$paciente->paciente_id}}/eliminartratamiento/{{$trat->tratamiento_id}}" class="btn btn-light fuse-ripple-ready" data-original-title="Eliminar" onclick="return confirm('Con está acción se eliminará el tratamiento y pagos correspondientes a este presupuesto. Está seguro que desea eliminar?');"><i class="icon-delete"></i></button>
                                                                                            
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td colspan="7">
                                                                                    <div id="accordion" role="tablist">
                                                                                        <div class="card">
                                                                                            <div id="verDetalle{{$trat->tratamiento_id}}" class="collapse" role="tabpanel" aria-labelledby="headingOne"
                                                                                                 data-parent="#accordion">
                                                                                                <div class="card-block">
                                                                                                    <div class="card">
                                                                                                        <div class="card-header">
                                                                                                            Tratamiento 
                                                                                                            <br/>
                                                                                                        </div>
                                                                                                        <div class="card-body col-md-12 ">
                                                                                                            <table id="table_desctratamiento" class="table table-hover table-bordered">
                                                                                                                <thead>
                                                                                                                    <tr>
                                                                                                                        <th>Área</th>
                                                                                                                        <th>Superficie</th>
                                                                                                                        <th>Descripción</th>
                                                                                                                        <th>Subtotal</th>
                                                                                                                        <th>Dcto.</th>
                                                                                                                        <th>Total</th>
                                                                                                                    </tr>
                                                                                                                </thead>
                                                                                                                <tbody>
                                                                                                                    @if(sizeof($trat->dtratamientos)>0)
                                                                                                                    @foreach ($trat->dtratamientos as $dtrat)
                                                                                                                        <tr>
                                                                                                                            @if($dtrat->pieza_codigo>=100)
                                                                                                                                <td>{{$dtrat->pieza->pieza_desc}}</td>
                                                                                                                            @else
                                                                                                                                <td>{{$dtrat->pieza->pieza_codigo}}</td>
                                                                                                                            @endif
                                                                                                                            <td>{{$dtrat->superficie->superficie_desc}}</td>
                                                                                                                            <td>{{$dtrat->dtratamiento_desc}}</td>
                                                                                                                            <td style="text-align: right;">{{number_format($dtrat->dtratamiento_subtotal,2,'.',',')}}</td>
                                                                                                                            <td style="text-align: right;">{{number_format($dtrat->dtratamiento_descuento,2,'.',',')}}</td>
                                                                                                                            <td style="text-align: right;">{{number_format($dtrat->dtratamiento_total,2,'.',',')}}</td>
                                                                                                                        </tr>
                                                                                                                    @endforeach
                                                                                                                    @endif
                                                                                                                    
                                                                                                                </tbody>
                                                                                                                <hr>
                                                                                                                <tfoot>
                                                                                                                    <tr>
                                                                                                                        <th></th>
                                                                                                                        <th></th>
                                                                                                                        <th></th>
                                                                                                                        <th style="text-align: right;">{{number_format($trat->tratamiento_subtotal,2,'.',',')}}</th>
                                                                                                                        <th style="text-align: right;">{{number_format($trat->tratamiento_descuento,2,'.',',')}}</th>
                                                                                                                        <th style="text-align: right;">{{number_format($trat->tratamiento_total,2,'.',',')}}</th>
                                                                                                                    </tr>
                                                                                                                </tfoot>
                                                                                                            </table>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div id="verPago" class="collapse" role="tabpanel" aria-labelledby="headingTwo"
                                                                                                 data-parent="#accordion">
                                                                                                <div class="card-block">
                                                                                                    <div class="card">
                                                                                                        <div class="card-header">
                                                                                                            Pagos 
                                                                                                            <br/>
                                                                                                        </div>
                                                                                                        <div class="card-body col-md-6 center">
                                                                                                            <table id="table_desctratamiento" class="table table-hover table-bordered">
                                                                                                                <thead>
                                                                                                                    <tr>
                                                                                                                        <th>Fecha</th>
                                                                                                                        <th>Monto</th>
                                                                                                                    </tr>
                                                                                                                </thead>
                                                                                                                <tbody>
                                                                                                                    @if(sizeof($trat->transacciones)>0)
                                                                                                                    @foreach ($trat->transacciones as $trans)
                                                                                                                        <tr>
                                                                                                                            <td>{{$trans->transaccion_fecha}}</td>
                                                                                                                            <td style="text-align: right;">{{number_format($trans->transaccion_monto,2,'.',',')}}</td>
                                                                                                                        </tr>
                                                                                                                    @endforeach
                                                                                                                    @endif
                                                                                                                    
                                                                                                                </tbody>
                                                                                                                <hr>
                                                                                                            </table>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                </tr>


                                                                            @endforeach
                                                                        @else
                                                                            
                                                                        @endif
                                                                        </tbody>
                                                                    </table>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / WIDGET 5 -->
                            
                        </div>
                    </div>
                </div>

            </div>
            <!-- / CONTENT -->

        </div>

        
    </div>

    <script type="text/javascript" src="../assets/js/apps/dashboard/project.js"></script>
    <script src="{{asset('assets/js/gallery/jquery.fancybox.min.js')}}"></script>

    <script>
$(document).ready(function(){

  
var element = $("#odontograma_anamnesis"); // global variable
var getCanvas; // global variable
 
    $("#btn-Preview-Image3").on('click', function () {

        var scaleBy = 2;
        var w = 1000;
        var h = 1000;
        var div = document.querySelector('#odontograma_anamnesis');
        var canvas = document.createElement('canvas');
        canvas.width = w * scaleBy;
        canvas.height = h * scaleBy;
        canvas.style.width = '2000px';
        canvas.style.height ='2000px';
        var context = canvas.getContext('2d');
        context.scale(scaleBy, scaleBy);

        html2canvas(div, {
            canvas:canvas,
            onrendered: function (canvas) {
                $("#previewImage").append(canvas);
                getCanvas = canvas;

            }
        });


    });

    $("#btn-Preview-Image").on('click', function () {
         
         html2canvas(element, {
            dpi: 144,
            onrendered: function (canvas) {
                var dataURL = canvas.toDataURL('image/png');
                document.getElementById("resultimg").src = dataURL;
            }
        });
    });

  $("#btn-Convert-Html2Image").on('click', function () {
    var imgageData = getCanvas.toDataURL("image/png");
    // Now browser starts downloading it instead of just showing it
    var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
    $("#btn-Convert-Html2Image").attr("download", "your_pic_name.png").attr("href", newData);
});

});

</script>

</div>



@endsection