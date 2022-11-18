<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\AjusteInventario;
use App\Models\CajaChica;
use App\Models\CostoGeneral;
use App\Models\CostoTotal;
use App\Models\DetalleCajaChica;
use App\Models\DetalleCompra;
use App\Models\DetalleEliminacion;
use App\Models\DetalleInventario;
use App\Models\DetallePedido;
use App\Models\Eliminacion;
use App\Models\Inventario;
use App\Models\ParteProduccion;
use App\Models\Pedido;
use App\Models\PedidoProduccion;
use App\Models\Producto;
use Carbon\Carbon;
use App\Models\Sucursal;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

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
    $costoTotal = [];

    $sumaTotal = [];
    return view('reportes.costo_totales', ['sucursales' => $sucursales, 'costoTotal' => $costoTotal, 'sumaTotal' => $sumaTotal]);
    // $ventas = Venta::all();
    // return view('reportes.ventas_por_sucursal', ['sucursales' => $sucursales, 'ventas' => $ventas]);
  }
  public function inventario(Request $request)
  {
    $id = $request->sucursal;
    $fi = $request->fecha_inicial;
    $ff = $request->fecha_final;
    $sucursales = Sucursal::All();
    //INVENTARIO
    $inventariosAM = Inventario::where('sucursal_id', $id)
      ->where('turno_id', 1)
      ->whereBetween('fecha', [$fi, $ff])
      ->get();
    return view('reportes.ajustes_inventario_index', ['sucursales' => $sucursales, 'inventariosAM' => $inventariosAM]);
  }
  public function show($id, $fecha, $sucursal)
  {
    // echo $fecha . '</br>';
    // echo $sucursal . '</br>';
    //DETALLE INVENTARIO 

    $detallesInventario = DetalleInventario::where('inventario_id', $id)->get(['producto_id', 'stock', 'precio']);
    //COMPRAS
    $compras = Compra::where('sucursal_id', $sucursal)
      ->where('fecha_compra', $fecha)
      ->get(['id', 'fecha_compra']);
    // echo "Todas las Comras: " . $compras . '</br>';
    //DETALLE COMPRAS
    $detalleComprasCollection = new Collection();
    $primeraC = 0;
    foreach ($compras as $key => $compra) {
      $detallesCompras = DetalleCompra::where('compra_id', $compra->id)
        ->get(['producto_id', 'cantidad']);
      // echo "Detalle de esa Compra: " . $detallesCompras . '</br>';
      if ($primeraC > 0) {
        for ($j = 0; $j < count($detallesCompras); $j++) {
          if ($detalleComprasCollection->contains('producto_id', $detallesCompras[$j]->producto_id)) {
            $pos = $this->getPocisionT($detalleComprasCollection, $detallesCompras[$j]->producto_id);
            $detalleComprasCollection[$pos]['cantidad'] += $detallesCompras[$j]->cantidad;
          } else {
            $detalleComprasCollection->push($detallesCompras[$j]);
          }
        }
      } else {
        foreach ($detallesCompras as $key => $comprasD) {
          $detalleComprasCollection->push($comprasD);
        }
        $primeraC++;
      }
    }
    // echo "Colleccition de Detalle Compras" . '</br>';
    // echo $detalleComprasCollection . '</br>';
    //PEDIDOS
    $detallePedidosCollection = new Collection();
    $primeraP = 0;
    $pedidos = Pedido::where('sucursal_principal_id', $sucursal)
      ->where('estado', 'A')
      ->where('fecha_pedido', $fecha)
      ->get(['id', 'fecha_pedido']);
    // echo "Todas los Pedidos: " . $pedidos . '</br>';
    //DETALLE PEDIDOS
    foreach ($pedidos as $key => $pedido) {
      $detallePedidos = DetallePedido::where('pedido_id', $pedido->id)
        ->get(['cantidad_enviada', 'producto_id']);
      //  echo "Detalle de ese Pedido: " . $detallePedidos . '</br>';
      if ($primeraP > 0) {
        for ($j = 0; $j < count($detallePedidos); $j++) {
          if ($detallePedidosCollection->contains('producto_id', $detallePedidos[$j]->producto_id)) {
            $pos = $this->getPocisionT($detallePedidosCollection, $detallePedidos[$j]->producto_id);
            //echo "Ser repite el producto: ".$detallePedidos[$j]->producto_id." En la posicion: ".$pos;
            $detallePedidosCollection[$pos]['cantidad_enviada'] += $detallePedidos[$j]->cantidad_enviada;
          } else {
            $detallePedidosCollection->push($detallePedidos[$j]);
          }
        }
      } else {
        foreach ($detallePedidos as $key => $pedidoD) {
          $detallePedidosCollection->push($pedidoD);
        }
        $primeraP++;
      }
    }
    // echo "Colleccition de Detalle Pedidos" . '</br>';
    // echo $detallePedidosCollection . '</br>';
    //ELIMINACION
    $detalleEliminacionCollection = new Collection();
    $primeraE = 0;
    $eliminaciones = Eliminacion::where('sucursal_id', $sucursal)
      ->where('fecha', $fecha)
      ->get(['id', 'fecha']);
    // echo "Todas los Eliminaciones: " . $eliminaciones . '</br>';
    //DETALLE ELIMINACION
    foreach ($eliminaciones as $key => $eliminacion) {
      $detalleEliminacion = DetalleEliminacion::where('eliminacion_id', $eliminacion->id)
        ->get(['cantidad', 'producto_id']);
      // echo "Detalle de ese Eliminacion: " . $detalleEliminacion . '</br>';
      if ($primeraE > 0) {
        for ($j = 0; $j < count($detalleEliminacion); $j++) {
          if ($detalleEliminacionCollection->contains('producto_id', $detalleEliminacion[$j]->producto_id)) {
            $pos = $this->getPocisionT($detalleEliminacionCollection, $detalleEliminacion[$j]->producto_id);
            //echo "Ser repite el producto: ".$detallePedidos[$j]->producto_id." En la posicion: ".$pos;
            $detalleEliminacionCollection[$pos]['cantidad'] += $detalleEliminacion[$j]->cantidad;
          } else {
            $detalleEliminacionCollection->push($detalleEliminacion[$j]);
          }
        }
      } else {
        foreach ($detalleEliminacion as $key => $eliminacionD) {
          $detalleEliminacionCollection->push($eliminacionD);
        }
        $primeraE++;
      }
    }
    // echo "Colleccition de Detalle Eliminacion" . '</br>';
    // echo $detalleEliminacionCollection . '</br>';
    $detalleDeAjustes = new Collection();
    for ($i = 0; $i < count($detallesInventario); $i++) {
      $ajusteInventario = new AjusteInventario();
      $ajusteInventario['item'] = $detallesInventario[$i]['producto_id'];
      $ajusteInventario['inventario_ini'] = $detallesInventario[$i]['stock'];
      $ajusteInventario['precio'] = $detallesInventario[$i]['precio'];
      $ajusteInventario['compras'] = 0;
      $ajusteInventario['pedido'] = 0;
      $ajusteInventario['eliminacion'] = 0;
      $detalleDeAjustes[$i] =  $ajusteInventario;
    }
    // echo "--------DETALLE AJUTES ANTES DE INSERTAR COMPRAS-----------" . '</br>';
    // echo $detalleDeAjustes . '</br>';
    // echo "--------- mostrando todos los Id de los productos comprados y comparando con los del inventario----------" . '</br>';
    foreach ($detalleComprasCollection as $compra => $value) {
      // echo $value->producto_id . '</br>';
      $posicionItem = $this->getPocision($detalleDeAjustes, $value->producto_id);
      if (!$detalleDeAjustes->contains('item', $value->producto_id)) {
        //armar la estructura
        $ajusteInv = new AjusteInventario();
        $ajusteInv['item'] = $value->producto_id;
        $ajusteInv['inventario_ini'] = 0;
        $ajusteInv['precio'] = 0;
        $ajusteInv['compras'] = $value->cantidad;
        $ajusteInv['pedido'] = 0;
        $ajusteInv['eliminacion'] = 0;
        $detalleDeAjustes->push($ajusteInv);

        // $detalleDeAjustes->push($value->producto_id);

      } else {
        $detalleDeAjustes[$posicionItem]['compras'] = $value->cantidad;
      }
    }
    // echo "--------DETALLE AJUTES DESPUES DE INSERTAR COMPRAS y ANTES DE INSERTAR PEDIDOS-----------" . '</br>';
    // echo $detalleDeAjustes . '</br>';
    foreach ($detallePedidosCollection as $pedidoTurno => $valor) {
      //   echo "producto_id a buscar: " . $valor->producto_id . '</br>';
      $posItem = $this->getPocision($detalleDeAjustes, $valor->producto_id);
      // echo "posicion de productos encontrados: " . $posItem . '</br>';

      if (!$detalleDeAjustes->contains('item', $valor->producto_id)) {
        //armar la estructura
        $ajusteInve = new AjusteInventario();
        $ajusteInve['item'] = $valor->producto_id;
        $ajusteInve['inventario_ini'] = 0;
        $ajusteInve['precio'] = 0;
        $ajusteInve['compras'] = 0;
        $ajusteInve['pedido'] = $valor->cantidad_enviada;
        $ajusteInve['eliminacion'] = 0;
        $detalleDeAjustes->push($ajusteInve);
      } else {
        $detalleDeAjustes[$posItem]['pedido'] = $valor->cantidad_enviada;
      }
    }
    //echo "--------DETALLE AJUTES DESPUES DE INSERTAR COMPRAS,PEDIDOS Y ANTES DE ELIMINACION---------". '</br>';
    //echo $detalleDeAjustes . '</br>';
    foreach ($detalleEliminacionCollection as $eliminacionTurno => $val) {
      // echo "producto_id a buscar: " . $val->producto_id . '</br>';
      if ($val->producto_id != null) {
        $posItemsE = $this->getPocision($detalleDeAjustes, $val->producto_id);
        // echo "posicion de productos encontrados: " . $posItemsE . '</br>';
        if (!$detalleDeAjustes->contains('item', $val->producto_id)) {
          $ajusteInvent = new AjusteInventario();
          $ajusteInvent['item'] = $val->producto_id;
          $ajusteInvent['inventario_ini'] = 0;
          $ajusteInvent['precio'] = 0;
          $ajusteInvent['compras'] = 0;
          $ajusteInvent['pedido'] = 0;
          $ajusteInvent['eliminacion'] = $val->cantidad;
          $detalleDeAjustes->push($ajusteInvent);
        } else {
          $detalleDeAjustes[$posItemsE]['eliminacion'] = $val->cantidad;
        }
      }
    }
    //  echo "--------DETALLE AJUTES DESPUES DE INSERTAR COMPRAS,PEDIDOS y ELIMINACION---------". '</br>';
    //  echo $detalleDeAjustes . '</br>';
    foreach ($detalleDeAjustes as $xd => $valueDetalle) {
      $valueDetalle->inventario_sis = $valueDetalle->inventario_ini + $valueDetalle->compras + $valueDetalle->pedido - $valueDetalle->eliminacion;
      $valueDetalle->inventario_fin = 0;
    }
    // echo "--------DETALLE AJUTES DESPUES DE OPERACION INV-SISTEMA---------". '</br>';

    // echo $detalleDeAjustes . '</br>';
    // echo "-------- INVENTARIO PM ---------". '</br>';
    $sumaTotalDiferencia = 0;
    $inventariosPM = Inventario::where('sucursal_id', $sucursal)
      ->where('turno_id', 2)
      ->where('fecha', $fecha)
      ->get(['id', 'fecha']);
    // echo $inventariosPM . '</br>';
    if (count($inventariosPM) > 0) {
      //  echo "-------- DETALLE INVENTARIO PM ---------". '</br>';
      $detallesInventarioPM = DetalleInventario::where('inventario_id', $inventariosPM[0]['id'])->get(['producto_id', 'stock']);
      //  echo $detallesInventarioPM . '</br>';

      foreach ($detallesInventarioPM as $detalleInvPm => $valuePm) {
        // echo 'Stock: '.$valuePm->stock.'</br>';
        // echo "producto_id a buscar: " . $valuePm->producto_id . '</br>';
        $posItemsPM = $this->getPocision($detalleDeAjustes, $valuePm->producto_id);
        // echo "posicion de productos encontrados: " . $posItemsPM . '</br>';
        if (!$detalleDeAjustes->contains('item', $valuePm->producto_id)) {
          $ajusteInventa = new AjusteInventario();
          $ajusteInventa['item'] = $valuePm->producto_id;
          $ajusteInventa['inventario_ini'] = 0;
          $ajusteInventa['precio'] = 0;
          $ajusteInventa['compras'] = 0;
          $ajusteInventa['pedido'] = 0;
          $ajusteInventa['eliminacion'] = 0;
          $ajusteInventa['inventario_sis'] = 0;
          $ajusteInventa['inventario_fin'] = $valuePm->stock;
          $detalleDeAjustes->push($ajusteInventa);
        } else {
          $detalleDeAjustes[$posItemsPM]['inventario_fin'] = $valuePm->stock;
        }
      }
      //  echo "--------DETALLE AJUTES DESPUES DE DETALLE INVENTARIO PM---------". '</br>';
      //  echo $detalleDeAjustes . '</br>';
      //  echo "--------DIFERENCIA---------". '</br>';
      foreach ($detalleDeAjustes as $OX => $valorDetalle) {
        $valorDetalle->diferencia = $valorDetalle->inventario_fin - $valorDetalle->inventario_sis;
      }
      //  echo $detalleDeAjustes . '</br>';
      //  echo "--------Total Diferencia por unidad---------". '</br>';
      foreach ($detalleDeAjustes as $Por => $valueDi) {
        $valueDi->total_diferencia_bs = $valueDi->precio * $valueDi->diferencia;
      }
      //echo $detalleDeAjustes . '</br>';
      //echo "--------SUMA DE TOTAL DIFERENCIA---------". '</br>';
      $sumaTotalDiferencia =  $detalleDeAjustes->sum('total_diferencia_bs');
      //echo "Suma total diferencia------------------->".$sumaTotalDiferencia. '</br>';
    } else {
      echo "El Inventario final de esta fecha no existe" . '</br>';
    }
    foreach ($detalleDeAjustes as $Por => $valval) {
      // echo $valval . '</br>';
      $producto = Producto::where('id', $valval->item)->first();
      // echo $producto. '</br>';
      $valval['producto'] = $producto->nombre;
    }
    return view('reportes.show_ajuste_inventario', ['detalleAjustes' => $detalleDeAjustes, 'sumaTotalDiferencia' => $sumaTotalDiferencia]);
  }

  public function getCollectionAjusteInventarioDiario($id, $fecha, $sucursal)
  {
    $detallesInventario = DetalleInventario::where('inventario_id', $id)->get(['producto_id', 'stock', 'precio']);
    //COMPRAS
    $compras = Compra::where('sucursal_id', $sucursal)
      ->where('fecha_compra', $fecha)
      ->get(['id', 'fecha_compra']);
    // echo "Todas las Comras: " . $compras . '</br>';
    //DETALLE COMPRAS
    $detalleComprasCollection = new Collection();
    $primeraC = 0;
    foreach ($compras as $key => $compra) {
      $detallesCompras = DetalleCompra::where('compra_id', $compra->id)
        ->get(['producto_id', 'cantidad']);
      // echo "Detalle de esa Compra: " . $detallesCompras . '</br>';
      if ($primeraC > 0) {
        for ($j = 0; $j < count($detallesCompras); $j++) {
          if ($detalleComprasCollection->contains('producto_id', $detallesCompras[$j]->producto_id)) {
            $pos = $this->getPocisionT($detalleComprasCollection, $detallesCompras[$j]->producto_id);
            $detalleComprasCollection[$pos]['cantidad'] += $detallesCompras[$j]->cantidad;
          } else {
            $detalleComprasCollection->push($detallesCompras[$j]);
          }
        }
      } else {
        foreach ($detallesCompras as $key => $comprasD) {
          $detalleComprasCollection->push($comprasD);
        }
        $primeraC++;
      }
    }
    // echo "Colleccition de Detalle Compras" . '</br>';
    // echo $detalleComprasCollection . '</br>';
    //PEDIDOS
    $detallePedidosCollection = new Collection();
    $primeraP = 0;
    $pedidos = Pedido::where('sucursal_principal_id', $sucursal)
      ->where('estado', 'A')
      ->where('fecha_pedido', $fecha)
      ->get(['id', 'fecha_pedido']);
    // echo "Todas los Pedidos: " . $pedidos . '</br>';
    //DETALLE PEDIDOS
    foreach ($pedidos as $key => $pedido) {
      $detallePedidos = DetallePedido::where('pedido_id', $pedido->id)
        ->get(['cantidad_enviada', 'producto_id']);
      //  echo "Detalle de ese Pedido: " . $detallePedidos . '</br>';
      if ($primeraP > 0) {
        for ($j = 0; $j < count($detallePedidos); $j++) {
          if ($detallePedidosCollection->contains('producto_id', $detallePedidos[$j]->producto_id)) {
            $pos = $this->getPocisionT($detallePedidosCollection, $detallePedidos[$j]->producto_id);
            //echo "Ser repite el producto: ".$detallePedidos[$j]->producto_id." En la posicion: ".$pos;
            $detallePedidosCollection[$pos]['cantidad_enviada'] += $detallePedidos[$j]->cantidad_enviada;
          } else {
            $detallePedidosCollection->push($detallePedidos[$j]);
          }
        }
      } else {
        foreach ($detallePedidos as $key => $pedidoD) {
          $detallePedidosCollection->push($pedidoD);
        }
        $primeraP++;
      }
    }
    // echo "Colleccition de Detalle Pedidos" . '</br>';
    // echo $detallePedidosCollection . '</br>';
    //ELIMINACION
    $detalleEliminacionCollection = new Collection();
    $primeraE = 0;
    $eliminaciones = Eliminacion::where('sucursal_id', $sucursal)
      ->where('fecha', $fecha)
      ->get(['id', 'fecha']);
    // echo "Todas los Eliminaciones: " . $eliminaciones . '</br>';
    //DETALLE ELIMINACION
    foreach ($eliminaciones as $key => $eliminacion) {
      $detalleEliminacion = DetalleEliminacion::where('eliminacion_id', $eliminacion->id)
        ->get(['cantidad', 'producto_id']);
      // echo "Detalle de ese Eliminacion: " . $detalleEliminacion . '</br>';
      if ($primeraE > 0) {
        for ($j = 0; $j < count($detalleEliminacion); $j++) {
          if ($detalleEliminacionCollection->contains('producto_id', $detalleEliminacion[$j]->producto_id)) {
            $pos = $this->getPocisionT($detalleEliminacionCollection, $detalleEliminacion[$j]->producto_id);
            //echo "Ser repite el producto: ".$detallePedidos[$j]->producto_id." En la posicion: ".$pos;
            $detalleEliminacionCollection[$pos]['cantidad'] += $detalleEliminacion[$j]->cantidad;
          } else {
            $detalleEliminacionCollection->push($detalleEliminacion[$j]);
          }
        }
      } else {
        foreach ($detalleEliminacion as $key => $eliminacionD) {
          $detalleEliminacionCollection->push($eliminacionD);
        }
        $primeraE++;
      }
    }
    // echo "Colleccition de Detalle Eliminacion" . '</br>';
    // echo $detalleEliminacionCollection . '</br>';
    $detalleDeAjustes = new Collection();
    for ($i = 0; $i < count($detallesInventario); $i++) {
      $ajusteInventario = new AjusteInventario();
      $ajusteInventario['item'] = $detallesInventario[$i]['producto_id'];
      $ajusteInventario['inventario_ini'] = $detallesInventario[$i]['stock'];
      $ajusteInventario['precio'] = $detallesInventario[$i]['precio'];
      $ajusteInventario['compras'] = 0;
      $ajusteInventario['pedido'] = 0;
      $ajusteInventario['eliminacion'] = 0;
      $detalleDeAjustes[$i] =  $ajusteInventario;
    }
    // echo "--------DETALLE AJUTES ANTES DE INSERTAR COMPRAS-----------" . '</br>';
    // echo $detalleDeAjustes . '</br>';
    // echo "--------- mostrando todos los Id de los productos comprados y comparando con los del inventario----------" . '</br>';
    foreach ($detalleComprasCollection as $compra => $value) {
      // echo $value->producto_id . '</br>';
      $posicionItem = $this->getPocision($detalleDeAjustes, $value->producto_id);
      if (!$detalleDeAjustes->contains('item', $value->producto_id)) {
        //armar la estructura
        $ajusteInv = new AjusteInventario();
        $ajusteInv['item'] = $value->producto_id;
        $ajusteInv['inventario_ini'] = 0;
        $ajusteInv['precio'] = 0;
        $ajusteInv['compras'] = $value->cantidad;
        $ajusteInv['pedido'] = 0;
        $ajusteInv['eliminacion'] = 0;
        $detalleDeAjustes->push($ajusteInv);

        // $detalleDeAjustes->push($value->producto_id);

      } else {
        $detalleDeAjustes[$posicionItem]['compras'] = $value->cantidad;
      }
    }
    // echo "--------DETALLE AJUTES DESPUES DE INSERTAR COMPRAS y ANTES DE INSERTAR PEDIDOS-----------" . '</br>';
    // echo $detalleDeAjustes . '</br>';
    foreach ($detallePedidosCollection as $pedidoTurno => $valor) {
      //   echo "producto_id a buscar: " . $valor->producto_id . '</br>';
      $posItem = $this->getPocision($detalleDeAjustes, $valor->producto_id);
      // echo "posicion de productos encontrados: " . $posItem . '</br>';

      if (!$detalleDeAjustes->contains('item', $valor->producto_id)) {
        //armar la estructura
        $ajusteInve = new AjusteInventario();
        $ajusteInve['item'] = $valor->producto_id;
        $ajusteInve['inventario_ini'] = 0;
        $ajusteInve['precio'] = 0;
        $ajusteInve['compras'] = 0;
        $ajusteInve['pedido'] = $valor->cantidad_enviada;
        $ajusteInve['eliminacion'] = 0;
        $detalleDeAjustes->push($ajusteInve);
      } else {
        $detalleDeAjustes[$posItem]['pedido'] = $valor->cantidad_enviada;
      }
    }
    //echo "--------DETALLE AJUTES DESPUES DE INSERTAR COMPRAS,PEDIDOS Y ANTES DE ELIMINACION---------". '</br>';
    //echo $detalleDeAjustes . '</br>';
    foreach ($detalleEliminacionCollection as $eliminacionTurno => $val) {
      // echo "producto_id a buscar: " . $val->producto_id . '</br>';
      if ($val->producto_id != null) {
        $posItemsE = $this->getPocision($detalleDeAjustes, $val->producto_id);
        // echo "posicion de productos encontrados: " . $posItemsE . '</br>';
        if (!$detalleDeAjustes->contains('item', $val->producto_id)) {
          $ajusteInvent = new AjusteInventario();
          $ajusteInvent['item'] = $val->producto_id;
          $ajusteInvent['inventario_ini'] = 0;
          $ajusteInvent['precio'] = 0;
          $ajusteInvent['compras'] = 0;
          $ajusteInvent['pedido'] = 0;
          $ajusteInvent['eliminacion'] = $val->cantidad;
          $detalleDeAjustes->push($ajusteInvent);
        } else {
          $detalleDeAjustes[$posItemsE]['eliminacion'] = $val->cantidad;
        }
      }
    }
    //  echo "--------DETALLE AJUTES DESPUES DE INSERTAR COMPRAS,PEDIDOS y ELIMINACION---------". '</br>';
    return $detalleDeAjustes;
  }
  public function ajuste(Request $request)
  {
    $id = $request->sucursal;
    $fi = $request->fecha_inicial;
    $ff = $request->fecha_final;
    //INVENTARIO
    $inventariosAM = Inventario::where('sucursal_id', $id)
      ->whereBetween('fecha', [$fi, $ff])
      ->where('turno_id', 1)
      ->get(['id', 'fecha']);
    $sucursales = Sucursal::All();
    $inventariosAM = [];
    return view('reportes.ajustes_inventario_index', ['sucursales' => $sucursales, 'inventariosAM' => $inventariosAM]);
  }
  public function getPocisionT(Collection $array, $value)
  {
    for ($i = 0; $i < count($array); $i++) {
      if ($array[$i]->producto_id == $value) {
        return $i;
      }
    }
    return -1;
  }

  public function getPocision(Collection $array, $value)
  {
    for ($i = 0; $i < count($array); $i++) {
      if ($array[$i]->item == $value) {
        return $i;
      }
    }
    return -1;
  }
  public function getPlatoPosition(Collection $array, $value)
  {
  }

  public function cajaChica(Request $request)
  {
    $id = $request->sucursal;
    $fi = $request->fecha_inicial;
    $ff = $request->fecha_final;
    $turno = $request->turno;
    if ($turno == "true") {
      $ventas = Venta::where('sucursal_id', $id)
        ->where('hora_venta', '<', '16:00:00')
        ->whereBetween('fecha_venta', [$fi, $ff])
        ->get('hora_venta');
    } else {
      $ventas = Venta::where('sucursal_id', $id)
        ->where('hora_venta', '>', '16:00:00')
        ->whereBetween('fecha_venta', [$fi, $ff])
        ->get('hora_venta');
    }
    echo $ventas;
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

  public function indexSemanal()
  {
    $sucursales = Sucursal::All();
    $newCollection = [];
    $sumaTotalDiferencia = 0;
    return view('reportes.ajustes_inv_semanal_index', ['sucursales' => $sucursales,'newCollection' => $newCollection,'sumaTotalDiferencia' => $sumaTotalDiferencia]);
  }

  public function ajusteSemanal(Request $request)
  {
    $id = $request->sucursal;
    $turno = $request->turno;
    $fechaInicio = strtotime($request->fecha_inicial);
    $fechaFin = strtotime($request->fecha_final);

    //COLLECCION INICIAL O BASE
    $inventariosAM = Inventario::where('sucursal_id', $id)
      ->where('turno_id', 1)
      ->where('fecha', $request->fecha_inicial)
      ->first();
    $newCollection = $this->getCollectionAjusteInventarioDiario($inventariosAM->id, $inventariosAM->fecha, $inventariosAM->sucursal_id);
    $fechaInicio += 86400;
   // echo "Colleccion INICIAL: " . $newCollection . '</br>';
    for ($i = $fechaInicio; $i <= $fechaFin; $i += 86400) {
      $date = date("Y-m-d", $i);
      $inventariosAM = Inventario::where('sucursal_id', $id)
        ->where('turno_id', 1)
        ->where('fecha', $date)
        ->first();
      if ($inventariosAM != null) {
        $newCollectionCambiante = $this->getCollectionAjusteInventarioDiario($inventariosAM->id, $inventariosAM->fecha, $inventariosAM->sucursal_id);

      //  echo "Colleccion dentro del FOR: " . $newCollectionCambiante . '</br>';

        foreach ($newCollectionCambiante as $newCol => $val) {
          // echo "producto_id a buscar: " . $val->producto_id . '</br>';
          $posItemsE = $this->getPocision($newCollection, $val->item);
          // echo "posicion de productos encontrados: " . $posItemsE . '</br>';
          if (!$newCollection->contains('item', $val->item)) {
            $newCollection->push($val);
          } else {
            //AQUI REALIZAR LA CONSOLIDACION
            $newCollection[$posItemsE]['precio'] += $val->precio;
            $newCollection[$posItemsE]['compras'] += $val->compras;
            $newCollection[$posItemsE]['pedido'] += $val->pedido;
            $newCollection[$posItemsE]['eliminacion'] = $val->eliminacion;
          }
        }
      }
    }
    //echo "-----------------------------------" . '</br>';
   // echo "Colleccion Consolidada" . $newCollection . '</br>';
    //  echo "--------DETALLE AJUTES DESPUES DE INSERTAR COMPRAS,PEDIDOS y ELIMINACION---------". '</br>';
    //  echo $detalleDeAjustes . '</br>';
    foreach ($newCollection as $xd => $valueDetalle) {
      $valueDetalle->inventario_sis = $valueDetalle->inventario_ini + $valueDetalle->compras + $valueDetalle->pedido - $valueDetalle->eliminacion;
      $valueDetalle->inventario_fin = 0;
    }
    //echo "--------DETALLE AJUTES DESPUES DE OPERACION INV-SISTEMA---------" . '</br>';
    //echo $newCollection . '</br>';
     // echo "-------- INVENTARIO PM ---------". '</br>';
     $sumaTotalDiferencia = 0;
     $inventariosPM = Inventario::where('sucursal_id', $id)
       ->where('turno_id', 2)
       ->where('fecha', $request->fecha_final)
       ->get(['id', 'fecha']);
    
    //   echo "--------DETALLE AJUTES DESPUES DE OPERACION INV-SISTEMA---------" . '</br>';
    //echo $inventariosPM . '</br>';
    if (count($inventariosPM) > 0) {
      //  echo "-------- DETALLE INVENTARIO PM ---------". '</br>';
      $detallesInventarioPM = DetalleInventario::where('inventario_id', $inventariosPM[0]['id'])->get(['producto_id', 'stock']);
      //  echo $detallesInventarioPM . '</br>';

      foreach ($detallesInventarioPM as $detalleInvPm => $valuePm) {
        // echo 'Stock: '.$valuePm->stock.'</br>';
        // echo "producto_id a buscar: " . $valuePm->producto_id . '</br>';
        $posItemsPM = $this->getPocision($newCollection, $valuePm->producto_id);
        // echo "posicion de productos encontrados: " . $posItemsPM . '</br>';
        if (!$newCollection->contains('item', $valuePm->producto_id)) {
          $ajusteInventa = new AjusteInventario();
          $ajusteInventa['item'] = $valuePm->producto_id;
          $ajusteInventa['inventario_ini'] = 0;
          $ajusteInventa['precio'] = 0;
          $ajusteInventa['compras'] = 0;
          $ajusteInventa['pedido'] = 0;
          $ajusteInventa['eliminacion'] = 0;
          $ajusteInventa['inventario_sis'] = 0;
          $ajusteInventa['inventario_fin'] = $valuePm->stock;
          $newCollection->push($ajusteInventa);
        } else {
          $newCollection[$posItemsPM]['inventario_fin'] = $valuePm->stock;
        }
      }
      //  echo "--------DETALLE AJUTES DESPUES DE DETALLE INVENTARIO PM---------". '</br>';
      //  echo $detalleDeAjustes . '</br>';
      //  echo "--------DIFERENCIA---------". '</br>';
      foreach ($newCollection as $OX => $valorDetalle) {
        $valorDetalle->diferencia = $valorDetalle->inventario_fin - $valorDetalle->inventario_sis;
      }
      //  echo $detalleDeAjustes . '</br>';
      //  echo "--------Total Diferencia por unidad---------". '</br>';
      foreach ($newCollection as $Por => $valueDi) {
        $valueDi->total_diferencia_bs = $valueDi->precio * $valueDi->diferencia;
      }
      //echo $detalleDeAjustes . '</br>';
      //echo "--------SUMA DE TOTAL DIFERENCIA---------". '</br>';
      $sumaTotalDiferencia =  $newCollection->sum('total_diferencia_bs');
      //echo "Suma total diferencia------------------->".$sumaTotalDiferencia. '</br>';
    } else {
    //  echo "El Inventario final de esta fecha no existe" . '</br>';
    }
    foreach ($newCollection as $Por => $valval) {
      // echo $valval . '</br>';
      $producto = Producto::where('id', $valval->item)->first();
      // echo $producto. '</br>';
      $valval['producto'] = $producto->nombre;
    }
    //echo "FINAAAAAAAAAAAAAAAAAAAAL: ".$newCollection . '</br>';  
    $sucursales = Sucursal::All();
    return view('reportes.ajustes_inv_semanal_index', ['sucursales' => $sucursales,'newCollection' => $newCollection,'sumaTotalDiferencia'=>$sumaTotalDiferencia]);
  }


  public function parteProduccion(Request $request)
  {
    $id = $request->sucursal;
    $turno = $request->turno;
    $fechaInicio = strtotime($request->fecha_inicial);
    $fechaFin = strtotime($request->fecha_final);
    $n = 0;
    $costoTotal = [];
    for ($i = $fechaInicio; $i <= $fechaFin; $i += 86400) {
      $costoTotalDia = new CostoTotal();

      //VENTAS
      $date = date("Y-m-d", $i);
      $costoTotalDia['fecha'] = $date;

      if ($turno == "true") {
        $totalVentasDia = Venta::where('sucursal_id', $id)
          ->where('hora_venta', '<', '16:00:00')
          ->whereBetween('fecha_venta', [$date, $date])->sum('total_neto');
      } else {
        $totalVentasDia = Venta::where('sucursal_id', $id)
          ->where('hora_venta', '>', '16:00:00')
          ->whereBetween('fecha_venta', [$date, $date])->sum('total_neto');
      }


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
        $sumaDetalle = 0;
        for ($j = 0; $j < count($cajaChica); ++$j) {
          $consultaDetalleCajaChica = DetalleCajaChica::where('caja_chica_id', $cajaChica[$j]['id'])
            ->join('categorias_caja_chica', 'categoria_caja_chica_id', '=', 'categorias_caja_chica.id')
            ->where('para_costo', 1)
            ->get(['categoria_caja_chica_id', 'egreso']);
          //   echo $consultaDetalleCajaChica . "</br>";
          $sumaDetalle = 0;
          for ($k = 0; $k < count($consultaDetalleCajaChica); ++$k) {
            $sumaDetalle += $consultaDetalleCajaChica[$k]['egreso'];
          }
          // echo $sumaDetalle . "</br>";
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
  }
}
