<?php

namespace App\Http\Controllers\Siat;

use Carbon\Carbon;
use App\Models\Venta;
use Illuminate\Http\Request;
use App\Services\CuisService;
use App\Services\CufdService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\Siat\EventoSignificativo;
use App\Services\EventoSignificativoService;
use App\Services\EmisionPaqueteService;
use App\Models\Siat\SiatCufd;
use App\Services\ConfigService;
use App\Models\Siat\SiatCui;
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
        $fecha_actual = Carbon::now()->toDateString();
        $ventas = json_decode($request->ventas);
        foreach ($ventas as $venta) {
            $cliente = Cliente::find($venta->cliente_id);
            $sucursal = Cliente::find($venta->cliente_id);
            $user = Cliente::find($venta->user_id);
            $venta_db = Venta::find($venta->id);
            $detalle_venta = DetalleVenta::where('venta_id', $venta->id)->get();
            $dataFactura = [
                'cliente' => $cliente,
                'sucursal' => $sucursal,
                'user' => $user,
                'venta' => $venta_db,
                'detalle_venta' => $detalle_venta,
            ];
        }
    //   dd($ventas);
        $detalles_venta = DetalleVenta::where('venta_id', $venta->id)->get();

        $cafc            = "1011917833B0D";
        $puntoventa      = 0;
        $codigo_evento   = $ventas[0]->evento_significativo_id;

        $evento = EventoSignificativo::where('id', $codigo_evento)->first();

        $sucursal = $ventas[0]->sucursal_id;

        $cufd = SiatCufd::where('sucursal_id', $sucursal)
            ->where('fecha_vigencia', '<=', $fecha_actual)
            ->orderBy('id', 'desc')->first();

        $fecha_inicio_contingencia = $request->fecha_inicio;
        $fecha_final_contingencia = $request->fecha_fin;

        $evento_significativoService = new EventoSignificativoService();
        $response = $evento_significativoService->pruebasEventos2($codigo_evento, $sucursal, $fecha_inicio_contingencia, $fecha_final_contingencia);

        /* Funcion para mandar las facturas por paquete */
        /* $res = $this->testPaquetes($sucursal, $puntoventa, $ventas, $cufd, $this->configService->tipoFactura, $evento, $cafc); */

        return $response;
    }

    function testPaquetes($codigoSucursal, $codigoPuntoVenta, array $facturas, $codigoControlAntiguo, $tipoFactura, $evento, $cafc)
    {
        $fecha_actual = Carbon::now()->toDateString();

        $resCufd = SiatCufd::where('fecha_vigencia', '>=', $fecha_actual)
            ->where('sucursal_id', $codigoSucursal)
            ->orderBy('id', 'desc')
            ->first();


        $resCuis     = SiatCui::where('fecha_expiracion', '>=', $fecha_actual)
            ->where('sucursal_id', $codigoSucursal)
            ->orderBy('id', 'desc')
            ->first();
        //var_dump('CUIS PRIMARIO: ' . $resCuis->RespuestaCuis->codigo);

        if (!$evento)
            die('ERROR: No se encontro el evento');

        $service = SiatFactory::obtenerServicioFacturacion($this->configService->config, $resCuis->codigo_cui, $resCufd->codigo, $codigoControlAntiguo);

        //$service->setConfig((array)$config);
        //$service->codigoControl = $codigoControlAntiguo;
      //  dd($facturas);
        $res = $service->recepcionPaqueteFactura(
            $facturas,
            $evento->codigoRecepcionEventoSignificativo,
            SiatInvoice::TIPO_EMISION_OFFLINE,
            $tipoFactura,
            $cafc
        );
        /*  return dd($res); */
        $this->test_log("RESULTADO RECEPCION PAQUETE\n=============================");
        $this->test_log($res);
        return $res;
    }

    public function index()
    {
        $fecha_actual = Carbon::now()->toDateString();
        $eventos_significativos = EventoSignificativo::all();

        $ventas = Venta::where('sucursal_id', Auth::user()->sucursals[0]->id)
            ->where('fecha_venta', (new Carbon())->toDateString())
            ->where('estado', 1)
            ->get();

        return view('siat.eventos_significativos.index', compact('eventos_significativos', 'ventas', 'fecha_actual'));
    }

    public function filtrarEventosSignificativos(Request $request)
    {

        $fecha_inicial = $request->fecha_inicial;
        $fecha_final = $request->fecha_final;
        $evento_significativo = $request->evento_significativo_id;

        $fecha_actual = Carbon::now()->toDateString();
        $eventos_significativos = EventoSignificativo::all();

        $ventas = Venta::where('sucursal_id', Auth::user()->sucursals[0]->id)
            ->whereBetween('fecha_venta', [$fecha_inicial, $fecha_final])
            ->where('ventas.evento_significativo_id', $evento_significativo)
            ->where('estado', 1)
            ->get();


        return view('siat.eventos_significativos.index', compact('eventos_significativos', 'ventas', 'fecha_actual'));
    }
}
