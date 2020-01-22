<?php

namespace DentalSoft\Http\Controllers;

use Illuminate\Http\Request;

class InicioController extends Controller
{
    

    public function postEnviarCorreo(Request $request)
    {
        $to = strtoupper($request->get('contacto_correo'));
        $subject = strtoupper($request->get('contacto_subject'));
        $message = strtoupper($request->get('contacto_mensaje'));
         
        mail($to, $subject, $message);

        return redirect('/')->with('creado','La cita ha sido actualizada');
    }
}
