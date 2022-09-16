<?php

namespace App\Services;

use App\Models\Siat\SiatCui;
use Carbon\Carbon;

use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioFacturacionCodigos;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioSiat;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SiatConfig;

class CuisService
{
    public $configService;


    public function __construct()
    {
        $this->configService = new ConfigService();
    }

    public function createCuis($response, $sucursal_id)
    {
        $fecha = Carbon::now()->toDateString();
        //980 Devuelve el codigo cuis - 933 devuelve errores
        /* dd($response); */
        if (isset($response->RespuestaCuis->mensajesList)) {
            if ($response->RespuestaCuis->mensajesList->codigo == 980) {
                $siatcui = SiatCui::where('codigo_cui', $response->RespuestaCuis->codigo)->first();
                if (is_null($siatcui)) {
                    $obtener_cui = SiatCui::create([
                        'fecha_generado' => $fecha,
                        'fecha_expiracion' =>  new Carbon($response->RespuestaCuis->fechaVigencia),
                        'codigo_cui' => $response->RespuestaCuis->codigo,
                        'sucursal_id' => $sucursal_id,
                        'estado'=>'V'
                    ]);
                    return ["status"=>true];
                }else{
                    return ["status"=>false,"error"=>"Ya existe un Cuis Vigente"];
                }
            }
        }else{
            return ["status"=>false,"error"=>"Sin Codigo de Respuesta"];
        }
    }

    public function obtenerCuis($codigoPuntoVenta, $codigoSucursal, $new = false)
    {
        $serviceCodigos = new ServicioFacturacionCodigos(null, null, $this->configService->config->tokenDelegado);
        $serviceCodigos->debug = true;
        $serviceCodigos->setConfig((array)$this->configService->config);
        $resCuis = $serviceCodigos->cuis($codigoPuntoVenta, $codigoSucursal);
        /* dd($resCuis); */
        return $resCuis;
    }
}
