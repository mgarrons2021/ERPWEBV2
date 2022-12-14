<?php

namespace App\Http\Controllers\Siat;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Venta;
use App\Custom\Letras;
use App\Models\Cliente;
use App\Models\Sucursal;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use App\Models\Siat\SiatCui;
use App\Services\CuisService;
use App\Services\CufdService;
use App\Models\Siat\SiatCufd;
use App\Services\ConfigService;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\EmisionPaqueteService;
use App\Models\Siat\EventoSignificativo;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Services\EventoSignificativoService;
use App\Http\Controllers\MailFacturacionController;
use App\Models\Contingencia;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SiatFactory;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\SiatInvoice;

class EventoSignificativoController extends Controller
{
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

    public function generar_evento_significativo(Request $request)
    {

        $arrayVentas = [];
        $ventas = json_decode($request->ventas);
        /*  dd($ventas); */
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
        /* dd($arrayVentas[0]['detalle_venta'][0]->plato); */
        $evento_significativo = EventoSignificativo::find($ventas[0]->evento_significativo_id);
        /*  dd($evento_significativo); */
        $sucursal = 0;
        $puntoventa = 0;
        $cantidadFacturas = count($ventas);
        $arrayEventosCafc = array(5, 6, 7);
        $codigoEvento = $evento_significativo->codigo_clasificador;
        $cafc     = in_array($codigoEvento, $arrayEventosCafc) ? "1011917833B0D" : null;  /* Maybe el CAFC doesnt belongs to the new system register????? */
        $fecha_generica = Carbon::now();
        $sucursal_db = Sucursal::where('codigo_fiscal', $sucursal)->first();
        $cufd_bd = SiatCufd::find($ventas[0]->cufd_id);
        $cuis_bd     = SiatCui::where('fecha_expiracion', '>=', $fecha_generica)
            ->where('sucursal_id', $sucursal_db->id)
            ->orderBy('id', 'desc')
            ->first();
        /* dd($cufd_bd); */
        $cufdAntiguo = $cufd_bd->codigo;
        $resCuis = $cuis_bd->codigo_cui;

        $codigoControlAntiguo     = $cufd_bd->codigo_control;

        $resCufd        = $this->cufdService->obtenerCufd($puntoventa, $sucursal, $resCuis);
        /*  dd($resCufd); */
        $fecha_generado_cufd = Carbon::now()->toDateTimeString();

        $guardar_cufd = SiatCufd::create([
            'estado' => "V",
            'codigo' => $resCufd->RespuestaCufd->codigo,
            'codigo_control' => $resCufd->RespuestaCufd->codigoControl,
            'direccion' => $resCufd->RespuestaCufd->direccion,
            'fecha_vigencia' => new Carbon($resCufd->RespuestaCufd->fechaVigencia),
            'fecha_generado' => $fecha_generado_cufd,
            'sucursal_id' => $sucursal_db->id,
            'numero_factura' => 0
        ]);
        SiatCufd::where('estado', 'V')
            ->where('id', '<>', $guardar_cufd->id)
            ->where('sucursal_id', $sucursal_db->id)
            ->update(['estado' => 'N']);

        $fechaFin        = Carbon::now();
        $pvfechaInicio     = (new Carbon($request->fecha_inicio))->format("Y-m-d\TH:i:s.v");
        $pvfechaFin        = (new Carbon($request->fecha_fin))->format("Y-m-d\TH:i:s.v");

        $evento         = $this->emisionPaqueteService->obtenerListadoEventos($sucursal, $puntoventa, $codigoEvento);
        $resEvento         = $this->emisionPaqueteService->registroEvento(
            $resCuis,
            $resCufd->RespuestaCufd->codigo,
            $sucursal,
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
        $codigoExcepcion = 1;
        /*  $this->emisionPaqueteService->test_log($resEvento); */
        $facturas         = $this->emisionPaqueteService->construirFacturas2(
            $sucursal,
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

        $res = $this->emisionPaqueteService->testPaquetes($sucursal, $puntoventa, $facturas, $codigoControlAntiguo, $this->configService->tipoFactura, $resEvento->RespuestaListaEventos, $cafc);
        /* print_r( "TestPaquete" + $res); */

        if (isset($res->RespuestaServicioFacturacion->codigoRecepcion)) {
            $res = $this->emisionPaqueteService->testRecepcionPaquete($sucursal, $puntoventa, $this->configService->documentoSector, $this->configService->tipoFactura, $res->RespuestaServicioFacturacion->codigoRecepcion);
            if (isset($res->RespuestaServicioFacturacion)) {
                if ($res->RespuestaServicioFacturacion->codigoEstado == 908) {
                    foreach ($ventas as $venta) {
                        $venta_db = Venta::find($venta->id);
                        $venta_db->estado_emision = "V";
                        $venta_db->save();
                        if ($venta_db->evento_significativo_id != 2) {
                            $this->enviarCorreoaCliente($venta);
                        }
                    }
                } else {
                    if ($res->RespuestaServicioFacturacion->codigoEstado == 904) {
                        foreach ($ventas as $venta) {
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
    public function show($id)
    {
        $detalleContingencias = Venta::where('contingencia_id', $id)->get();
        //  dd($detalleContingencias);
        return view('siat.eventos_significativos.show', compact('detalleContingencias'));
    }


    public function index()
    {
        $fecha_actual = Carbon::now()->toDateString();
        $eventos_significativos = EventoSignificativo::all();

        // $ventas = Venta::where('sucursal_id', Auth::user()->sucursals[0]->id)
        //     ->where('fecha_venta', (new Carbon())->toDateString())
        //     ->where('estado', 1)
        //     ->where('estado_emision', 'P')
        //     ->where('evento_significativo_id', "<>", null)
        //     ->get();

        $contingencias = Contingencia::where('fecha_inicio_contingencia', $fecha_actual)->where('evento_significativo_id', 2)->get();




        // return view('siat.eventos_significativos.index', compact('eventos_significativos', 'ventas', 'fecha_actual'));
        return view('siat.eventos_significativos.index', compact('eventos_significativos', 'contingencias', 'fecha_actual'));
    }

    public function filtrarEventosSignificativos(Request $request)
    {
        $fecha_inicial = $request->fecha_inicial;
        $fecha_final = $request->fecha_final;

        $evento_significativo = EventoSignificativo::find($request->evento_significativo_id);
        $fecha_actual = Carbon::now()->toDateString();
        $eventos_significativos = EventoSignificativo::all();

        $contingencias = Contingencia::where('evento_significativo_id', $request->evento_significativo_id)
            ->whereBetween('fecha_inicio_contingencia', [$fecha_inicial, $fecha_final])
            ->get();
        // $ventas = Venta::where('sucursal_id', Auth::user()->sucursals[0]->id)
        //     ->whereBetween('fecha_venta', [$fecha_inicial, $fecha_final])
        //     ->where('ventas.evento_significativo_id', $evento_significativo->id)
        //     ->where('estado', 1)
        //     ->where('estado_emision', 'P')
        //     ->where('ventas.evento_significativo_id', "<>", null)
        //     ->get();

        return view('siat.eventos_significativos.index', compact('eventos_significativos', 'contingencias', 'fecha_actual'));
    }

    public function enviarCorreoaCliente($venta)
    {

        $venta = Venta::find($venta->id);
        $fecha = new Carbon($venta->created_at);
        $hora = new Carbon($venta->created_at);

        $sucursal = Sucursal::find($venta->sucursal_id);
        $cliente = Cliente::find($venta->cliente_id);
        $detalle_venta = DetalleVenta::where('venta_id', $venta->id)->get();

        $numero_letras = new  Letras();
        $mailFacturacionController = new MailFacturacionController();

        $total_texto = $numero_letras->convertir(floatval($venta->total_neto));
        $qrcode = base64_encode(QrCode::format('svg')
            ->size(120)
            ->errorCorrection('H')
            ->generate('https://pilotosiat.impuestos.gob.bo/consulta/QR?nit=166172023&cuf=' . $venta->cuf . '&numero=' . $venta->numero_factura . '&t=1'));

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
            "hora" => $hora->format('h:i'),
            'fecha' => $fecha->format('Y-m-d'),
            'total' => $total_texto
        ]);
        $pdf->setPaper([0, 0, 950.98, 280.05], 'landscape');
        $data = [
            "clienteNombre" => $cliente->nombre,
            "clienteCorreo" => $cliente->correo,
            "venta" => $venta,
            "detalle_venta" => $detalle_venta,
        ];

        $mailFacturacionController->sendEmail($data, $pdf);
    }
}
