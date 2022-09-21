<?php

namespace App\Http\Controllers\Siat;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Siat\SiatCufd;
use App\Models\Siat\SiatCui;
use App\Models\Sucursal;
use App\Services\ConfigService;
use App\Services\CufdService;
use App\Services\CuisService;
use App\Services\EmisionIndividualService;
use App\Services\EmisionPaqueteService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmisionPaqueteController extends Controller
{

    public $configService;
    public $cuisService;
    public $cufdService;
    public $emisionIndividualService;
    public $emisionPaqueteService;

    public function __construct()
    {
        $this->configService = new ConfigService();
        $this->cuisService = new CuisService();
        $this->cufdService = new CufdService();
        $this->emisionIndividualService = new EmisionIndividualService();
        $this->emisionPaqueteService = new EmisionPaqueteService();
    }

    public function emisionPaquetes(Request $request)
    {
        $sucursal = 0;
        $puntoventa = 1;
        
        $cantidad = 2;  /* CANTIDAD FACTURAS */
        $cafc     = "1011917833B0D"; //'101B4283AAD6D';
        $codigoEvento = 1;
        $fecha_generica = Carbon::now();
        $sucursal_db = Sucursal::where('codigo_fiscal', $sucursal)->first();
        $cufd_bd = SiatCufd::find($request->cufd_id);

        $cuis_bd     = SiatCui::where('fecha_expiracion', '>=', $fecha_generica)
            ->where('sucursal_id', $sucursal_db->id)
            ->orderBy('id', 'desc')
            ->first();
        $cufdAntiguo = $cufd_bd->codigo;
        $resCuis = $cuis_bd->codigo_cui;

        $codigoControlAntiguo     = $cufd_bd->codigo_control;

        $resCufd        = $this->cufdService->obtenerCufd($puntoventa, $sucursal, $resCuis);
        $fecha_generado_cufd = Carbon::now()->toDateTimeString();
        /*  dd($resCufd); */
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

        /* for ($i = 0; $i < 70; $i++) { */
        # code...
        /*   dd($cufd_bd); */
        $fechaFin        = Carbon::now();
        $pvfechaInicio     = (new Carbon($cufd_bd->fecha_generado))->addMinutes(2)->format("Y-m-d\TH:i:s.v");
        $pvfechaFin        = (new Carbon($cufd_bd->fecha_generado))->addMinutes(4)->format("Y-m-d\TH:i:s.v");
        /*   dd($pvfechaInicio, $pvfechaFin); */
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
            print_r($resEvento);
            die("No se pudo registrar el evento significativo\n");
        }
        $this->emisionPaqueteService->test_log($resEvento);
        $facturas         = $this->emisionPaqueteService->construirFacturas(
            $sucursal,
            $puntoventa,
            $cantidad,
            $this->configService->documentoSector,
            $this->configService->codigoActividad,
            $this->configService->codigoProductoSin,
            $pvfechaInicio,
            $cufdAntiguo,
        );


        $res = $this->emisionPaqueteService->testPaquetes($sucursal, $puntoventa, $facturas, $codigoControlAntiguo, $this->configService->tipoFactura, $resEvento->RespuestaListaEventos, $cafc);
        if (isset($res->RespuestaServicioFacturacion->codigoRecepcion)) {
            $res = $this->emisionPaqueteService->testRecepcionPaquete($sucursal, $puntoventa, $this->configService->documentoSector, $this->configService->tipoFactura, $res->RespuestaServicioFacturacion->codigoRecepcion);
            print_r($res);
        }

        $this->emisionPaqueteService->test_log($pvfechaInicio);
        $this->emisionPaqueteService->test_log($pvfechaFin);
        /* } */
    }
}
