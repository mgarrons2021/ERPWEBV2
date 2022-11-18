<?php

namespace SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services;

/**
 * Clase para el servicio de Verificar Comunicacion con el servidor de Impuestos
 * @author Patrick
 *
 */
class ServicioFacturacionConexionImpuesto extends ServicioSiat
{
	protected $wsdl = 'https://pilotosiatservicios.impuestos.gob.bo/v2/ServicioFacturacionElectronica?wsdl';

	public function verificarComunicacion()
	{
		$data = [
			
		];
		
		list(, $action) = explode('::', __METHOD__);
		$res = $this->callAction($action, $data);


		return  $res;
	}
}
