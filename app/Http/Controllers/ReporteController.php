<?php

namespace App\Http\Controllers;

use App\Models\CajaChica;
use App\Models\CostoGeneral;
use App\Models\CostoTotal;
use App\Models\DetalleCajaChica;
use App\Models\Eliminacion;
use App\Models\ParteProduccion;
use App\Models\PedidoProduccion;
use Carbon\Carbon;
use App\Models\Sucursal;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
  /**
   * Show the profile for a given user.
   *
   * @param  int  $id
   * @return \Illuminate\View\View
   */

  public function index()
  {
    $sucursales = Sucursal::All();
    // $costoTotal = [];

    // $sumaTotal = [];
    // return view('reportes.costo_totales', ['sucursales' => $sucursales, 'costoTotal' => $costoTotal, 'sumaTotal' => $sumaTotal]);
    $ventas = Venta::all();
    return view('reportes.ventas_por_sucursal', ['sucursales' => $sucursales, 'ventas' => $ventas]);
  }
  public function cajaChica(Request $request)
  {
    $id = $request->sucursal;

    $fechaInicio = strtotime($request->fecha_inicial);
    $fechaFin = strtotime($request->fecha_final);

    for ($i = $fechaInicio; $i <= $fechaFin; $i += 86400) {
      $costoTotalDia = new CostoTotal();

      $date = date("Y-m-d", $i);
      $cajaChica = CajaChica::where('sucursal_id', $id)
        ->whereBetween('fecha', [$date, $date])->get('id');
      //este for es para solo 1 Dia
      for ($j = 0; $j < count($cajaChica); ++$j) {
        $consultaDetalleCajaChica = DetalleCajaChica::where('caja_chica_id', $cajaChica[$j]['id'])
          ->join('categorias_caja_chica', 'categoria_caja_chica_id', '=', 'categorias_caja_chica.id')
          ->where('para_costo',1)
          ->get(['categoria_caja_chica_id','egreso']);
       //   echo $consultaDetalleCajaChica . "</br>";
        $sumaDetalle = 0;
        for ($k = 0; $k < count($consultaDetalleCajaChica); ++$k) {
          $sumaDetalle += $consultaDetalleCajaChica[$k]['egreso'];
        }
       // echo $sumaDetalle . "</br>";
      }
    }
  }
  public function porSucursal(Request $request)
  {
    $sucursales = Sucursal::All();
    $id = $request->sucursal;
    $fi = $request->fecha_inicial;
    $ff = $request->fecha_final;

    $ventas = Venta::where('sucursal_id', $id)
      ->whereBetween('fecha_venta', [$fi, $ff])->get();
    return view('reportes.ventas_por_sucursal', ['sucursales' => $sucursales, 'ventas' => $ventas]);
  }

  public function parteProduccion(Request $request)
  {
    $id = $request->sucursal;

    $fechaInicio = strtotime($request->fecha_inicial);
    $fechaFin = strtotime($request->fecha_final);

    $n = 0;
    $costoTotal = [];
    for ($i = $fechaInicio; $i <= $fechaFin; $i += 86400) {
      $costoTotalDia = new CostoTotal();

      //VENTAS
      $date = date("Y-m-d", $i);
      $costoTotalDia['fecha'] = $date;
      $totalVentasDia = Venta::where('sucursal_id', $id)
        ->whereBetween('fecha_venta', [$date, $date])->sum('total_neto');
      $costoTotalDia['ventas'] = $totalVentasDia;
      if ($totalVentasDia != 0) {
        //PRODUCCION ENVIADA
        $produccionEnviada = PedidoProduccion::where('sucursal_pedido_id', $id)
          ->whereBetween('fecha_pedido', [$date, $date])->sum('total_enviado');
        $costoTotalDia['produccion_enviada'] = $produccionEnviada;
        //PORCENTAJE DE PRODUCCION ENVIADA
        $costoTotalDia['porcentaje_produccion_enviada'] = ($produccionEnviada / $totalVentasDia) * 100;
        //PARTE DE PRODUCCION
        $parteProduccion = ParteProduccion::where('sucursal_usuario_id', $id)
          ->whereBetween('fecha', [$date, $date])->sum('total');
        $costoTotalDia['parte_de_produccion'] =  $parteProduccion;

        //PORCENTAJE DE PARTE DE PRODUCCION
        $costoTotalDia['porcentaje_parte_de_prudcuccion'] = ($parteProduccion / $totalVentasDia) * 100;

        //COMPRA DE INSUMOS
        //CAJA CHICA OBTENIENDO EL DETALLE
        /////////////---------- INI CAJA CHICA --------ESTA CONSULTA ME TRAERA UNA POSIBLE COLECCION QUE SE DEBE ITERAR

        $cajaChica = CajaChica::where('sucursal_id', $id)
          ->whereBetween('fecha', [$date, $date])->get('id');

        //este for es para solo 1 Dia
        for ($j = 0; $j < count($cajaChica); ++$j) {
          $consultaDetalleCajaChica = DetalleCajaChica::where('caja_chica_id', $cajaChica[$j]['id'])
            ->get('egreso');

          $sumaDetalle = 0;
          for ($k = 0; $k < count($consultaDetalleCajaChica); ++$k) {
            $sumaDetalle += $consultaDetalleCajaChica[$k]['egreso'];
          }
        }

        $costoTotalDia['compras_de_insumos'] =  $sumaDetalle;

        //////--------- FIN CAJA CHICA---------------

        //PORCENTAJE DE COMPRAS DE INSUMO
        $costoTotalDia['porcentaje_compras_de_insumo'] = ($sumaDetalle / $totalVentasDia) * 100;

        //ELIMINACION
        $eliminacion = Eliminacion::where('sucursal_id', $id)
          ->whereBetween('fecha', [$date, $date])->sum('total');
        $costoTotalDia['eliminaciones'] =  $eliminacion;

        //PORCENTAJE DE ELIMINACION
        $costoTotalDia['porcentaje_eliminaciones'] = ($eliminacion / $totalVentasDia) * 100;
        //COMIDA PERSONAL
        $comidaPersonal = Venta::where('sucursal_id', $id)
          ->where('tipo_pago', 'Comida Personal')
          ->whereBetween('fecha_venta', [$date, $date])->sum('total_neto');
        $costoTotalDia['comida_personal'] =  $comidaPersonal;
        //PORCENTAJE COMIDA PERSONAL
        $costoTotalDia['porcentaje_comida_personal'] = ($comidaPersonal / $totalVentasDia) * 100;
        //TOTAL USO
        $costoTotalDia['total_uso'] = $produccionEnviada + $parteProduccion + $sumaDetalle;
        //TOTAL USO PP
        $costoTotalDia['total_uso_pp'] = ($produccionEnviada + $parteProduccion + $sumaDetalle - $eliminacion - $comidaPersonal);
        //PORCENTAJE TOTAL USO
        $costoTotalDia['porcentaje_total_uso'] = ($costoTotalDia['total_uso'] / $totalVentasDia);
        //PORCENTAJE TOTAL USO PP
        $costoTotalDia['porcentaje_total_uso_pp'] = ($costoTotalDia['total_uso_pp'] / $totalVentasDia);

        $costoTotal[$n] = $costoTotalDia;
        $n = $n + 1;
      }
    }
    $sumaTotal = array("totales", 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

    foreach ($costoTotal as $costo) {
      $sumaTotal[1] += $costo->ventas;
      $sumaTotal[2] += $costo->produccion_enviada;
      $sumaTotal[3] += $costo->porcentaje_produccion_enviada;
      $sumaTotal[4] += $costo->parte_de_produccion;
      $sumaTotal[5] += $costo->porcentaje_parte_de_prudcuccion;
      $sumaTotal[6] += $costo->compras_de_insumos;
      $sumaTotal[7] += $costo->porcentaje_compras_de_insumo;
      $sumaTotal[8] += $costo->eliminaciones;
      $sumaTotal[9] += $costo->porcentaje_eliminaciones;
      $sumaTotal[10] += $costo->comida_personal;
      $sumaTotal[11] += $costo->porcentaje_comida_personal;
      $sumaTotal[12] += $costo->total_uso;
      $sumaTotal[13] += $costo->total_uso_pp;
      $sumaTotal[14] += $costo->porcentaje_total_uso;
      $sumaTotal[15] += $costo->porcentaje_total_uso_pp;
    }
    $sucursales = Sucursal::All();
    return view('reportes.costo_totales', ['sucursales' => $sucursales, 'costoTotal' => $costoTotal, 'sumaTotal' => $sumaTotal]);
  }

  public function comprasInsumo(Request $request)
  {
    /*
    Si se ahumentaran mas categorias que puedan llegar a entrar en los costos generales de cada mes, 
    habría que estar modificando constantemente el codigo
    */
  }
}
