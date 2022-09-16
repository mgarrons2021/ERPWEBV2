<?php

namespace App\Http\Controllers;

use App\Mail\FacturaMail;
use PDF;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Mail;

class MailFacturacionController extends Controller
{
    public function sendEmail($datosMail, $pdf)
    {
        $data['venta'] = $datosMail['venta'];
        $data['detalle_venta'] = $datosMail['detalle_venta'];
        $data['clienteNombre'] = $datosMail['clienteNombre'];
        $data['clienteCorreo'] = $datosMail['clienteCorreo'];
        $data['fecha'] =  (new Carbon())->locale('es')->isoFormat(' D MMMM Y H:mm');

        Mail::send('mails.EnvioFactura', $data, function ($m) use ($datosMail,$pdf) {
            $m->to($datosMail['clienteCorreo'], $datosMail['clienteCorreo'])
                ->subject($datosMail['clienteNombre'])
                ->attachData($pdf->output(), "Factura.pdf");
        });
        return true;
    }
}
