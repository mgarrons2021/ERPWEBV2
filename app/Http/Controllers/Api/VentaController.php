<?php

namespace App\Http\Controllers\Api;

use Error;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Sucursal;
use App\Models\DetalleVenta;
use App\Models\TurnoIngreso;
use App\Models\Autorizacion;
use Illuminate\Http\Request;
use App\Services\CufService;
use App\Models\Siat\SiatCufd;
use App\Models\Siat\LeyendaFactura;
use App\Services\VentaService;
use App\Models\RegistroVisita;
use App\Services\ClienteService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailFacturacionController;
use App\Http\Controllers\Siat\EmisionIndividualController;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\DocumentTypes;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\SiatInvoice;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioSiat;
use PDF;

class VentaController extends Controller
{
    public function registerSale(Request $request)
    {
        
        try {
            DB::beginTransaction();
            $fecha = Carbon::now()->toDateString();
            $hora_actual = Carbon::now()->toTimeString();
            $modalidad = 2; //Computarizada en linea
            $tipoEmision = 1; //EN LINEA
            $tipoFactura = 1; //Factura derecho credito fiscal

            $cantidad_visitas = 1;
            $sucursal_id = $request->sucursal;

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
                "codigoPuntoVenta" => 1,
                "fechaEmision" => date('Y-m-d\TH:i:s.v'),
                "modalidad" => ServicioSiat::MOD_COMPUTARIZADA_ENLINEA,
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




/*             $mailFacturacionController = new MailFacturacionController();

            $pdf = PDF::loadView('mails.FacturaPDF', [
                "clienteNombre" => $cliente->nombre,
                "clienteCorreo" => $cliente->correo,
                "venta" => $venta,
                "detalle_venta" => $request->detalle_venta,
            ]);
            $data = [
                "clienteNombre" => $cliente->nombre,
                "clienteCorreo" => $cliente->correo,
                "venta" => $venta,
                "detalle_venta" => $request->detalle_venta,
            ];

            $mailFacturacionController->sendEmail($data, $pdf); */

            $emisionIndividualController = new EmisionIndividualController();
            $response = $emisionIndividualController->emisionIndividual($dataFactura);

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
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage(),
            ])->header('Content-Type', 'application/json');
        }
    }
}
