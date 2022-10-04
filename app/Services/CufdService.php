<?php

namespace App\Services;

use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioFacturacionCodigos;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioSiat;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SiatConfig;

class CufdService
{

    public $config;
   

    public function __construct()
    {
        $this->config = new SiatConfig([
            'nombreSistema' => 'MAGNOREST',
            'codigoSistema' => '722907F2BAECC0B26025FE7',
            'nit'           => 166172023,
            'razonSocial'   => 'DONESCO S.R.L',
            'modalidad'     => ServicioSiat::MOD_ELECTRONICA_ENLINEA,
            'ambiente'      => ServicioSiat::AMBIENTE_PRUEBAS,
            'tokenDelegado'    => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJET05FU0NPXzAyMyIsImNvZGlnb1Npc3RlbWEiOiI3MjI5MDdGMkJBRUNDMEIyNjAyNUZFNyIsIm5pdCI6Ikg0c0lBQUFBQUFBQUFETTBNek0wTnpJd01nWUE3bHFjcHdrQUFBQT0iLCJpZCI6NTE5NjgyLCJleHAiOjE2NjcxNzQ0MDAsImlhdCI6MTY2NDcxMzUxOSwibml0RGVsZWdhZG8iOjE2NjE3MjAyMywic3Vic2lzdGVtYSI6IlNGRSJ9.dYOJ0EpBGBy_znNjIlkw283FvQif6qFx_x6t8sh7MQ4DEJmLL_bsQNivh2MYg7DAZDK4aRKn8fwu7HEqpEWhNA',
            'pubCert'		=> MOD_SIAT_DIR . SB_DS . 'certs' . SB_DS . 'terminalx' . SB_DS . 'DONESCO_SRL_CER.pem',
	        'privCert'		=> MOD_SIAT_DIR . SB_DS . 'certs' . SB_DS . 'terminalx' . SB_DS . 'DONESCO_S.R.L._CER.pem',  
            'telefono'        => '34345435',
            'ciudad'        => 'SANTA CRUZ GC'
        ]);
    }


    function obtenerCufd($codigoPuntoVenta, $codigoSucursal, $cuis, $new = false)
    {

        $serviceCodigos = new ServicioFacturacionCodigos(null, null, $this->config->tokenDelegado);
        $serviceCodigos->setConfig((array)$this->config);
        $serviceCodigos->cuis = $cuis;
        $resCufd = $serviceCodigos->cufd($codigoPuntoVenta, $codigoSucursal);

        return $resCufd;
    }
}
