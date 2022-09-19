<?php

namespace App\Http\Controllers\siat;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailAnulacionController;
use App\Models\Cliente;
use App\Models\Siat\MotivoAnulacion;
use App\Models\Venta;
use App\Services\AnulacionFacturaService;
use App\Services\ConfigService;
use App\Services\CufdService;
use App\Services\CuisService;
use App\Services\EmisionIndividualService;
use CreateSiatMotivosAnulacionesTable;
use Illuminate\Http\Request;
use Carbon\Carbon;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\CompraVenta;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\SiatInvoice;

class AnulacionFacturaController extends Controller
{
    public $emisionIndividualService;


    public function __construct()
    {
        $this->cuisService = new CuisService();
        $this->cufdService = new CufdService();
        $this->configService = new ConfigService();
        $this->emisionIndividualService = new EmisionIndividualService();
        $this->anulacionService = new AnulacionFacturaService();
    }

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
        /* dd($cuf); */
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
                "clienteNombre" => $cliente->nombre,
                "clienteCorreo" => $cliente->correo,
            ];

            $body = [
                'nro_factura' => $venta->numero_factura,
                'cuf' => $venta->cuf,
            ];
            $mailAnulacionController = new MailAnulacionController();
            $mailAnulacionController->sendEmail($datosCliente, $body);
        }

        return response()->json([
            'response' => $res
        ]);
    }


    function prueba_anulacion()
    {
        $sucursal = 0;
        $puntoventa = 0;

        $resCuis     = $this->cuisService->obtenerCuis($puntoventa, $sucursal, true);
        $resCufd    = $this->cufdService->obtenerCufd($puntoventa, $sucursal, $resCuis->RespuestaCuis->codigo, true);


        $factura = $this->emisionIndividualService->construirFactura($puntoventa, $sucursal, $this->configService->config->modalidad, $this->configService->documentoSector, $this->configService->codigoActividad, $this->configService->codigoProductoSin);
        $res = $this->anulacionService->testFactura($sucursal, $puntoventa, $factura, $this->configService->tipoFactura);
    
        if ($res->RespuestaServicioFacturacion->codigoEstado == 908) {
            $resa = $this->anulacionService->testAnular2(1, $factura->cabecera->cuf, $sucursal, $puntoventa, $this->configService->tipoFactura, SiatInvoice::TIPO_EMISION_ONLINE, $this->configService->documentoSector);
            print_r($resa);
        }
    }
}
