<?php

namespace App\Services;

use App\Models\Siat\SiatCui;
use Carbon\Carbon;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioFacturacionConexionImpuesto;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioFacturacionNit;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioSiat;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SiatConfig;

class VerificarConexionService
{
    public $configService;


    public function __construct()
    {
        $this->configService = new ConfigService();
    }

    public function verificarConexionImpuestos()
    {
        $serviceConection = new ServicioFacturacionConexionImpuesto(null, null, null, null);
        $res = $serviceConection->verificarComunicacion();

        return $res;
    }
}
