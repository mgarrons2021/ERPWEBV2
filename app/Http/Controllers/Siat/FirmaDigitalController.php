<?php

namespace App\Http\Controllers\siat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CuisService;
use App\Services\CufdService;
use App\Services\FirmaDigitalService;

class FirmaDigitalController extends Controller
{
    public function generar_firma_digital(){
        $firma_digital = new FirmaDigitalService();
        $res = $firma_digital->pruebasFirma();
        return $res;
    }
}
