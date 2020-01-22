<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::post('/contacto','InicioController@postEnviarCorreo');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'AgendaController@index')->name('home');



/*
Route::get('/sicem', 'HomeController@index');
Route::get('/', 'PerukaterController@getBienvenida');*/
Route::get('/agenda', 'AgendaController@index')->name('agenda');

Route::get('/pacientes','PacienteController@index');
Route::post('/paciente/crear','PacienteController@postCrear');
Route::get('/paciente/{paciente_id}/ver','PacienteController@getDetallePaciente');
Route::post('/paciente/{paciente_id}/guardariprincipal','PacienteController@postGuardarIPrincipal');
Route::post('/paciente/{paciente_id}/guardaranamnesis','PacienteController@postGuardarAnamnesis');
Route::post('/paciente/{paciente_id}/guardarimagen','PacienteController@postGuardarImagen');
Route::get('/paciente/{paciente_id}/eliminarimagen/{imagen_id}','PacienteController@getEliminarImagen');
Route::get('/paciente/{paciente_id}/eliminar','PacienteController@getEliminarPaciente');

Route::post('/paciente/{paciente_id}/guardarodontograma/{odontograma_id}','PacienteController@postGuardarOdontograma');
Route::get('/paciente/{paciente_id}/verodontograma/{odontograma_id}','PacienteController@getVerOdontograma');
Route::get('/paciente/{paciente_id}/verodontogramadet/{odontograma_id}','PacienteController@getVerOdontogramaDet');
Route::get('/paciente/{paciente_id}/nuevoodontograma','PacienteController@getNuevoOdontograma');
Route::get('/paciente/{paciente_id}/eliminarodontograma/{odontograma_id}','PacienteController@getEliminarOdontograma');

Route::post('/paciente/{paciente_id}/guardartratamiento/{tratamiento_id}','PacienteController@postGuardarTratamiento');

Route::post('/agenda/crearcita','AgendaController@postCrearCita');
Route::post('/agenda/editarcita','AgendaController@postEditarCita');
Route::get('/agenda/vercita','AgendaController@getVerCita');
Route::get('/agenda/consultadni','AgendaController@getConsultaDni');

Route::get('/paciente/{paciente_id}/nuevotratamiento','PacienteController@getNuevoTratamiento');


//Route::get('/paciente/setSuperficie/{paciente_id}/{coddiag}/{codpieza}/{codsuperf}','PacienteController@setSuperficie');
Route::get('/paciente/setSuperficie','PacienteController@setSuperficie2');
Route::get('/paciente/setPieza','PacienteController@setPieza');
Route::get('/paciente/setDescDTratamiento/{dtratamiento_id}','PacienteController@setDescDTratamiento');
Route::get('/paciente/setPrecioDTratamiento/{dtratamiento_id}/{subtotal}/{descuento}','PacienteController@setPrecioDTratamiento');
Route::get('/paciente/getTratamientoPieza/{paciente_id}/{odontograma_id}/{tratamiento_id}/{pieza}','PacienteController@getTratamientoPieza');

Route::get('/paciente/{paciente_id}/eliminardtratamiento/{dtratamiento_id}','PacienteController@getEliminarTratamientoPieza');
Route::get('/paciente/{paciente_id}/eliminartratamiento/{tratamiento_id}','PacienteController@getEliminarTratamiento');
Route::post('/paciente/{paciente_id}/realizarpago','PacienteController@postCrearTransaccion');

Route::get('/paciente/{paciente_id}/verpresupuesto','PacienteController@getVerPresupuesto');




/*
Route::post('/admin/paciente/crear','CementerioController@postCrear');
Route::get('/admin/cementerio/editar','CementerioController@getEditar');
Route::post('/admin/cementerio/editar','CementerioController@postEditar');
Route::post('/admin/cementerio/eliminar','CementerioController@getEliminar');
Route::get('/admin/cementerio','CementerioController@getIndex');*/
