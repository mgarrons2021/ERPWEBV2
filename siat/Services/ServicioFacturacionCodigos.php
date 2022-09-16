<?php

namespace SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services;

/**
 * Clases para el servicio de obtencion de codigos CUIS y CUF
 * @author mac
 *
 */
class ServicioFacturacionCodigos extends ServicioSiat
{
	protected $wsdl = 'https://pilotosiatservicios.impuestos.gob.bo/v2/FacturacionCodigos?wsdl';

	public function cuis($codigoPuntoVenta = 0, $codigoSucursal = 0)
	{
		$data = [
			[
				'SolicitudCuis' => [
					'codigoAmbiente'	=> $this->ambiente,
					'codigoModalidad'	=> $this->modalidad,
					'codigoPuntoVenta'	=> $codigoPuntoVenta,
					'codigoSistema'		=> $this->codigoSistema,
					'codigoSucursal'	=> $codigoSucursal,
					'nit'				=> $this->nit,
				]
			]
		];
		list(, $action) = explode('::', __METHOD__);
		$res = $this->callAction($action, $data);

		return  $res;
	}
	public function cufd($codigoPuntoVenta = 0, $codigoSucursal = 0)
	{
		list(, $action) = explode('::', __METHOD__);
		$data = [
			[
				'SolicitudCufd' => [
					'codigoAmbiente'	=> $this->ambiente,
					'codigoModalidad'	=> $this->modalidad,
					'codigoPuntoVenta'	=> $codigoPuntoVenta,
					'codigoSistema'		=> $this->codigoSistema,
					'codigoSucursal'	=> $codigoSucursal,
					'cuis'				=> $this->cuis,
					'nit'				=> $this->nit,
				]
			]
		];
		$res = $this->callAction($action, $data);

		return $res;
	}
}
