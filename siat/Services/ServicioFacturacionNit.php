<?php

namespace SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services;

/**
 * Clase para el servicio de Verificar Nit Valido
 * @author Patrick
 *
 */
class ServicioFacturacionNit extends ServicioSiat
{
	protected $wsdl = 'https://pilotosiatservicios.impuestos.gob.bo/v2/FacturacionCodigos?wsdl';

	public function verificarNit($codigoSucursal = 0, $nitParaVerificacion)
	{


		$data = [
			[
				'SolicitudVerificarNit' => [
					'codigoAmbiente'	=> $this->ambiente,
					'codigoModalidad'	=> $this->modalidad,
					'codigoSistema'		=> $this->codigoSistema,
					'codigoSucursal'	=> $codigoSucursal,
					'cuis'	=> $this->cuis,
					'nit'        		 => $this->nit,
					'nitParaVerificacion' => $nitParaVerificacion,
				]
			]
		];
		/* print_r($data); */

		list(, $action) = explode('::', __METHOD__);
		$res = $this->callAction($action, $data);


		return  $res;
	}
}
