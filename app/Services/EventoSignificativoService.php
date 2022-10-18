<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Cargo;
use Carbon\Carbon;
use App\Models\Siat\SiatCufd;
use App\Models\Siat\EventoSignificativo;
use App\Models\Siat\SiatCui;
use App\Models\Sucursal;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioFacturacionSincronizacion;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioOperaciones;

class EventoSignificativoService
{
	public $configService;


	public function __construct()
	{
		$this->cuisService = new CuisService();
		$this->cufdService = new CufdService();
		$this->configService = new ConfigService();
	}

	function pruebasEventos2($codigo_evento, $sucursal, $fecha_inicio_contingencia, $fecha_final_contingencia, $cufd_id)
	{
		$puntoventa = 1;
		$codigoEvento	=  $codigo_evento;
		$fecha_generica = Carbon::now();
		$sucursal_db = Sucursal::find($sucursal);

		$cufd_bd = SiatCufd::find($cufd_id);

		$cuis_bd 	= SiatCui::where('fecha_expiracion', '>=', $fecha_generica)
			->where('sucursal_id', $sucursal)
			->orderBy('id', 'desc')
			->first();

		$cufdAntiguo = $cufd_bd->codigo;
		$resCuis = $cuis_bd->codigo_cui;

		/* $resCuis 	= $this->cuisService->obtenerCuis($puntoventa, $sucursal, true); */

		$resCufd	= $this->cufdService->obtenerCufd($puntoventa, $sucursal_db->codigo_fiscal, $resCuis, true);
		$fecha_generado_cufd = Carbon::now()->toDateTimeString();

		$guardar_cufd = SiatCufd::create([
			'estado' => "V",
			'codigo' => $resCufd->RespuestaCufd->codigo,
			'codigo_control' => $resCufd->RespuestaCufd->codigoControl,
			'direccion' => $resCufd->RespuestaCufd->direccion,
			'fecha_vigencia' => new Carbon($resCufd->RespuestaCufd->fechaVigencia),
			'fecha_generado' => $fecha_generado_cufd,
			'sucursal_id' => Auth::user()->sucursals[0]->id,
			'numero_factura' => 0
		]);

		/* $pvfechaInicio 	= (new Carbon($cufd_bd->fecha_generado))->format("Y-m-d\TH:i:s.v");
		$pvfechaFin		= (new Carbon())->subMinutes(2)->format("Y-m-d\TH:i:s.v"); */

		$pvfechaInicio = (new Carbon($fecha_inicio_contingencia))->format("Y-m-d\TH:i:s.v");
		$pvfechaFin	   =  (new Carbon($fecha_final_contingencia))->format("Y-m-d\TH:i:s.v");
		$evento 	= $this->obtenerListadoEventos($sucursal_db->id, $puntoventa, $codigoEvento);
		$resEvento = $this->registroEvento(
			$cuis_bd->codigo_cui,
			$resCufd->RespuestaCufd->codigo,
			$sucursal_db->codigo_fiscal,
			$puntoventa,
			$evento,
			$cufdAntiguo,
			$pvfechaInicio,
			$pvfechaFin
		);

		return $resEvento;
	}

	function registroEvento($cuis, $cufd, $sucursal, $puntoventa, object  $evento, $cufdAntiguo, $fechaInicio, $fechaFin)
	{

		$re = EventoSignificativo::first();

		/* dd($evento); */
		$serviceOps = new ServicioOperaciones();
		$serviceOps->setConfig((array)$this->configService->config);
		$serviceOps->cuis = $cuis;
		$serviceOps->cufd = $cufd;
		/* dd($serviceOps->cuis,$serviceOps->cufd); */
		/* $resEvent = $serviceOps->consultaEventoSignificativo(0,0,(Carbon::now())->format("Y-m-d\TH:i:s.v")); */

		$resEvent = $serviceOps->registroEventoSignificativo(
			$evento->codigoClasificador,
			$evento->descripcion,
			$cufdAntiguo,
			$fechaInicio,
			$fechaFin,
			$sucursal,
			$puntoventa
		);
		return $resEvent;
	}

	function obtenerListadoEventos($sucursal, $codigoPuntoVenta = 1, $buscarId = 1)
	{
		$fecha_generica = Carbon::now();

		$codigoSucursal = Sucursal::where('id', $sucursal)
			->first();

		$resCuis = SiatCui::where('fecha_expiracion', '>=', $fecha_generica)
			->where('sucursal_id', $codigoSucursal->id)
			->orderBy('id', 'desc')
			->first();

		//##obtener listado de eventos
		$serviceSync = new ServicioFacturacionSincronizacion($resCuis->codigo_cui);

		$serviceSync->setConfig((array)$this->configService->config);
		$serviceSync->cuis = $resCuis->codigo_cui;

		$eventsList = $serviceSync->sincronizarParametricaEventosSignificativos($codigoSucursal->codigo_fiscal, $codigoPuntoVenta);



		if (!$buscarId)
			return $eventsList;
		/* dd($buscarId); */
		$nombre_evento = 'VENTA EN LUGARES SIN INTERNET';
		$evento = null;
		/* dd($eventsList->RespuestaListaParametricas); */
		foreach ($eventsList->RespuestaListaParametricas->listaCodigos as $evt) {
			/* echo( json_encode($evt) );
			echo($buscarId); */
			if ($evt->codigoClasificador == $buscarId) {
				$evento = $evt;
				break;
			}
		}
		/* dd($evento); */
		return $evento;
	}
}
