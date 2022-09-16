<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use Illuminate\Http\Request;
use App\Models\Sucursal;
use App\Models\User;
use App\Models\Departamento;
use App\Models\Pago;
use App\Models\RetrasoFalta;
use App\Models\Vacacion;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $compras_prov = Compra::with('proveedor')->get();
        $cant_usuarios = User::count();
        $cant_areas = Departamento::count();
        $cant_sucursales = Sucursal::count();
        $cant_retrasosFaltas = RetrasoFalta::count();
        $cant_vacaciones = Vacacion::count();
        $cant_compras = Compra::count();
        $cant_pagos= Pago::count();


        return view('home', compact('cant_usuarios','cant_areas','cant_sucursales',
        'cant_retrasosFaltas','cant_vacaciones','cant_compras','cant_pagos', 'compras_prov'));
    }
  
}
