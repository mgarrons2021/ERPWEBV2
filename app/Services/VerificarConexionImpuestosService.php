<?php

namespace App\Services;

use App\Models\Siat\SiatCui;
use Carbon\Carbon;


use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioFacturacionConexionImpuesto;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioSiat;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SiatConfig;

class VerificarConexionImpuestosService
{
    public $configService;


    public function __construct()
    {
        $this->configService = new ConfigService();
    }

    public function verificarComunicacion()
    {
        $serviceCommunication = new ServicioFacturacionConexionImpuesto();
        $testConnection = $serviceCommunication->verificarComunicacion();
        return $testConnection;
    }

    
}
