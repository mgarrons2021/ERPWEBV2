<?php

namespace App\Models;

use App\Models\Siat\EventoSignificativo;
use App\Models\Siat\SiatCufd;
use App\Models\Siat\SiatCui;
use App\Services\ConfigService;
use App\Services\CufdService;
use App\Services\CuisService;
use App\Services\EmisionPaqueteService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use JetBrains\PhpStorm\Internal\ReturnTypeContract;

class TurnoIngreso extends Model
{
    use HasFactory;

    protected $table = 'turnos_ingresos';

    protected $fillable = ['fecha', 'turno', 'estado', 'hora_inicio', 'hora_fin', 'ventas', 'user_id', 'sucursal_id'];

    public $cuisService;
    public $cufdService;
    public $configService;
    public $emisionIndividualService;

    public function __construct()
    {
        $this->cuisService = new CuisService();
        $this->cufdService = new CufdService();
        $this->configService = new ConfigService();
        $this->emisionPaqueteService = new EmisionPaqueteService();
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function getSaleTurn($turnos_ingreso_id)
    {

        //0 : ANULADO 1:VIGENTE
        $fecha = Carbon::now()->toDateString();
        $sql = "select sum(ventas.total_venta) as total_ventas from ventas
        where  turnos_ingreso_id = $turnos_ingreso_id and fecha_venta = '$fecha' and estado = 1";
        $sales = DB::select($sql);
        /* dd($sales); */
        return $sales[0]->total_ventas;
    }

    public function getListTurn($fecha_inicio, $fecha_fin, $sucursal)
    {
        $fecha = Carbon::now()->toDateString();

        if (isset($fecha_inicio) && isset($fecha_fin)) {
            $sql = "select (@rownum:=@rownum+1) AS nro_registro,turnos_ingresos.id, sucursals.nombre as sucursal_nombre, users.name as nombre_usuario,turnos_ingresos.fecha, turnos_ingresos.turno, turnos_ingresos.estado, turnos_ingresos.ventas 
            FROM (SELECT @rownum:=0) r,turnos_ingresos 
            JOIN sucursals on sucursals.id = turnos_ingresos.sucursal_id
            JOIN users on users.id = turnos_ingresos.user_id
            WHERE turnos_ingresos.fecha BETWEEN $fecha_inicio and $fecha_fin 
            and sucursals.id = $sucursal ";
            $lists_turns = DB::select($sql);
            return $lists_turns;
        } else {
            $sql = "select  (@rownum:=@rownum+1) AS nro_registro,sucursals.nombre as sucursal_nombre, users.name as nombre_usuario,turnos_ingresos.fecha, turnos_ingresos.turno, turnos_ingresos.estado, turnos_ingresos.ventas 
            FROM (SELECT @rownum:=0) r,turnos_ingresos 
            JOIN sucursals on sucursals.id = turnos_ingresos.sucursal_id
            JOIN users on users.id = turnos_ingresos.user_id
            WHERE turnos_ingresos.fecha BETWEEN $fecha and $fecha 
            and sucursals.id = $sucursal ";
            $lists_turns = DB::select($sql);
            return $lists_turns;
        }
    }
    public  function close_turn($id_turn, $id_sucursal)
    {

        $res = $this->emitirFacturasFueradeLinea(2, $id_sucursal);
        $ventas = $this->getSaleTurn($id_turn);
        $turno = TurnoIngreso::find($id_turn);
        $hora_fin = Carbon::now()->format('H:i:s');
        $turno->hora_fin = $hora_fin;
        $turno->ventas = $ventas;
        $turno->estado = 0;
        $turno->save();
        return response()->json([
            'status' => true,
            'resp' => $res
        ]);
    }

    public function emitirFacturasFueradeLinea($evento_significativo_id, $sucursal_id)
    {
        $codigoExcepcion = 1;
        $fecha_actual = Carbon::now();
        $evento_significativo = EventoSignificativo::find($evento_significativo_id);
        $sucursal = Sucursal::find($sucursal_id);
        $puntoventa = 0;
        $contingencia = Contingencia::where([
            ['fecha_inicio_contingencia', '>=', $fecha_actual->startOfDay()],
            ['evento_significativo_id', '=', $evento_significativo_id],
            ['Estado', 0] //1 Enviado y 0 Pendiente
        ])->first();
        $contingencia->fecha_fin_contingencia = Carbon::now()->format('Y-m-d');
        $contingencia->hora_fin = ((Carbon::now())->subMinutes(3)->subSeconds(30))->format('H:i:s');
        $contingencia->save();
        $cantidadFacturas = count($contingencia->ventas);
        $arrayEventosCafc = array(5, 6, 7);
        $codigoEvento = $evento_significativo->codigo_clasificador;
        $cafc     = in_array($codigoEvento, $arrayEventosCafc) ? "1011917833B0D" : null;
        $arrayVentas = $this->construirVentas($contingencia->ventas);
        $cufd_bd = SiatCufd::find($contingencia->ventas[0]->cufd_id);
        $cuis_bd     = SiatCui::where('fecha_expiracion', '>=', $fecha_actual)
            ->where('sucursal_id', $sucursal->id)
            ->orderBy('id', 'desc')
            ->first();
        $cufdAntiguo = $cufd_bd->codigo;
        $resCuis = $cuis_bd->codigo_cui;
        $codigoControlAntiguo     = $cufd_bd->codigo_control;
        $pvfechaInicio     = (new Carbon($contingencia->fecha_inicio_contingencia . "T" . $contingencia->hora_ini . ".000000Z"))->format("Y-m-d\TH:i:s.v");
        $pvfechaFin        = (new Carbon($contingencia->fecha_fin_contingencia . "T" . $contingencia->hora_fin . ".000000Z"))->format("Y-m-d\TH:i:s.v");
        $resCufd        = $this->cufdService->obtenerCufd($puntoventa, $sucursal->codigo_fiscal, $resCuis);

        $fecha_generado_cufd = Carbon::now()->toDateTimeString();

        $guardar_cufd = SiatCufd::create([
            'estado' => "V",
            'codigo' => $resCufd->RespuestaCufd->codigo,
            'codigo_control' => $resCufd->RespuestaCufd->codigoControl,
            'direccion' => $resCufd->RespuestaCufd->direccion,
            'fecha_vigencia' => new Carbon($resCufd->RespuestaCufd->fechaVigencia),
            'fecha_generado' => $fecha_generado_cufd,
            'sucursal_id' => $sucursal->id,
            'numero_factura' => 0
        ]);
        SiatCufd::where('estado', 'V')
            ->where('id', '<>', $guardar_cufd->id)
            ->where('sucursal_id', $sucursal->id)
            ->update(['estado' => 'N']);

        $fechaFin        = Carbon::now();
        $evento         = $this->emisionPaqueteService->obtenerListadoEventos($sucursal->codigo_fiscal, $puntoventa, $codigoEvento);
        $resEvento         = $this->emisionPaqueteService->registroEvento(
            $resCuis,
            $resCufd->RespuestaCufd->codigo,
            $sucursal->codigo_fiscal,
            $puntoventa,
            $evento,
            $cufdAntiguo,
            $pvfechaInicio,
            $pvfechaFin
        );
        if (!isset($resEvento->RespuestaListaEventos->codigoRecepcionEventoSignificativo)) {
            /* print_r($resEvento);
            die("No se pudo registrar el evento significativo\n"); */
            return $resEvento;
        }

        $facturas         = $this->emisionPaqueteService->construirFacturas2(
            $sucursal->codigo_fiscal,
            $puntoventa,
            $cantidadFacturas,
            $this->configService->documentoSector,
            $this->configService->codigoActividad,
            $this->configService->codigoProductoSin,
            $pvfechaInicio,
            $cufdAntiguo,
            $cafc,
            $arrayVentas,
            $codigoExcepcion
        );

        $res = $this->emisionPaqueteService->testPaquetes($sucursal->codigo_fiscal, $puntoventa, $facturas, $codigoControlAntiguo, $this->configService->tipoFactura, $resEvento->RespuestaListaEventos, $cafc);

        if (isset($res->RespuestaServicioFacturacion->codigoRecepcion)) {
            $res = $this->emisionPaqueteService->testRecepcionPaquete($sucursal->codigo_fiscal, $puntoventa, $this->configService->documentoSector, $this->configService->tipoFactura, $res->RespuestaServicioFacturacion->codigoRecepcion);
            if (isset($res->RespuestaServicioFacturacion)) {
                if ($res->RespuestaServicioFacturacion->codigoEstado == 908) {
                    $contingencia->Estado = 1;
                    $contingencia->save();
                    foreach ($contingencia->ventas as $venta) {
                        $venta_db = Venta::find($venta->id);
                        $venta_db->estado_emision = "V";
                        $venta_db->save();
                        if ($venta_db->evento_significativo_id != 2) {
                            $this->enviarCorreoaCliente($venta);
                        }
                    }
                } else {
                    if ($res->RespuestaServicioFacturacion->codigoEstado == 904) {
                        $contingencia->Estado = 1;
                        $contingencia->save();
                        foreach ($contingencia->ventas as $venta) {
                            $venta_db = Venta::find($venta->id);
                            $venta_db->estado_emision = "O";
                            $venta_db->save();
                        }
                    }
                }
                return  $res;
            } else {
                return $res;
            }
        } else {
            return response()->json([
                "codigo" => 980,
                "res" => $res,
                "msj" => "Sin Respuesta"
            ]);
        }
    }

    public function construirVentas($ventas)
    {
        $arrayVentas = [];
        foreach ($ventas as $venta) {
            $venta_db = Venta::find($venta->id);
            $cliente = Cliente::find($venta->cliente_id);
            $sucursal = Sucursal::find($venta->sucursal_id);
            $user = User::find($venta->user_id);
            $detalleVenta = DetalleVenta::where('venta_id', $venta->id)->get();
            $dataVenta = [
                'cliente' => $cliente,
                'sucursal' => $sucursal,
                'user' => $user,
                'venta' => $venta_db,
                'detalle_venta' => $detalleVenta,
            ];
            array_push($arrayVentas, $dataVenta);
        }

        return $arrayVentas;
    }
}
