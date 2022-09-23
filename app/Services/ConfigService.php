<?php 

namespace App\Services;

use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SiatConfig;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\DocumentTypes;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\SiatInvoice;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioSiat;

class ConfigService{
    public $config;

    public $sucursal             = 0;
    public $puntoventa           = 0;
    public $cantFacturas        = 1000; /* Cantidad factura para hacer pruebas */
    public $codigoEvento        = 1;
    public $evento             = null;
    /* public $fechaEmision        = date("Y-m-d\TH:i:s.v"); */
    public $codigoActividad    = '561110';  //SERVICIOS DE SUMINISTRO DE COMIDA CON SERVICIO
    public $codigoProductoSin    = '63310'; //COMPLETO DE RESTAURANTE 
    public $documentoSector    = DocumentTypes::FACTURA_COMPRA_VENTA;
    public $tipoFactura        = SiatInvoice::FACTURA_DERECHO_CREDITO_FISCAL;
    /* public $cafc                 = null; */
    public $cafc                 = "1011917833B0D";
    public $resEvento             = null;

    public function __construct()
    {
        $this->config = new SiatConfig([
            'nombreSistema' => 'MAGNOREST',
            'codigoSistema' => '722907F2BAECC0B26025FE7',
            'nit'           =>  166172023,
            'razonSocial'   => 'DONESCO S.R.L',
            'modalidad'     => ServicioSiat::MOD_ELECTRONICA_ENLINEA,  /* Electronica en linea */
            'ambiente'      => ServicioSiat::AMBIENTE_PRUEBAS,
            'pubCert'		=> MOD_SIAT_DIR . SB_DS . 'certs' . SB_DS . 'terminalx' . SB_DS . 'DONESCO_SRL_CER.pem',
	        'privCert'		=> MOD_SIAT_DIR . SB_DS . 'certs' . SB_DS . 'terminalx' . SB_DS . 'DONESCO_S.R.L._CER.pem', 
            'tokenDelegado' =>'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJET05FU0NPXzAyMyIsImNvZGlnb1Npc3RlbWEiOiI3MjI5MDdGMkJBRUNDMEIyNjAyNUZFNyIsIm5pdCI6Ikg0c0lBQUFBQUFBQUFETTBNek0wTnpJd01nWUE3bHFjcHdrQUFBQT0iLCJpZCI6NTE5NjgyLCJleHAiOjE2NjQ1ODI0MDAsImlhdCI6MTY2MDgyOTA0NCwibml0RGVsZWdhZG8iOjE2NjE3MjAyMywic3Vic2lzdGVtYSI6IlNGRSJ9.8ubSTM8oYEuY7pHiNQYbNj6I87koRUqzOqsQ341VMKwA8Y_A9nh_qA4ttCdY-6HywevMQ4Ov64I-w7S3k47NYw',
            'telefono'      => '34345435',
            'ciudad'        => 'SANTA CRUZ GC'

        ]);
    }

}

