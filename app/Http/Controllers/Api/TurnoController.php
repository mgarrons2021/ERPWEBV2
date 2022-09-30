<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Venta;
use App\Models\Sucursal;
use App\Models\Siat\SiatCui;
use Illuminate\Http\Request;
use App\Models\TurnoIngreso;
use App\Models\Siat\SiatCufd;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SiatConfig;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioSiat;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioFacturacionCodigos;


class TurnoController extends Controller
{
    public $config;

    public function __construct()
    {
        $this->config = new SiatConfig([
            'nombreSistema' => 'MAGNOREST',
            'codigoSistema' => '722907F2BAECC0B26025FE7',
            'nit'           =>  166172023,
            'razonSocial'   => 'DONESCO S.R.L',
            'modalidad'     => ServicioSiat::MOD_ELECTRONICA_ENLINEA,
            'ambiente'      => ServicioSiat::AMBIENTE_PRUEBAS,
            'tokenDelegado'    => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJET05FU0NPXzAyMyIsImNvZGlnb1Npc3RlbWEiOiI3MjI5MDdGMkJBRUNDMEIyNjAyNUZFNyIsIm5pdCI6Ikg0c0lBQUFBQUFBQUFETTBNek0wTnpJd01nWUE3bHFjcHdrQUFBQT0iLCJpZCI6NTE5NjgyLCJleHAiOjE2NjQ1ODI0MDAsImlhdCI6MTY2MDgyOTA0NCwibml0RGVsZWdhZG8iOjE2NjE3MjAyMywic3Vic2lzdGVtYSI6IlNGRSJ9.8ubSTM8oYEuY7pHiNQYbNj6I87koRUqzOqsQ341VMKwA8Y_A9nh_qA4ttCdY-6HywevMQ4Ov64I-w7S3k47NYw',
            'pubCert'        => MOD_SIAT_DIR . SB_DS . 'certs' . SB_DS . 'terminalx' . SB_DS . 'DONESCO_SRL_CER.pem',
            'privCert'        => MOD_SIAT_DIR . SB_DS . 'certs' . SB_DS . 'terminalx' . SB_DS . 'DONESCO_S.R.L._CER.pem',
            'telefono'        => '34345435',
            'ciudad'        => 'SANTA CRUZ GC'
        ]);
    }

    public function turn_register(Request $request)
    {
        $user = $request->user_id;
        $user_id = User::find($request->user_id);
        $sucursal = Sucursal::find($request->sucursal_id);
        $codigoPuntoVenta  = 0;
        $fecha_generado_cufd = Carbon::now()->toDateTimeString();
        $fecha = Carbon::now()->format('Y-m-d H:i');
        $turno_am = DB::select("select turno from turnos_ingresos where fecha = '$fecha' and user_id = '$user' and turno = 0 and sucursal_id='$sucursal->id' ");
        if ($turno_am == null) {
            $turno = new TurnoIngreso();
            $turno->fecha = Carbon::now();
            $turno->estado = 1; /* Si es abierto y cerrado el turno */
            $turno->turno = 0;  /* AM  */
            $turno->hora_inicio = Carbon::now()->format('H:i:s');
            $turno->user_id = $user;
            $turno->sucursal_id = $sucursal->id;
            $turno->nro_transacciones = 0;
            $turno->save();

            /* CREA CUFD CUANDO SE INGRESA NUEVO TURNO */

            $cuis = SiatCui::where('sucursal_id', $sucursal->id)->first();

            if (is_null($cuis)) {
                $response =  $this->obtenerCuis($codigoPuntoVenta, $sucursal->codigo_fiscal);
                $obtener_cui = SiatCui::create([
                    'fecha_generado' => $fecha,
                    'fecha_expiracion' =>  new Carbon($response->RespuestaCuis->fechaVigencia),
                    'codigo_cui' => $response->RespuestaCuis->codigo,
                    'sucursal_id' => $sucursal->id,
                    'estado' => 'V' /* Vigente */
                ]);
                $resCufd =  $this->obtenerCufd($codigoPuntoVenta, $sucursal->codigo_fiscal, $obtener_cui->codigo_cui, true);
            } else {
                $resCufd =  $this->obtenerCufd($codigoPuntoVenta, $sucursal->codigo_fiscal, $cuis->codigo_cui, true);
            }

            if($resCufd->RespuestaCufd->transaccion == true){

                $guardar_cufd = SiatCufd::create([
                    'estado' => "V",
                    'codigo' => $resCufd->RespuestaCufd->codigo,
                    'codigo_control' => $resCufd->RespuestaCufd->codigoControl,
                    'direccion' => $resCufd->RespuestaCufd->direccion,
                    'fecha_vigencia' => new Carbon($resCufd->RespuestaCufd->fechaVigencia),
                    'fecha_generado' => $fecha_generado_cufd,
                    'sucursal_id' => $user_id->sucursals[0]->id,
                    'numero_factura' => 0
                ]);

                /* Invalidar Cufds anteriores */
                $cufds_anteriores = SiatCufd::where('fecha_vigencia','>',$fecha_generado_cufd)
                ->where('sucursal_id',$sucursal->id)
                ->where('id' ,'<>',$guardar_cufd->id)
                ->update(['estado'=> 'N']);  /* No vigente */ 
            }



            $response = [
                'success' => true,
                'tt' => $turno_am,
                'responseSiat' => $resCufd,
                'turno_id' => $turno->id
            ];
        } else {
            $turno = new TurnoIngreso();
            $turno->fecha = Carbon::now();
            $turno->estado = 1; /* Si es abierto y cerrado el turno */
            $turno->turno = 1;  /* PM */
            $turno->hora_inicio = Carbon::now()->format('H:i:s');
            $turno->user_id = $user;
            $turno->sucursal_id = $sucursal;
            $turno->save();

            $response = [
                'success' => true,
                'tt' => $turno_am,
                'turno_id' => $turno->id,
            ];
        }
        return response()->json($response);
    }


