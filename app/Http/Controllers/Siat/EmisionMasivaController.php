<?php

namespace App\Http\Controllers\siat;

use App\Http\Controllers\Controller;
use App\Services\EmisionMasivaService;
use Illuminate\Http\Request;

class EmisionMasivaController extends Controller
{
    public function generar_emision_masiva(){
        $emision_masiva = new EmisionMasivaService();
        $res=$emision_masiva->pruebasEmisionMasiva();
        return $res;
    }
}
