<?php

namespace App\Http\Controllers;

use App\Mail\AnulacionMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailAnulacionController extends Controller
{
    public function sendEmail($datosCliente,$body)
    {
        $details = [
            'title' => $datosCliente['clienteNombre'],
            'body' => $body
        ];

        Mail::to($datosCliente['clienteCorreo'])->send(new AnulacionMail($details));
        return true;
    }
}
