<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Carbon\Carbon;


class VentaController extends Controller
{
    //
    public function formulariodoficacion(Request $request){
        return view('ventas.formdosificacion');
    }

    public function ventas_sucursal(){
        return view('reportes.ventas_sucursal');
    }

    





}
