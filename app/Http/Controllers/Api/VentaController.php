<?php

namespace App\Http\Controllers\Api;

use Error;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Venta;
use App\Custom\Letras;
use App\Models\Cliente;
use App\Models\Sucursal;
use App\Models\DetalleVenta;
use App\Models\TurnoIngreso;
use App\Models\Autorizacion;
use Illuminate\Http\Request;
use App\Services\CufService;
use App\Models\Siat\SiatCufd;
use App\Models\RegistroVisita;
use App\Services\VentaService;
use App\Services\ClienteService;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Siat\LeyendaFactura;
use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\MailFacturacionController;
use App\Http\Controllers\Siat\EmisionIndividualController;
use App\Models\Siat\SiatCui;
use App\Services\ConfigService;
use App\Services\VerificarConexionService;
use App\Services\VerificarNitService;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\DocumentTypes;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\SiatInvoice;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioSiat;

use Letras as GlobalLetras;

class VentaController extends Controller
{
    public $configService;

    public function __construct()
    {

        $this->configService = new ConfigService();
    }

    public function registerSale(Request $request)
    {
        try {
            $verificarConexionService = new VerificarConexionService();
            $res = $verificarConexionService->verificarConexionImpuestos();
            return $res;

            $cuis = SiatCui::where('sucursal_id', $request->sucursal)->where('estado', 'V')->orderBy('id', 'desc')->first();

            $codigoExcepcion = 0;
            $verifiyNit = new VerificarNitService();

            if ($request->documento_identidad_id == 5) {
                $verifyConnection = $verifiyNit->verificarNit($cuis->codigo_cui, 0, $request->nit_ci);
                /*       print_r($verifyConnection); */
                if ($verifyConnection->RespuestaVerificarNit->mensajesList->codigo == 994) {
                    $codigoExcepcion = 1;
                }
            }

            DB::beginTransaction();
            $fecha = Carbon::now()->toDateString();
            $hora_actual = Carbon::now()->toTimeString();
            $modalidad = 1; //Electronica en linea
            $tipoEmision = 1; //EN LINEA
            $tipoFactura = 1; //Factura derecho credito fiscal
            $cantidad_visitas = 1;
            $sucursal_id = $request->sucursal;
            $puntoVenta = $this->configService->puntoventa;

            /* return response()->json($request->nit_ci);  */

            /*
            $resNit = $verifiyNit->verificarNit(0,$request->nit_ci); */
            /* print_r($resNit); */


            $clienteData = [
                'cliente' => $request->cliente,
                'ci_nit' => $request->nit_ci,
                'complemento' => $request->complemento,
                'telefono' => $request->telefono,
                'empresa' => $request->empresa,
                'sucursal' => $request->sucursal,
                'correo' => $request->correo,
                'cantidad_visitas' => $cantidad_visitas,
            ];



            $clienteService = new ClienteService();
            $numero_letras = new  Letras();


            $cliente = $clienteService->registrarCliente($clienteData);
            $user = User::find($request->user_id);
            $sucursal = Sucursal::find($sucursal_id);

            $cufd = SiatCufd::where('sucursal_id', $sucursal_id)
                ->whereDate('fecha_vigencia', '>=', $fecha)
                ->orderBy('id', 'desc')
                ->first();
            /* return  response()->json($cufd); */

            $cufd->numero_factura++;
            $cufd->save();
            /*  */
            $cufService =  new CufService();
            $obj = new LeyendaFactura();
            $leyenda = $obj->getLeyenda();


            $dataCuf = [
                "nitEmisor" => 166172023, /* Nit de la empresa */
                "codigoSucursal" => $sucursal->codigo_fiscal, // "codigoSucursal" => $sucursal->codigo_fiscal,
                "codigoDocumentoSector" => DocumentTypes::FACTURA_COMPRA_VENTA,
                "numeroFactura" => $cufd->numero_factura,
                "codigoPuntoVenta" => $puntoVenta,
                "fechaEmision" => $request->evento_significativo_id == null ? date('Y-m-d\TH:i:s.v') : new Carbon($request->fecha_emision_manual . "T" . $request->hora_emision_manual . ".000000Z"),
                "modalidad" => ServicioSiat::MOD_ELECTRONICA_ENLINEA,
                "tipoEmision" => $request->evento_significativo_id == null ? SiatInvoice::TIPO_EMISION_ONLINE : SiatInvoice::TIPO_EMISION_OFFLINE,
                "tipoFactura" => SiatInvoice::FACTURA_DERECHO_CREDITO_FISCAL,
                "codigoControl" => $cufd->codigo_control,
            ];

            $cuf = $cufService->buildCuf($dataCuf);

            /* print_r($request->fecha_emision_manual + " " + $request->hora_emision_manual); */
            $fecha_emision_manual = $request->fecha_emision_manual != null && $request->hora_emision_manual != null ? new Carbon($request->fecha_emision_manual . "T" . $request->hora_emision_manual . ".000000Z") : "";
            /* return response()->json($fecha_emision_manual); */
            $ventaData = collect([
                'user_id' => $request->user_id,
                'total_venta' => $request->total_venta,
                'total_descuento' => $request->total_descuento,
                'total_neto' => $request->total_venta - $request->total_descuento,
                'tipo_pago' => $request->tipo_pago,
                'lugar' => $request->lugar,
                'delivery' => $request->delivery,
                'turno_id' => $request->turno_id,
                'cliente_id' => $cliente->id,
                'sucursal' => $sucursal_id,
                'tipo_pago' => $request->tipo_pago,
                'codigo_control' => $request->codigo_control,
                'qr' => $request->qr,
                'numero_factura' => $cufd->numero_factura,
                'evento_significativo_id' => $request->evento_significativo_id,
                'leyenda_factura_id' => $leyenda->id,
                'documento_identidad_id' => $request->documento_identidad_id,
                'cuf' => $cuf,
                'cufd_id' => $cufd->id,
                "fechaEmision" => $fecha_emision_manual == "" ? $dataCuf['fechaEmision'] : $fecha_emision_manual,
            ]);

            $ventaService = new VentaService();
            $venta = $ventaService->registrarVenta($ventaData);
            foreach ($request->detalle_venta as $detalle) {
                $ventaService->registrarDetalleVenta($detalle, $venta->id);
            }

            $registro_visita = RegistroVisita::create([
                'fecha' => $fecha,
                'registro_contador' => $sucursal_id == 18 ? $cantidad_visitas : 0, //HABILITADO PARA PIRAI, SINO SERA 0
                'cliente_id' => $cliente->id,
                'venta_id' => $venta->id,
            ]);

            if ($cliente->contador_visitas == 10) {
                $cantidad_visitas = 0;
                $cliente->contador_visitas = $cantidad_visitas;
                $cliente->save();
            }

            DB::commit();

            $dataFactura = [
                'cliente' => $cliente,
                'sucursal' => $sucursal,
                'user' => $user,
                'venta' => $venta,
                'detalle_venta' => DetalleVenta::where('venta_id', $venta->id)->orderBy('plato_id', 'asc')->get(),
            ];




            $mailFacturacionController = new MailFacturacionController();
            if (!isset($request->evento_significativo_id) || $request->evento_significativo_id == 2) {
                $emisionIndividualController = new EmisionIndividualController();
                $response = $emisionIndividualController->emisionIndividual($dataFactura, $request->evento_significativo_id, $codigoExcepcion);
                if (!isset($request->evento_significativo_id)) {
                    if ($response->RespuestaServicioFacturacion->codigoEstado == 908) {
                        $venta->update([
                            'estado_emision' => 'V', /* Validada */
                        ]);
                    } else {
                        $venta->update([
                            'estado_emision' => 'R', /* Rechazada */
                        ]);
                    }
                }
                $qrcode = base64_encode(QrCode::format('svg')
                    ->size(120)
                    ->errorCorrection('H')
                    ->generate('https://pilotosiat.impuestos.gob.bo/consulta/QR?nit=166172023&cuf=' . $venta->cuf . '&numero=' . $venta->numero_factura . '&t=1'));

                $hora  = new Carbon($venta->hora_venta);
                $fecha = new Carbon($venta->fecha_venta);
                $leyenda_factura = LeyendaFactura::all()->random(1)->first();

                $total_texto = $numero_letras->convertir(floatval($venta->total_neto));
                $detalle_venta = DetalleVenta::where('venta_id', $venta->id)
                    ->orderBy('detalles_ventas.plato_id')
                    ->get();

                $pdf = PDF::loadView('mails.FacturaVaucherPDF', [
                    "clienteNombre" => $cliente->nombre,
                    "clienteCorreo" => $cliente->correo,
                    "clienteNit" => $cliente->ci_nit,
                    "ClienteComplemento" => $cliente->complemento,
                    "ClienteId" => $cliente->id,
                    "venta" => $venta,
                    "detalle_venta" => $detalle_venta,
                    "sucursal" => $sucursal,
                    "qrcode" => $qrcode,
                    "hora" => $hora->isoFormat('H:mm'),
                    'fecha' => $fecha->format('Y-m-d'),
                    'total' => $total_texto,
                    'leyenda' => $leyenda_factura
                ]);
                $pdf->setPaper([0, 0, 950.98, 280.05], 'landscape'); // 3er parametro es Height - altura

                $data = [
                    "clienteNombre" => $cliente->nombre,
                    "clienteCorreo" => $cliente->correo,
                    "venta" => $venta,
                    "detalle_venta" => $request->detalle_venta,
                ];

                $mailFacturacionController->sendEmail($data, $pdf);
                return response()->json([
                    'status' => true,
                    'msg' => "Venta registrada Exitosamente",
                    'factura' => $dataFactura,
                    'response_siat' => isset($response) ? $response : "",
                    'cantidad_visitas' => $cliente->contador_visitas,
                    'cliente' => $cliente,
                    'cuf' => $cuf,
                    'idcliente' => $cliente->id,
                    'leyenda' => $leyenda,
                    'nro_factura' => $cufd->numero_factura,

                ])->header('Content-Type', 'application/json');
            } else {
                return response()->json([
                    'status' => true,
                    'msg' => "Venta registrada Exitosamente",
                    'factura' => $dataFactura,
                    'cantidad_visitas' => $cliente->contador_visitas,
                    'cliente' => $cliente,
                    'cuf' => $cuf,
                    'idcliente' => $cliente->id,
                    'leyenda' => $leyenda,
                    'nro_factura' => $cufd->numero_factura,

                ])->header('Content-Type', 'application/json');
            }
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage(),
                'linea' => $e->getLine(),
                'file_name' => $e->getFile()
            ])->header('Content-Type', 'application/json');
        }
    }
}
