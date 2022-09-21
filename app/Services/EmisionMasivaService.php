<?php

namespace App\Services;

use App\Models\Siat\SiatCui;
use Carbon\Carbon;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SiatFactory;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\SiatInvoice;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioSiat;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioFacturacionComputarizada;

class EmisionMasivaService
{

	public $cuisService;
	public $cufdService;
	public $configService;
	public $emisionPaqueteService;

	public function __construct()
	{
		$this->cuisService = new CuisService();
		$this->cufdService = new CufdService();
		$this->configService = new ConfigService();
		$this->emisionPaqueteService = new EmisionPaqueteService();
	}

	function pruebasEmisionMasiva()
	{
		$fecha =  (new  Carbon())->now();
		/* $fechaEmision		= date("Y-m-d\TH:i:s.v"); */
		$fechaEmision = $fecha->format("Y-m-d\TH:i:s.v");
		$cantidad 			= 1000;
		$codigoSucursal 	= 0;
		$codigoPuntoVenta 	= 0;
		$cafc				= "1011917833B0D";

		for ($i = 0; $i < 20; $i++) {

			$facturas = $this->emisionPaqueteService->construirFacturas($codigoSucursal, $codigoPuntoVenta, $cantidad, $this->configService->documentoSector, $this->configService->codigoActividad, $this->configService->codigoProductoSin, $fechaEmision);
			$fechaEmision = date("Y-m-d\TH:i:s.v", strtotime($fechaEmision) + 5000);
			$res = $this->testMasiva($codigoSucursal, $codigoPuntoVenta, $this->configService->documentoSector, $facturas, $this->configService->tipoFactura);
			print_r($res);

			if ($res->RespuestaServicioFacturacion->codigoEstado == 901) {
				$res = $this->testRecepcionMasiva(
					$codigoSucursal,
					$codigoPuntoVenta,
					$this->configService->documentoSector,
					$this->configService->tipoFactura,
					$res->RespuestaServicioFacturacion->codigoRecepcion,
				);
				/* 	dd($res); */
				print_r($res);

				/* return $res; */
				/* dd($res->RespuestaServicioFacturacion->codigoRecepcion); */
			}
		}
	}

	function testMasiva($codigoSucursal, $codigoPuntoVenta, $documentoSector, $facturas, $tipoFactura)
	{
		$resCuis = $this->cuisService->obtenerCuis($codigoPuntoVenta, $codigoSucursal);
		$resCufd = $this->cufdService->obtenerCufd($codigoPuntoVenta, $codigoSucursal, $resCuis->RespuestaCuis->codigo);
		/* dd($resCuis,$resCufd); */

		echo "Codigo CUIS: ", $resCuis->RespuestaCuis->codigo, "\n";
		echo "Codigo CUFD: ", $resCufd->RespuestaCufd->codigo, "\n";
		echo "Codigo Control: ", $resCufd->RespuestaCufd->codigoControl, "\n";

		$service = SiatFactory::obtenerServicioFacturacion($this->configService->config, $resCuis->RespuestaCuis->codigo, $resCufd->RespuestaCufd->codigo, $resCufd->RespuestaCufd->codigoControl);
		/* dd($service);  */
		$res = $service->recepcionMasivaFactura($facturas, SiatInvoice::TIPO_EMISION_MASIVA, $tipoFactura);
		/* dd($res); */
		/* print_r($res); */
		return $res;
	}

	function testRecepcionMasiva($codigoSucursal, $codigoPuntoVenta, $documentoSector, $tipoFactura, $codigoRecepcion)
	{
		$resCuis = $this->cuisService->obtenerCuis($codigoPuntoVenta, $codigoSucursal);
		$resCufd = $this->cufdService->obtenerCufd($codigoPuntoVenta, $codigoSucursal, $resCuis->RespuestaCuis->codigo);
		/* echo "Codigo CUIS: ", $resCuis->RespuestaCuis->codigo, "\n";
	    echo "Codigo CUFD: ", $resCufd->RespuestaCufd->codigo, "\n";
	    echo "Codigo Control: ", $resCufd->RespuestaCufd->codigoControl, "\n"; */

		$service = new ServicioFacturacionComputarizada(
			$resCuis->RespuestaCuis->codigo,
			$resCufd->RespuestaCufd->codigo
		);
		$service->setConfig((array) $this->configService->config);
		//$service->codigoControl = $resCufd->RespuestaCufd->codigoControl;
		$res = $service->validacionRecepcionMasivaFactura($codigoSucursal, $codigoPuntoVenta, $codigoRecepcion, $tipoFactura, $documentoSector);
		while ($res->RespuestaServicioFacturacion->codigoDescripcion == 'PENDIENTE') {
			echo "REINTENTANTO RESPUESTA RECEPCION MASIVA\n=====================\n";
			$res = $this->testRecepcionMasiva($codigoSucursal, $codigoPuntoVenta, $documentoSector, $tipoFactura, $codigoRecepcion);
			print_r($res);
		}

		echo "RESPUESTA RECEPCION MASIVA\n===================\n";

		return $res;
	}
}
