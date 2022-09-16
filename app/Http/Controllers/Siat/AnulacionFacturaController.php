<?php

namespace App\Http\Controllers\siat;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailAnulacionController;
use App\Models\Cliente;
use App\Models\Siat\MotivoAnulacion;
use App\Models\Venta;
use App\Services\AnulacionFacturaService;
use CreateSiatMotivosAnulacionesTable;
use Illuminate\Http\Request;
use Carbon\Carbon;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\CompraVenta;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\SiatInvoice;

class AnulacionFacturaController extends Controller
{
    public $emisionIndividualService;

    public function index()
    {

        $fecha_actual =  Carbon::now()->toDateString();
        /* dd($fecha_actual); */
        $motivos_anulaciones =  MotivoAnulacion::all();
        $ventas = Venta::where('fecha_venta', $fecha_actual)->get();

        return view('siat.anulaciones_facturas.index', compact('fecha_actual', 'ventas', 'motivos_anulaciones'));
    }

    public function filtrar_facturas(Request $request)
    {
        $fecha_inicial = $request->fecha_inicial;
        $fecha_final = $request->fecha_final;
        $motivos_anulaciones =  MotivoAnulacion::all();

        $ventas = Venta::whereBetween('fecha_venta', [$fecha_inicial, $fecha_final])->get();

        return view('siat.anulaciones_facturas.index', compact('ventas', 'motivos_anulaciones'));
    }


    public function test_anulacion_factura(Request $request)
    {
        $venta = Venta::find($request->venta_id);
        $sucursal_id = $venta->sucursal_id;
        $cuf = $venta->cuf;
        $motivo = $request->codigo_clasificador;
        $anulacion_factura_service = new AnulacionFacturaService();
        $res = $anulacion_factura_service->pruebasAnulacion($cuf, $motivo, $sucursal_id);


        if ($res->RespuestaServicioFacturacion->transaccion === true) {
            $venta = Venta::find($request->venta_id);
            $venta->update([
                'estado' => 0, /* Anulado */
            ]); 

            $cliente = Cliente::find($venta->cliente_id);

            $datosCliente = [
                "clienteNombre"=>$cliente->nombre,
                "clienteCorreo"=>$cliente->correo,
            ];
              
            $body = [
                'nro_factura' => $venta->numero_factura,
                'cuf' => $venta->cuf,
            ];
            $mailAnulacionController = new MailAnulacionController();
            $mailAnulacionController->sendEmail($datosCliente,$body);
        }

        return response()->json([
            'response' => $res
        ]);
    }
}