    public function update_state_turn(Request $request)
    {
        $id = $request->id;
        $state = $request->state;
        $turno = TurnoIngreso::find($id);
        if ($state == "Abrir") {
            //turno estado : 1 es abierto
            $turno->estado = 1;
            $turno->save();
            return response()->json([
                'status' => true,
                'msg' => "Habilitado Correctamente",
            ])->header('Content-Type', 'application/json');
        } else if ($state == "Cerrar") {
            //turno estado : 0 es cerrado
            $turno->estado = 0;
            $turno->save();
            return response()->json([
                'status' => true,
                'msg' => "Inhabilitado Correctamente",
            ])->header('Content-Type', 'application/json');
        }
    }

    public function get_tax_sales(Request $request)
    {
        //0 Anulado : 1 Habilitado
        $turno_id = $request->turno_id;
        $sucursal_id = $request->sucursal_id;
        $ventas_fiscales = Venta::selectRaw('categorias_plato.nombre, sum(detalles_ventas.cantidad) as cantidad, sum(detalles_ventas.subtotal) as subtotal')
            ->join('detalles_ventas', 'detalles_ventas.venta_id', '=', 'ventas.id')
            ->join('platos', 'platos.id', '=', 'detalles_ventas.plato_id')
            ->join('platos_sucursales', 'platos_sucursales.plato_id', '=', 'platos.id')
            ->join('categorias_plato', 'categorias_plato.id', '=', 'platos_sucursales.categoria_plato_id')
            ->join('turnos_ingresos', 'turnos_ingresos.id', '=', 'ventas.turnos_ingreso_id')
            ->where('ventas.turnos_ingreso_id', $turno_id)
            ->where('ventas.estado', 1)
            ->where('platos_sucursales.sucursal_id', $sucursal_id)
            ->where('ventas.tipo_pago', "<>", 'Comida Personal')
            ->where('ventas.tipo_pago', "<>", 'Comida Personal')
            ->groupBy(['categorias_plato.nombre'])
            ->get();

        $turno = TurnoIngreso::find($turno_id);

        $fact_first = Venta::select('numero_factura')->where('turnos_ingreso_id', $turno_id)->where('tipo_pago', '<>', 'Comida Personal')->orderBy('id', 'asc')->limit(1)->first();
        $fact_last = Venta::select('numero_factura')->where('turnos_ingreso_id', $turno_id)->where('tipo_pago', '<>', 'Comida Personal')->orderBy('id', 'desc')->limit(1)->first();

        $json = [
            'ventas_fiscales' => $ventas_fiscales,
            'fecha' => $turno->fecha,
            'hora_inicio' => $turno->hora_inicio,
            'hora_fin' => $turno->hora_fin != null ? $turno->hora_fin : "00:00:00",
            'turno' => $turno->turno == 0 ? "AM" : "PM",
            'primera_venta' => $fact_first,
            'ultima_venta' => $fact_last
        ];

        return  response($json, 200)->header('Content-Type', 'application/json');
    }

    public function get_transaction(Request $request)
    {
        $turno = TurnoIngreso::find($request->turno_id);

        return  response(['nro_transaccion' => $turno->nro_transacciones != null ? $turno->nro_transacciones : 0], 200)->header('Content-Type', 'application/json');
    }

    public function check_open_turn(Request $request)
    {
        //turno estado : 1 es abierto - turno estado : 0 es cerrado
        $sucursal_id = $request->sucursal_id;
        $fecha_actual = Carbon::now()->format('Y-m-d');
        $turno = TurnoIngreso::where('sucursal_id', $sucursal_id)
            ->where('fecha', $fecha_actual)
            ->where('estado', 1)
            ->first();

        if (!is_null($turno)) {
            return  response(["status" => true, "msj" => "Ya existe un Turno Abierto"], 200)->header('Content-Type', 'application/json');
        } else {
            return  response(["status" => false, "msj" => "No hay Turnos Abiertos"], 200)->header('Content-Type', 'application/json');
        }
    }

    public function get_open_turn(Request $request)
    {

        $sucursal_id = $request->sucursal_id;
        $fecha_actual = Carbon::now()->format('Y-m-d');
        $turno = TurnoIngreso::where('sucursal_id', $sucursal_id)
            ->where('fecha', $fecha_actual)
            ->where('estado', 1)
            ->first();

        return response(["turno" => $turno != null ? $turno : []], 200)->header('Content-Type', 'application/json');
    }

    function obtenerCuis($codigoPuntoVenta, $codigoSucursal, $new = false)
    {
        $serviceCodigos = new ServicioFacturacionCodigos(null, null, $this->config->tokenDelegado);
        $serviceCodigos->debug = true;
        $serviceCodigos->setConfig((array)$this->config);
        $resCuis = $serviceCodigos->cuis($codigoPuntoVenta, $codigoSucursal);
        /*  dd($resCuis); */
        return $resCuis;
    }

    function obtenerCufd($codigoPuntoVenta, $codigoSucursal, $cuis, $new = false)
    {

        $serviceCodigos = new ServicioFacturacionCodigos(null, null, $this->config->tokenDelegado);
        $serviceCodigos->setConfig((array)$this->config);
        $serviceCodigos->cuis = $cuis;
        $resCufd = $serviceCodigos->cufd($codigoPuntoVenta, $codigoSucursal);

        return $resCufd;
    }
}
