<?php

namespace App\Services;

use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SiatConfig;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\DocumentTypes;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\SiatInvoice;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioSiat;

class ConfigService
{
    public $config;

    public $sucursal             = 0;
    public $puntoventa           = 1;
    public $cantFacturas        = 1000; /* Cantidad factura para hacer pruebas */
    public $codigoEvento        = 0;
    public $evento             = null;
    /* public $fechaEmision        = date("Y-m-d\TH:i:s.v"); */
    public $codigoActividad    = '561110';  //SERVICIOS DE SUMINISTRO DE COMIDA CON SERVICIO
    public $codigoProductoSin    = '63310'; //COMPLETO DE RESTAURANTE 
    public $documentoSector    = DocumentTypes::FACTURA_COMPRA_VENTA;
    public $tipoFactura        = SiatInvoice::FACTURA_DERECHO_CREDITO_FISCAL;
    public $cafc                 = null;
    /* public $cafc                 = "1011917833B0D"; */
    public $resEvento             = null;

    public function __construct()
    {
        $this->config = new SiatConfig([
            'nombreSistema' => 'MAGNORESTv2',
            'codigoSistema' => '72422DD433BE8177DC71FE6',
            'nit'           =>  166172023,
            'razonSocial'   => 'DONESCO S.R.L',
            'modalidad'     => ServicioSiat::MOD_ELECTRONICA_ENLINEA,  /* Electronica en linea */ 
            'ambiente'      => ServicioSiat::AMBIENTE_PRUEBAS,
            'pubCert'        => MOD_SIAT_DIR . SB_DS . 'certs' . SB_DS . 'terminalx' . SB_DS . 'DONESCO_SRL_CER.pem',
            'privCert'        => MOD_SIAT_DIR . SB_DS . 'certs' . SB_DS . 'terminalx' . SB_DS . 'DONESCO_S.R.L..pem',
            'tokenDelegado' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJET05FU0NPXzAyMyIsImNvZGlnb1Npc3RlbWEiOiI3MjQyMkRENDMzQkU4MTc3REM3MUZFNiIsIm5pdCI6Ikg0c0lBQUFBQUFBQUFETTBNek0wTnpJd01nWUE3bHFjcHdrQUFBQT0iLCJpZCI6NTE5NjgyLCJleHAiOjE2NjcyNjA4MDAsImlhdCI6MTY2NTI0MDIyOCwibml0RGVsZWdhZG8iOjE2NjE3MjAyMywic3Vic2lzdGVtYSI6IlNGRSJ9.5ZkQ6815VtUXK07ieWTBit6roArGNK2ZIq90W7TdGhzUnotYE7C31nSv-XrifFTSVrEKRgtwiNlDie8wdkrMJg',
            'telefono'      => '34345435',
            'ciudad'        => 'SANTA CRUZ GC'

        ]);
    }
}
