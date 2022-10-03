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
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\DocumentTypes;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\SiatInvoice;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioSiat;

use Letras as GlobalLetras;

class VentaController extends Controller
{
    public function registerSale(Request $request)
    {
        try {
            DB::beginTransaction();
            $fecha = Carbon::now()->toDateString();
            $hora_actual = Carbon::now()->toTimeString();
            $modalidad = 1; //Electronica en linea
            $tipoEmision = 1; //EN LINEA
            $tipoFactura = 1; //Factura derecho credito fiscal
            $cantidad_visitas = 1;
            $sucursal_id = $request->sucursal;
            $puntoVenta = 0;

            /*  return response()->json($request->nit_ci); */

            $clienteData = [
                'cliente' => $request->cliente,
                'ci_nit' => $request->nit_ci,
                'telefono' => $request->telefono,
                'empresa' => $request->empresa,
                'sucursal' => $request->sucursal,
                'correo' => $request->correo,
                'cantidad_visitas' => $cantidad_visitas,
            ];

            $clienteService = new ClienteService();
            $numero_letras= new  Letras();
            

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
                "fechaEmision" => date('Y-m-d\TH:i:s.v'),
                "modalidad" => ServicioSiat::MOD_ELECTRONICA_ENLINEA,
                "tipoEmision" => SiatInvoice::TIPO_EMISION_ONLINE,
                "tipoFactura" => SiatInvoice::FACTURA_DERECHO_CREDITO_FISCAL,
                "codigoControl" => $cufd->codigo_control,
            ];

            $cuf = $cufService->buildCuf($dataCuf);


            /*  return response()->json( ["cuf"=>$cufService->cabecera->cuf]); */
            $ventaData = collect([
                'user_id' => $request->user_id,
                'total_venta' => $request->total_venta,
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
                'cuf' => $cuf,
                'cufd_id' => $cufd->id,
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
                'detalle_venta' => $request->detalle_venta,
            ];

            $mailFacturacionController = new MailFacturacionController();
            if (!isset($request->evento_significativo_id)) {
                $emisionIndividualController = new EmisionIndividualController();
                $response = $emisionIndividualController->emisionIndividual($dataFactura);
                if ($response->RespuestaServicioFacturacion->codigoEstado == 908) {
                    $venta->update([
                        'estado_emision' => 'V', /* Validada */
                    ]);
                } else {
                    $venta->update([
                        'estado_emision' => 'R', /* Rechazada */
                    ]);
                }
                // https://pilotosiat.impuestos.gob.bo/consulta/QR?nit=166172023&cuf=B5EB51F7ABA0DDF3C1BD0727A4BC50D1693F379A01B424663B3D6D74&numero=57&t=1
                $qrcode = base64_encode(QrCode::format('svg')
                    ->size(120)
                    ->errorCorrection('H')
                    ->generate('https://pilotosiat.impuestos.gob.bo/consulta/QR?nit=166172023&cuf=' . $venta->cuf . '&numero=' . $venta->numero_factura . '&t=1'));

                $hora  = new Carbon( $venta->hora_venta );
                $fecha = new Carbon( $venta->fecha_venta ); 

                $total_texto = $numero_letras->convertir( $venta->total_venta );

                $pdf = PDF::loadView('mails.FacturaPDF', [
                    "clienteNombre" => $cliente->nombre,
                    "clienteCorreo" => $cliente->correo,
                    "clienteNit" => $cliente->ci_nit,
                    "venta" => $venta,
                    "detalle_venta" => $request->detalle_venta,
                    "sucursal" => $sucursal,
                    "qrcode" => $qrcode,
                    "hora"=> $hora->format('h:i'),
                    'fecha'=>$fecha->format('Y-m-d'),
                    'total'=>$total_texto
                ]);

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
                    'response_siat' => $response,
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
