<?php
define('BASEPATH', dirname(__DIR__));
defined('SB_DS') or define('SB_DS', DIRECTORY_SEPARATOR);

require_once 'autoload.php';
require_once dirname(__DIR__) . SB_DS . 'functions.php';

use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SoapMessage;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\CompraVenta;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\SiatInvoice;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioFacturacionCodigos;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioSiat;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SiatConfig;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioFacturacionComputarizada;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\InvoiceDetail;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioOperaciones;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioFacturacionSincronizacion;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioFacturacionElectronica;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\ElectronicaCompraVenta;


class GeneralTest
{
	protected $endpoint = 'https://pilotosiatservicios.impuestos.gob.bo/v2/ServicioFacturacionComputarizada';
	protected	$wsdl = 'https://pilotosiatservicios.impuestos.gob.bo/v2/ServicioFacturacionComputarizada?wsdl';
	
	public static function buildConfig()
	{
		return new SiatConfig([
			/*
			'nombreSistema'	=> '',
			'codigoSistema'	=> '',
			'tipo' 			=> 'PROVEEDOR',
			'nit'			=> 966,
			'razonSocial'	=> '',
			'modalidad' 	=> ServicioSiat::MOD_COMPUTARIZADA_ENLINEA,
			'ambiente' 		=> ServicioSiat::AMBIENTE_PRUEBAS,
			'tokenDelegado'	=> '',
			'cuis'			=> null,
			'cufd'			=> null,
			*/
			/*
			'nombreSistema'	=> 'Acrópolis SGF',
			'codigoSistema'	=> '6D307F64485BE20AEB91C0F',
			'tipo' 			=> 'PROVEEDOR',
			'nit'			=> 9665224017,
			'razonSocial'	=> 'MELGAR PEREZ MARIA SUSANA',
			'modalidad' 	=> ServicioSiat::MOD_COMPUTARIZADA_ENLINEA,
			'ambiente' 		=> ServicioSiat::AMBIENTE_PRUEBAS,
			'tokenDelegado'	=> 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiI5NjY1MjI0MDE3U2MiLCJjb2RpZ29TaXN0ZW1hIjoiNkQzMDdGNjQ0ODVCRTIwQUVCOTFDMEYiLCJuaXQiOiJINHNJQUFBQUFBQUFBTE0wTXpNMU1qSXhNRFFIQUVqTkx5UUtBQUFBIiwiaWQiOjExNDE4MDksImV4cCI6MTY3MDAyNTYwMCwiaWF0IjoxNjM4NTYwOTYzLCJuaXREZWxlZ2FkbyI6OTY2NTIyNDAxNywic3Vic2lzdGVtYSI6IlNGRSJ9.gAtmPtHd5k-WTht22VIUoRd1EfFp9njHHELXBKHBvsJUVi5q6hSuwxyzc0DoBNBnmeIPC44i3_iOazBjP1bzRw',
			'cuis'			=> null,
			'cufd'			=> null,
			//*/
			
			/*
			
			//##
			'nombreSistema'	=> "SAGE",
			//'codigoSistema'	=> "6D305F5B61D8546601743DF",
			'codigoSistema'	=> '6D32E2B9FBF0FE7B3BAC3DF',
			'nit'			=> 243212020,
			'razonSocial'	=> "DESARROLLANDO TECNOLOGIA EFICIENTE D.T.E. S.R.L.",
			'modalidad'		=> ServicioSiat::MOD_COMPUTARIZADA_ENLINEA,
			'ambiente'		=> ServicioSiat::AMBIENTE_PRUEBAS,
			//'tokenDelegado'	=> "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJHQVJDSUFNRURJTkEiLCJjb2RpZ29TaXN0ZW1hIjoiNkQzMDVGNUI2MUQ4NTQ2NjAxNzQzREYiLCJuaXQiOiJINHNJQUFBQUFBQUFBRE15TVRZeU5ESXdNZ0FBUlpqUkhna0FBQUE9IiwiaWQiOjI0NjEyNiwiZXhwIjoxNjQ2MjY1NjAwLCJpYXQiOjE2Mzg1MzM4NzAsIm5pdERlbGVnYWRvIjoyNDMyMTIwMjAsInN1YnNpc3RlbWEiOiJTRkUifQ.9wK4IyHSOBxfyY9_n8ZVJ4nfA5mk-bAXwav9jEFDuAsn82BEOOABysLUEJk5VR7bb7reu1Ymu7hCTC6NuXRIOQ",
			'tokenDelegado'	=> 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJHQVJDSUFNRURJTkEiLCJjb2RpZ29TaXN0ZW1hIjoiNkQzMkUyQjlGQkYwRkU3QjNCQUMzREYiLCJuaXQiOiJINHNJQUFBQUFBQUFBRE15TVRZeU5ESXdNZ0FBUlpqUkhna0FBQUE9IiwiaWQiOjI0NjEyNiwiZXhwIjoxNjQ3ODIwODAwLCJpYXQiOjE2NDAxNzMzMDAsIm5pdERlbGVnYWRvIjoyNDMyMTIwMjAsInN1YnNpc3RlbWEiOiJTRkUifQ.-BZ8--ZnInYtZAWweuF7dRvPyL5Mo_STGsbdM2WVBgu-RhEzLhmR4JrJ-N4TzyduHOdeR7MQ-txwkpgAQSqi6Q',
			'cuis'			=> null,
			'cufd'			=> null,
			*/
			
			'nombreSistema' => "COBOFAR COMERCIAL",
			'codigoSistema' => '71E4E06A36F8587F3BE98A6',
			'nit'           => 1022039027,
			'razonSocial'   => "COBOFAR S.A.",
			'modalidad'     => ServicioSiat::MOD_ELECTRONICA_ENLINEA,
			'ambiente'      => ServicioSiat::AMBIENTE_PRUEBAS,
			'tokenDelegado'	=> 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJDT0JPRkFSU0ExMCIsImNvZGlnb1Npc3RlbWEiOiI3MUU0RTA2QTM2Rjg1ODdGM0JFOThBNiIsIm5pdCI6Ikg0c0lBQUFBQUFBQUFETTBNREl5TUxZME1ESUhBT2ZINEt3S0FBQUEiLCJpZCI6MTIzNjA3LCJleHAiOjE2Nzc4MDE2MDAsImlhdCI6MTY0NjMzMTk5MSwibml0RGVsZWdhZG8iOjEwMjIwMzkwMjcsInN1YnNpc3RlbWEiOiJTRkUifQ._6PUETTgIpYSX0ZZrrfgCdMiclP_AIGuIDEz3lWgRSVwj6FkWi8QVAj77Jz1YPOGvho51PHGI0e8r7W3D36tAg',
			'cuis' => null,
			'cufd' => null,
		]);
	}
	public static function testSoap()
	{
		$endpoint = 'https://pilotosiatservicios.impuestos.gob.bo/v2/ServicioFacturacionComputarizada';
		$soap = new SoapMessage($endpoint);
		$soap->setAction('recepcionPaqueteFactura');
		$xml = $soap->toXml();
		print formatXML($xml->asXML());
		
	}
	public static function buildInvoice($codigoPuntoVenta = 0, $codigoSucursal = 0, $modalidad = 0)
	{
		$subTotal = 0;
		$factura = $modalidad == ServicioSiat::MOD_ELECTRONICA_ENLINEA ? new ElectronicaCompraVenta() : new CompraVenta();
			
		for($i = 0; $i < 2; $i++)
		{
			$detalle = new InvoiceDetail();
			$detalle->cantidad				= 1;
			$detalle->actividadEconomica	= '620200';
			$detalle->codigoProducto		= 'D001';
			$detalle->codigoProductoSin		= 83141; //SERVICIOS DE DISEÑO Y DESARROLLO DE TI PARA APLICACIONES
			$detalle->descripcion			= 'Nombre del producto #0' . ($i + 1);
			$detalle->precioUnitario		= 10;
			$detalle->montoDescuento		= 0;
			$detalle->subTotal				= $detalle->cantidad * $detalle->precioUnitario;
			$subTotal += $detalle->subTotal;
			$factura->detalle[] = $detalle;
		}
		$factura->cabecera->razonSocialEmisor	= '';
		$factura->cabecera->municipio			= 'La Paz';
		$factura->cabecera->telefono			= '88867523';
		$factura->cabecera->numeroFactura		= rand(1, 100);
		$factura->cabecera->codigoSucursal		= $codigoSucursal;
		$factura->cabecera->direccion			= 'Pedro Kramer #109';
		$factura->cabecera->codigoPuntoVenta	= $codigoPuntoVenta;
		$factura->cabecera->fechaEmision		= date('Y-m-d\TH:i:s.v'); 
		$factura->cabecera->nombreRazonSocial	= 'Perez';
		$factura->cabecera->codigoTipoDocumentoIdentidad	= 1; //CI - CEDULA DE IDENTIDAD
		$factura->cabecera->numeroDocumento		= 2287567;
		$factura->cabecera->codigoCliente		= 'CC-2287567';
		$factura->cabecera->codigoMetodoPago	= 1;
		$factura->cabecera->montoTotal			= $subTotal;
		$factura->cabecera->montoTotalMoneda	= $factura->cabecera->montoTotal;
		$factura->cabecera->montoTotalSujetoIva	= $factura->cabecera->montoTotal;
		$factura->cabecera->descuentoAdicional	= 0;
		$factura->cabecera->codigoMoneda		= 1; //BOLIVIANO
		$factura->cabecera->tipoCambio			= 1;
		$factura->cabecera->usuario				= 'MonoBusiness User 01';
		
		return $factura;
	}
	public static function testRecepcionFactura()
	{
		try
		{
			$config = self::buildConfig();
			$config->validate();
			
			$codigoPuntoVenta = 0;
			$codigoSucursal = 0;
			
			$serviceCodigos = new ServicioFacturacionCodigos(null, null, $config->tokenDelegado);
			$serviceCodigos->setConfig((array)$config);
			$resCuis = $serviceCodigos->cuis($codigoPuntoVenta, $codigoSucursal);
			$serviceCodigos->cuis = $resCuis->RespuestaCuis->codigo;
			$resCufd = $serviceCodigos->cufd($codigoPuntoVenta, $codigoSucursal);
			//print_r($resCufd);
			echo "Codigo CUIS: ", $resCuis->RespuestaCuis->codigo, "\n";
			echo "Codigo CUFD: ", $resCufd->RespuestaCufd->codigo, "\n";
			echo "Codigo Control: ", $resCufd->RespuestaCufd->codigoControl, "\n";
			$service = new ServicioFacturacionComputarizada($resCuis->RespuestaCuis->codigo, $resCufd->RespuestaCufd->codigo, $config->tokenDelegado);
			$service->setConfig((array)$config);
			$service->codigoControl = $resCufd->RespuestaCufd->codigoControl;
			$service->debug = true;
			
			$factura = self::buildInvoice($codigoPuntoVenta, $codigoSucursal);
			$res = $service->recepcionFactura($factura);
			print_r($res);
		}
		catch(Exception $e)
		{
			echo "\033[0;31m", $e->getMessage(), "\033[0m", "\n\n";
			print $e->getTraceAsString();
		}
	}
	public static function testRecepcionPaqueteFactura()
	{
		try
		{
			$config = self::buildConfig();
			$config->validate();
			
			$codigoPuntoVenta = 0;
			$codigoSucursal = 0;
			
			$serviceCodigos = new ServicioFacturacionCodigos(null, null, $config->tokenDelegado);
			$serviceCodigos->setConfig((array)$config);
			$resCuis = $serviceCodigos->cuis($codigoPuntoVenta, $codigoSucursal);
			$serviceCodigos->cuis = $resCuis->RespuestaCuis->codigo;
			$resCufd = $serviceCodigos->cufd($codigoPuntoVenta, $codigoSucursal);
			//print_r($resCufd);
			echo "Codigo CUIS: ", $resCuis->RespuestaCuis->codigo, "\n";
			echo "Codigo CUFD: ", $resCufd->RespuestaCufd->codigo, "\n";
			echo "Codigo Control: ", $resCufd->RespuestaCufd->codigoControl, "\n";
			//##obtener listado de eventos
			$serviceSync = new ServicioFacturacionSincronizacion($resCuis->RespuestaCuis->codigo);
			$serviceSync->setConfig((array)$config);
			$eventsList = $serviceSync->sincronizarParametricaEventosSignificativos();
			print_r($eventsList);
			$event = $eventsList->RespuestaListaParametricas->listaCodigos[0];
			$serviceOps = new ServicioOperaciones($resCuis->RespuestaCuis->codigo, $resCufd->RespuestaCufd->codigo);
			$serviceOps->setConfig((array)$config);
			$fechaInicio 	= date('Y-m-d\TH:i:s.v', time() - (86400 * 3));
			$fechaFin 		= date('Y-m-d\T16:00:00', time() - (86400 * 1));
			//##este cufd es cuando paso el evento
			$cufdAntiguo	= '';
			$resEvent = $serviceOps->registroEventoSignificativo($event->codigoClasificador, $event->descripcion, $cufdAntiguo, $fechaInicio, $fechaFin);
			print_r($resEvent);
			$service = new ServicioFacturacionComputarizada($resCuis->RespuestaCuis->codigo, $resCufd->RespuestaCufd->codigo);
			$service->setConfig((array)$config);
			$service->codigoControl = $resCufd->RespuestaCufd->codigoControl;
			$service->debug = true;
			$facturas = [];
			for($i = 0; $i < 5; $i++)
			{
				$factura = self::buildInvoice($codigoPuntoVenta, $codigoSucursal);
				$factura->cabecera->nitEmisor = $config->nit;
				$factura->cabecera->razonSocialEmisor = $config->razonSocial;
				$factura->cabecera->cufd = $resCufd->RespuestaCufd->codigo;
				$factura->buildCuf(
					$codigoSucursal, 
					$config->modalidad, 
					SiatInvoice::TIPO_EMISION_ONLINE, 
					SiatInvoice::FACTURA_DERECHO_CREDITO_FISCAL, 
					$resCufd->RespuestaCufd->codigoControl
				);
				$facturas[] = $factura;
			}
			$res = $service->recepcionPaqueteFactura($facturas, $resEvent->RespuestaListaEventos->codigoRecepcionEventoSignificativo);
			print_r($res);
		}
		catch(Exception $e)
		{
			echo "\033[0;31m", $e->getMessage(), "\033[0m", "\n\n";
			print $e->getTraceAsString();
		}
	}
	public function testRecepcionFacturaElectronica()
	{
		try
		{
			$privCert = MOD_SIAT_DIR . SB_DS . 'certs' . SB_DS . 'privatekey.pem';
			$pubCert = MOD_SIAT_DIR . SB_DS . 'certs' . SB_DS . 'CORPORACION_BOLIVIANA_DE_FARMACIAS_SA_CER.pem';
			$config = self::buildConfig();
			$config->validate();
			
			$codigoPuntoVenta = 0;
			$codigoSucursal = 0;
			
			$serviceCodigos = new ServicioFacturacionCodigos(null, null, $config->tokenDelegado);
			$serviceCodigos->setConfig((array)$config);
			$resCuis = $serviceCodigos->cuis($codigoPuntoVenta, $codigoSucursal);
			$serviceCodigos->cuis = $resCuis->RespuestaCuis->codigo;
			$resCufd = $serviceCodigos->cufd($codigoPuntoVenta, $codigoSucursal);
			//print_r($resCufd);
			echo "Codigo CUIS: ", $resCuis->RespuestaCuis->codigo, "\n";
			echo "Codigo CUFD: ", $resCufd->RespuestaCufd->codigo, "\n";
			echo "Codigo Control: ", $resCufd->RespuestaCufd->codigoControl, "\n";
			$service = new ServicioFacturacionElectronica($resCuis->RespuestaCuis->codigo, $resCufd->RespuestaCufd->codigo, $config->tokenDelegado);
			$service->setConfig((array)$config);
			$service->codigoControl = $resCufd->RespuestaCufd->codigoControl;
			$service->setPrivateCertificateFile($privCert);
			$service->setPublicCertificateFile($pubCert);
			$service->debug = true;
			
			$factura = self::buildInvoice($codigoPuntoVenta, $codigoSucursal, $config->modalidad);
			$res = $service->recepcionFactura($factura);
			print_r($res);
		}
		catch(Exception $e)
		{
			echo "\033[0;31m", $e->getMessage(), "\033[0m", "\n\n";
			print $e->getTraceAsString();
		}
	}
}

date_default_timezone_set('America/La_Paz');

if( !isset($argv) )
	return false;
$actions = [
	"recepcionPaqueteFactura",
	"verificarComunicacion", 
	'recepcionFactura', 
	'RecepcionFacturaElectronica',
	'validacionRecepcionMasivaFactura', 
	'recepcionMasivaFactura',
	'verificacionEstadoFactura',
	'validacionRecepcionPaqueteFactura',
	'anulacionFactura'
];
function showMenu()
{
	global $actions;
	
	echo "\033[0;34m", "Service actions:\n\n";
	foreach($actions as $index => $action)
		echo "\t", ($index +1 ), '. ', $action, "\n";
	echo "\n\n", "\033[0m";
	
}
if( !isset($argv[1]) )
{
	showMenu();
	return false;
}
if( count($argv) >= 2 )
{
	$index = (int)$argv[1] - 1;
	$action = isset($actions[$index]) ? $actions[$index] : null;
	if( !$action )
	{
		echo "\033[0;31m", "ERROR: Invalid action\n\n", "\033[0m";
		showMenu();
		return false;
	}
	$method = ucfirst($action);
	call_user_func(['GeneralTest', 'test'.$method]);
	//GeneralTest::testSoap();
}
