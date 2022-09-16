<?php

namespace App\Services;


use App\Models\Siat\SiatCui;
use App\Models\Siat\SiatCufd;
use App\Models\Venta;
use Carbon\Carbon;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Request;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\SiatInvoice;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioFacturacionComputarizada;




class AnulacionFacturaService
{
	public function __construct()
	{
		$this->cuisService = new CuisService();
		$this->cufdService = new CufdService();
		$this->configService = new ConfigService();
		$this->emisionIndividualService = new EmisionIndividualService();
	}

	function pruebasAnulacion($cuf, $motivo,$sucursal_id)
	{
		/* dd($cuf,$motivo); */
		$fecha_actual =  Carbon::now()->toDateString();
		$puntoventa = 0;
		$sucursal = 0;
		$resCuis 	= SiatCui::where('fecha_expiracion','>=',$fecha_actual)
		->where('sucursal_id',$sucursal_id)
		->orderBy('id','desc')->first();

		$resCufd = SiatCufd::where('sucursal_id',$sucursal_id)
		->whereDate('fecha_vigencia','>=',$fecha_actual)
		->orderBy('id','desc')->first();
		

		$res = $this->testAnular($sucursal_id,$motivo, $cuf, $sucursal, $puntoventa, $this->configService->tipoFactura, SiatInvoice::TIPO_EMISION_ONLINE, $this->configService->documentoSector);
		/* dd($res); */
		return $res;
	}

	function testAnular($sucursal_id,$motivo,  $cuf, $sucursal, $puntoventa, $tipoFactura, $tipoEmision, $documentoSector)
	{
		$fecha_actual =  Carbon::now()->toDateString();

		$resCuis 	= SiatCui::where('fecha_expiracion','>=',$fecha_actual)
		->where('sucursal_id',$sucursal_id)
		->orderBy('id','desc')->first();

		$resCufd = SiatCufd::where('sucursal_id',$sucursal_id)
		->whereDate('fecha_vigencia','>=',$fecha_actual)
		->orderBy('id','desc')->first();

		$service = new ServicioFacturacionComputarizada();
		$service->setConfig((array)$this->configService->config);
		$service->cufd = $resCufd->codigo;
		$service->cuis = $resCuis->codigo_cui;
		/* dd($motivo,$cuf,$sucursal,$puntoventa);  */
		/* dd($motivo); */
		$res = $service->anulacionFactura($motivo, $cuf, $sucursal, $puntoventa, $tipoFactura, $tipoEmision, $documentoSector);
		return $res;
	}
}