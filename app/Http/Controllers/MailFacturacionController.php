<?php

namespace App\Http\Controllers;

use App\Mail\FacturaMail;
use App\Models\Cliente;
use PDF;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Mail;

class MailFacturacionController extends Controller
{
    public function sendEmail($datosMail, $pdf)
    {
        $data['venta'] = $datosMail['venta'];
        $cliente = Cliente::find($data['venta']['cliente_id']);

        $datosMail['ci_nit_cliente'] = $cliente->ci_nit;
        $data['detalle_venta'] = $datosMail['detalle_venta'];
        $data['clienteNombre'] = $datosMail['clienteNombre'];
        $data['clienteCorreo'] = $datosMail['clienteCorreo'];
        $data['fecha'] =  (new Carbon())->locale('es')->isoFormat(' D MMMM Y H:mm');



        Mail::send('mails.EnvioFactura', $data, function ($m) use ($datosMail, $pdf) {
            $m->to($datosMail['clienteCorreo'], $datosMail['clienteCorreo'])
                ->subject($datosMail['clienteNombre'])
                ->attachData($pdf->output(), "factura-" . $datosMail['ci_nit_cliente'] . "-" . $datosMail['venta']['numero_factura'] . ".pdf")
                ->attach(public_path() . "/FacturasXML/factura-" . $datosMail['ci_nit_cliente'] . "-" . $datosMail['venta']['numero_factura'] . ".xml");
        });

        return true;
    }
}
