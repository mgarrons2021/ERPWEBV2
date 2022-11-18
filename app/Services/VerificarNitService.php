<?php

namespace App\Services;

use App\Models\Siat\SiatCui;
use Carbon\Carbon;


use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioFacturacionNit;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioSiat;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SiatConfig;

class VerificarNitService
{
    public $configService;


    public function __construct()
    {
        $this->configService = new ConfigService();
    }

    public function verificarNit($cuis, $codigoSucursal = 0, $nit)
    {
        $serviceNit = new ServicioFacturacionNit(null, null, $this->configService->config->modalidad, $this->configService->config->nit);
        $serviceNit->debug = true;
        $serviceNit->setConfig((array)$this->configService->config);
        $serviceNit->cuis = $cuis;
        $resNit = $serviceNit->verificarNit($codigoSucursal, $nit);

        return $resNit;
    }

    function hasConnectionPing()
    {
        exec("ping -c 1 google.com", $output, $result);
        return ($result === 0) ? TRUE : FALSE;
    }


    public function hasConnection()
    {
        $ch = curl_init("https://www.google.com");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpcode >= 200 && $httpcode < 300) {
            return response()->json("There is a good connection");
        } else {
            return response()->json("Failed to connect the intenet");
        }
        /* return ($httpcode>=200 && $httpcode<300) ? TRUE : FALSE; */
    }
}
