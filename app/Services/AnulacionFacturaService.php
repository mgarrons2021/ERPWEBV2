<?php

namespace App\Services;


use App\Models\Siat\SiatCui;
use App\Models\Siat\SiatCufd;
use App\Models\Venta;
use Carbon\Carbon;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Request;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\SiatInvoice;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioFacturacionComputarizada;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SiatFactory;

class AnulacionFacturaService
{
	public function __construct()
	{
		$this->cuisService = new CuisService();
		$this->cufdService = new CufdService();
		$this->configService = new ConfigService();
		$this->emisionIndividualService = new EmisionIndividualService();
	}

	function pruebasAnulacion($cuf, $motivo, $sucursal_id)
	{
		/* dd($cuf,$motivo); */
		$fecha_actual =  Carbon::now()->toDateString();
		$puntoventa = 1;
		$sucursal = 0;
		$resCuis 	= SiatCui::where('fecha_expiracion', '>=', $fecha_actual)
			->where('sucursal_id', $sucursal_id)
			->orderBy('id', 'desc')->first();

		$resCufd = SiatCufd::where('sucursal_id', $sucursal_id)
			->whereDate('fecha_vigencia', '>=', $fecha_actual)
			->orderBy('id', 'desc')->first();


		$res = $this->testAnular($sucursal_id, $motivo, $cuf, $sucursal, $puntoventa, $this->configService->tipoFactura, SiatInvoice::TIPO_EMISION_ONLINE, $this->configService->documentoSector);
		/* dd($res); */
		return $res;
	}

	function testAnular($sucursal_id, $motivo,  $cuf, $sucursal, $puntoventa, $tipoFactura, $tipoEmision, $documentoSector)
	{
		$fecha_actual =  Carbon::now()->toDateString();

		$resCuis 	= SiatCui::where('fecha_expiracion', '>=', $fecha_actual)
			->where('sucursal_id', $sucursal_id)
			->orderBy('id', 'desc')->first();

		$resCufd = SiatCufd::where('sucursal_id', $sucursal_id)
			->whereDate('fecha_vigencia', '>=', $fecha_actual)
			->orderBy('id', 'desc')->first();

		$service = new ServicioFacturacionComputarizada();
		$service->setConfig((array)$this->configService->config);
		$service->cufd = $resCufd->codigo;
		$service->cuis = $resCuis->codigo_cui;
		/* dd($motivo,$cuf,$sucursal,$puntoventa);  */
		/* dd($motivo); */
		$res = $service->anulacionFactura($motivo, $cuf, $sucursal, $puntoventa, $tipoFactura, $tipoEmision, $documentoSector);
		return $res;
	}

	function testAnular2($motivo, $cuf, $sucursal, $puntoventa, $tipoFactura, $tipoEmision, $documentoSector)
	{

		$resCuis = $this->cuisService->obtenerCuis($puntoventa, $sucursal);
		$resCufd = $this->cufdService->obtenerCufd($puntoventa, $sucursal, $resCuis->RespuestaCuis->codigo);

		$service = new ServicioFacturacionComputarizada();
		$service->setConfig((array)$this->configService->config);
		$service->cuis = $resCuis->RespuestaCuis->codigo;
		$service->cufd = $resCufd->RespuestaCufd->codigo;

		$res = $service->anulacionFactura($motivo, $cuf, $sucursal, $puntoventa, $tipoFactura, $tipoEmision, $documentoSector);

		return $res;
	}

	function testFactura($sucursal, $puntoventa, SiatInvoice $factura, $tipoFactura)
	{
		global $config;

		$resCuis = $this->cuisService->obtenerCuis($puntoventa, $sucursal);
		$resCufd = $this->cufdService->obtenerCufd($puntoventa, $sucursal, $resCuis->RespuestaCuis->codigo);

		echo "Codigo CUIS: ", $resCuis->RespuestaCuis->codigo, "\n";
		echo "Codigo CUFD: ", $resCufd->RespuestaCufd->codigo, "\n";
		echo "Codigo Control: ", $resCufd->RespuestaCufd->codigoControl, "\n";

		$service = SiatFactory::obtenerServicioFacturacion($this->configService->config, $resCuis->RespuestaCuis->codigo, $resCufd->RespuestaCufd->codigo, $resCufd->RespuestaCufd->codigoControl);
		//$service = $config->modalidad == ServicioSiat::MOD_COMPUTARIZADA_ENLINEA ? 
		//	new ServicioFacturacionComputarizada($resCuis->RespuestaCuis->codigo, $resCufd->RespuestaCufd->codigo) :
		//	new ServicioFacturacionElectronica($resCuis->RespuestaCuis->codigo, $resCufd->RespuestaCufd->codigo);
		//$service->setConfig((array)$config);
		$service->codigoControl = $resCufd->RespuestaCufd->codigoControl;
		$res = $service->recepcionFactura($factura, SiatInvoice::TIPO_EMISION_ONLINE, $tipoFactura);
		$this->test_log("RESULTADO RECEPCION FACTURA\n=============================");
		$this->test_log($res);

		return $res;
	}

	function test_log($data, $destFile = null)
	{

		$filename = __DIR__ . '/nit-' . $this->configService->config->nit . ($destFile ? '-' . $destFile : '') . '.log';
		$fh = fopen($filename, is_file($filename) ? 'a+' : 'w+');
		fwrite($fh, sprintf("[%s]#\n%s\n", date('Y-m-d H:i:s'), print_r($data, 1)));
		fclose($fh);
		print_r($data);
	}
}
