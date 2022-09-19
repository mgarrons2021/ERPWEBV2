<?php

namespace App\Services;

use App\Models\Siat\SiatCufd;
use App\Models\Siat\SiatCui;
use App\Models\Sucursal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\SiatInvoice;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioSiat;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioFacturacionElectronica;

class FirmaDigitalService
{
	public $cuisService;
	public $cufdService;
	public function __construct()
	{
		$this->cuisService = new CuisService();
		$this->cufdService = new CufdService();
		$this->configService = new ConfigService();
		$this->emisionIndividualService = new EmisionIndividualService();  /* Methods BuildInvoice and TestInvoice */
	}

	function pruebasFirma()
	{

		$fecha_generica = Carbon::now();
		$sucursal = 0;
		$sucursal_db = Sucursal::where('codigo_fiscal', $sucursal)->first();
		$puntoventa = 1;

		/* $resCuis = $this->cuisService->obtenerCuis($puntoventa, $sucursal); */
		/* $resCufd = $this->cufdService->obtenerCufd($puntoventa, $sucursal, $resCuis->codigo_cui); */

		$resCuis = SiatCui::first();

		//dd($resCuis);

		$resCufd = SiatCufd::where('fecha_vigencia', '>=', $fecha_generica)
			->where('sucursal_id', $sucursal_db->id)
			->orderBy('id', 'desc')
			->first();

		//dd($resCuis);

		/* for ($i = 0; $i < 115; $i++) { */
		$factura = $this->emisionIndividualService->construirFactura($puntoventa, $sucursal,  $this->configService->config->modalidad, $this->configService->documentoSector, $this->configService->codigoActividad, $this->configService->codigoProductoSin);
		//dd($factura);
		$res = $this->testFirma($sucursal, $puntoventa, $factura, $this->configService->tipoFactura);
		//dd($res);
		return $res;
		//die;

	}

	function testFirma($sucursal, $puntoventa, SiatInvoice $factura, $tipoFactura)
	{
		/* 
		$pubCert 	= MOD_SIAT_DIR . SB_DS . 'certs' . SB_DS . 'Patricio_Aguilar_Vargas.pem';
		$privCert 	= MOD_SIAT_DIR . SB_DS . 'certs' . SB_DS . 'PatrickService_Ltda_CER.pem'; */
		//echo $privCert, "\n"; */

		/* $this->configService->config->modalidad = ServicioSiat::MOD_ELECTRONICA_ENLINEA; */
		$fecha_generica = Carbon::now();
		$sucursal_db = Sucursal::where('codigo_fiscal', $sucursal)->first();

		$resCuis = SiatCui::first();
		$resCufd = SiatCufd::where('fecha_vigencia', '>=', $fecha_generica)
			->where('sucursal_id', $sucursal_db->id)
			->orderBy('id', 'desc')
			->first();

		/* echo "Codigo CUIS: ", $resCuis->codigo, "\n";
		echo "Codigo CUFD: ", $resCufd->codigo, "\n";
		echo "Codigo Control: ", $resCufd->codigoControl, "\n";
		dd($resCufd, $resCuis); */

		$service = new ServicioFacturacionElectronica($resCuis->codigo_cui, $resCufd->codigo, $this->configService->config->tokenDelegado);
		$service->setConfig((array)$this->configService->config);
		$service->codigoControl = $resCufd->codigo_control;
		$service->setPrivateCertificateFile($this->configService->config->privCert);
		$service->setPublicCertificateFile($this->configService->config->pubCert);
		/* dd($service); */
		$service->debug = !true;

		$tipoEmision = SiatInvoice::TIPO_EMISION_ONLINE;
		$res = $service->recepcionFactura($factura, $tipoEmision, $tipoFactura);
		/* dd($service); */
		return $res;
	}
}
