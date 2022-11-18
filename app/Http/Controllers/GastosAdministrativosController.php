<?php

namespace App\Http\Controllers;

use App\Models\GastosAdministrativos;
use App\Models\CategoriaGastosAdministrativos;
use App\Models\DetalleGastosAdministrativos;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class GastosAdministrativosController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $sucursales = Sucursal::all();
        if ($user->roles[0]->id == 3) {
            $gastos_administrativo = GastosAdministrativos::where('sucursal_id', $user->sucursals[0]->id)->get();
        } else {
            $gastos_administrativo = GastosAdministrativos::all();
        }
        return view('gastos_administrativos.index', compact('gastos_administrativo'));
    }

    public function filtrarIndexGasto(Request $request)
    {
        $user = Auth::user();
        $sucursales = Sucursal::all();
        $fecha_marcado_inicial = $request->get('fecha_inicial');
        $fecha_marcado_final = $request->get('fecha_final');

        if ($user->roles[0]->id == 3) {
            $gastos_administrativo = GastosAdministrativos::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->where('sucursal_id', $user->sucursals[0]->id)->get();
        } else {

            //dd('true');
            $gastos_administrativo = GastosAdministrativos::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->get();
        }

        return view('gastos_administrativos.index', compact('gastos_administrativo'));
    }

    public function create()
    {
        $fecha_actual = Carbon::now()->locale('es')->isoFormat('dddd, D MMMM Y');
        $sucursales= Sucursal::all();
        $categorias_gastos_administrativos = CategoriaGastosAdministrativos::all();
        return view('gastos_administrativos.create', compact('categorias_gastos_administrativos', 'fecha_actual'))->with('sucursales', $sucursales);
    }

    public function edit($id)
    {
        $gastos_administrativo = GastosAdministrativos::find($id);

        return view('gastos_administrativos.edit', compact('gastos_administrativo'));
    }

    public function agregarDetalle(Request $request)
    {
        $tipo_egreso = CategoriaGastosAdministrativos::find($request->detalleGasto['tipo_egreso']);
        $sucursal = Sucursal::find($request->detalleGasto["sucursal"]);
        //$dateActual = new Carbon();
        $detalle_egreso = [
            "egreso" => $request->detalleGasto['egreso'],
            "tipo_egreso_nombre" => $tipo_egreso->nombre,
            "tipo_egreso_id" => $tipo_egreso->id,
            "glosa" => $request->detalleGasto['glosa'],
            "tipo_comprobante" => $request->detalleGasto['tipo_comprobante'],
            "nro" => $request->detalleGasto['nro'],
            "sucursal" => $sucursal->nombre,
        ];

        session()->get('lista_egreso');
        session()->push('lista_egreso', $detalle_egreso);

        return response()->json([
            'lista_egreso' => session()->get('lista_egreso'),
            'success' => true
        ]);
    }

    public function eliminarDetalle(Request $request)
    {
        $detalle_egreso = session('lista_egreso');
        unset($detalle_egreso[$request->data]);
        session()->put('lista_egreso', $detalle_egreso);
        return response()->json(
            [
                'lista_egreso' => session()->get('lista_egreso'),
                'success' => true
            ]
        );
    }

    public function show($id)
    {
        $gastos_administrativo = GastosAdministrativos::find($id);
        $fecha_actual = Carbon::now()->locale('es')->isoFormat('dddd, D MMMM Y');

        $detalle_Gastos_Adm = DetalleGastosAdministrativos::all();
         $categorias = CategoriaGastosAdministrativos::all();
        foreach ($gastos_administrativo->detalles_gastos_administrativos as $key => $value) {
            $categorias = CategoriaGastosAdministrativos::where('id',$value->categoria_gasto_id)->first();
            $value['categoria_gasto'] = $categorias->nombre;
            $value['subcategoria'] = $categorias->sub_categoria->sub_categoria;
        }
        return view('gastos_administrativos.show', compact('gastos_administrativo', 'fecha_actual'));
    }

    public function registrarGasto(Request $request)
    {
        /* dd($request); */
        if (session('lista_egreso') != null) {
            $gastos_administrativo = new GastosAdministrativos();
            $gastos_administrativo->fecha = Carbon::now()->toDateString();
            $gastos_administrativo->user_id = Auth::id();
            $gastos_administrativo->sucursal_id = $request->sucursal;
        
            $gastos_administrativo->save();

            $total_cajachica = 0;
            foreach (session('lista_egreso') as $id => $item) {
                $total_cajachica += $item['egreso'];
                $sucursales = Sucursal::all();
                $detalles_gastos_administrativos = new DetalleGastosAdministrativos();
                $detalles_gastos_administrativos->fecha = Carbon::now()->toDateString();
                $detalles_gastos_administrativos->egreso = $item['egreso'];
                $detalles_gastos_administrativos->glosa = $item['glosa'];
                $detalles_gastos_administrativos->tipo_comprobante = $item['tipo_comprobante'];
                $detalles_gastos_administrativos->nro_comprobante = $item['nro'];
                $detalles_gastos_administrativos->categoria_gasto_id = $item['tipo_egreso_id'];
                $detalles_gastos_administrativos->gastos_administrativos_id = $gastos_administrativo->id;
                $detalles_gastos_administrativos->save();
            }
            $gastos_administrativo->update(['total_egreso' => $total_cajachica]);
            session()->forget('lista_egreso');
            return response()->json(
                [
                    'success' => true
                ]
            );
        }
        return response()->json(
            [
                'success' => false
            ]
        );
    }

    public function destroy($id)
    {
        GastosAdministrativos::destroy($id);
        return response()->json(['success' => true], 200);
    }

    public function reporteCajaChica()
    {
        $sucursales = Sucursal::all();
        $fecha_marcado_inicial = Carbon::now()->startOfDay();
        $fecha_marcado_final = Carbon::now()->endOfDay();
        $registros = GastosAdministrativos::whereBetween('fecha', [Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->get();
        return view('contabilidad.reportes.reporteCajaChica', compact('sucursales', 'registros', 'fecha_marcado_inicial', 'fecha_marcado_final'));
    }
    public function consolidadoCajaChica()
    {
        $sucursales = Sucursal::all();
        $fecha_marcado_inicial = Carbon::now()->startOfDay();
        $fecha_marcado_final = Carbon::now()->endOfDay();
        $total_egresoFactura = 0;
        $total_egresoRecibo = 0;
        $collectionFinalFactura = [];
        $collectionFinalRecibo = [];
        return view('contabilidad.reportes.consolidadoCajaChica', compact('total_egresoFactura', 'total_egresoRecibo', 'sucursales', 'collectionFinalFactura', 'collectionFinalRecibo', 'fecha_marcado_inicial', 'fecha_marcado_final'));
    }
    public function filtrarConsolidadoCajaChica(Request $request)
    {

        $user = Auth::user();
        $sucursales = Sucursal::all();
        $sucursal = $request->get('sucursal_id');
        $fecha_marcado_inicial = $request->get('fecha_inicial');
        $fecha_marcado_final = $request->get('fecha_final');
        $detalleCajaChicaFactura = [];
        $total_egresoFactura = 0;
        $total_egresoRecibo = 0;

        $recibo = new Collection();
        $factura = new Collection();
        $collectionFinalFactura = new Collection();
        $collectionFinalRecibo = new Collection();

        $todasSucursalesEnRango = new Collection();
        if ($sucursal == 'x') {
            $registrosAll = GastosAdministrativos::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->get();
            foreach ($registrosAll as $key => $value) {
                $todasSucursalesEnRango->push($value->sucursal_id);
            }
            $todasSucursalesEnRango = array_unique($todasSucursalesEnRango->toArray());
            foreach ($todasSucursalesEnRango as $key => $value) {
                $recibo = new Collection();
                $factura = new Collection();
                $registros = GastosAdministrativos::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->where('sucursal_id', $value)->get();
                foreach ($registros as $key => $value) {
                    //  CON RECIBO
                    $detalleCajaChica = DetalleCajaChica::selectRaw('SUM(egreso) AS suma_egreso, categorias_caja_chica.nombre')
                        ->join('categorias_caja_chica', 'categorias_caja_chica.id', '=', 'categoria_caja_chica_id',)
                        ->where('caja_chica_id', $value->id)
                        ->where('tipo_comprobante', 'R')
                        ->groupBy('categorias_caja_chica.nombre')
                        ->get();
                    foreach ($detalleCajaChica as $key => $valueDetalleCajaChica) {
                        $catCajaChica = CategoriaGastosAdministrativos::where('nombre', $valueDetalleCajaChica->nombre)->first();
                        $valueDetalleCajaChica['sucursal'] = $value->sucursal->nombre;
                        $valueDetalleCajaChica['sub_categoria_id'] =  $this->categorizar($catCajaChica->sub_categoria_id);
                    }
                    foreach ($detalleCajaChica as $key => $valueees) {
                        $recibo->push($valueees);
                    }
                    //CON FACTURA
                    $detalleCajaChicaFactura = DetalleCajaChica::selectRaw('SUM(egreso) AS suma_egreso, categorias_caja_chica.nombre')
                        ->join('categorias_caja_chica', 'categorias_caja_chica.id', '=', 'categoria_caja_chica_id',)
                        ->where('caja_chica_id', $value->id)
                        ->where('tipo_comprobante', 'F')
                        ->groupBy('categorias_caja_chica.nombre')
                        ->get();
                    //dd($detalleCajaChicaFactura);   
                    foreach ($detalleCajaChicaFactura as $key => $valueDetalleCajaChicaFactura) {
                        $catCajaChica = CategoriaGastosAdministrativos::where('nombre', $valueDetalleCajaChicaFactura->nombre)->first();
                        $valueDetalleCajaChicaFactura['sucursal'] = $value->sucursal->nombre;
                        $valueDetalleCajaChicaFactura['sub_categoria_id'] =  $this->categorizar($catCajaChica->sub_categoria_id);
                    }
                    foreach ($detalleCajaChicaFactura as $key => $valuees) {
                        $factura->push($valuees);
                    }
                }
                //PASO DOS RECIBO
                $groupwithcountRecibo = $recibo->groupBy('nombre')->map(function ($row) {
                    return [
                        'nombre' =>  $row->first()['nombre'],
                        'sucursal' =>  $row->first()['sucursal'],
                        'sub_categoria_id' =>  $row->first()['sub_categoria_id'],
                        'suma_egreso' => $row->sum('suma_egreso')
                    ];
                });
                foreach ($groupwithcountRecibo as $key => $valuezz) {
                    $collectionFinalRecibo->push($valuezz);
                }
                foreach ($collectionFinalRecibo as $key => $valorR) {
                    foreach ($valorR as $llave => $valor) {
                        if ($llave == "suma_egreso") {
                            $total_egresoRecibo +=  $valor;
                        }
                    }
                }
                //PASO DOS FACTURA
                $groupwithcount = $factura->groupBy('nombre')->map(function ($row) {
                    //  return $row->sum('suma_egreso');
                    return [
                        'nombre' =>  $row->first()['nombre'],
                        'sucursal' =>  $row->first()['sucursal'],
                        'sub_categoria_id' =>  $row->first()['sub_categoria_id'],
                        'suma_egreso' => $row->sum('suma_egreso')
                    ];
                });

                foreach ($groupwithcount as $key => $valuez) {
                    $collectionFinalFactura->push($valuez);
                }
                // $collectionFinalFactura = new Collection([['nombre' => "Verduras",'sucursal'=>"Suc. Palmas",'suma_egreso'=>79.31],['nombre' => "Abarrotes",'sucursal'=>"Suc. Palmas",'suma_egreso'=>53.18],['nombre' => "Plasticos",'sucursal'=>"Suc. Palmas",'suma_egreso'=>13.5]]);    
                // echo "Coleccion Final Factura".$collectionFinalFactura.'</br>';
                foreach ($collectionFinalFactura as $key => $value) {
                    foreach ($value as $llave => $valor) {
                        if ($llave == "suma_egreso") {
                            $total_egresoFactura +=  $valor;
                        }
                    }
                }
            }
            return view('contabilidad.reportes.consolidadoCajaChica', compact('total_egresoFactura', 'total_egresoRecibo', 'sucursales', 'collectionFinalFactura', 'collectionFinalRecibo', 'fecha_marcado_inicial', 'fecha_marcado_final'));
        } else {
            $registros = GastosAdministrativos::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->where('sucursal_id', $sucursal)->get();
            foreach ($registros as $key => $value) {
                //  CON RECIBO
                $detalleCajaChica = DetalleCajaChica::selectRaw('SUM(egreso) AS suma_egreso, categorias_caja_chica.nombre')
                    ->join('categorias_caja_chica', 'categorias_caja_chica.id', '=', 'categoria_caja_chica_id',)
                    ->where('caja_chica_id', $value->id)
                    ->where('tipo_comprobante', 'R')
                    ->groupBy('categorias_caja_chica.nombre')
                    ->get();
                foreach ($detalleCajaChica as $key => $valueDetalleCajaChica) {
                    $catCajaChica = CategoriaGastosAdministrativos::where('nombre', $valueDetalleCajaChica->nombre)->first();
                    $valueDetalleCajaChica['sucursal'] = $value->sucursal->nombre;
                    $valueDetalleCajaChica['sub_categoria_id'] =  $this->categorizar($catCajaChica->sub_categoria_id);
                }
                foreach ($detalleCajaChica as $key => $valueees) {
                    $recibo->push($valueees);
                }
                //CON FACTURA
                $detalleCajaChicaFactura = DetalleCajaChica::selectRaw('SUM(egreso) AS suma_egreso, categorias_caja_chica.nombre')
                    ->join('categorias_caja_chica', 'categorias_caja_chica.id', '=', 'categoria_caja_chica_id',)
                    ->where('caja_chica_id', $value->id)
                    ->where('tipo_comprobante', 'F')
                    ->groupBy('categorias_caja_chica.nombre')
                    ->get();
                foreach ($detalleCajaChicaFactura as $key => $valueDetalleCajaChicaFactura) {
                    $catCajaChica = CategoriaGastosAdministrativos::where('nombre', $valueDetalleCajaChicaFactura->nombre)->first();
                    $valueDetalleCajaChicaFactura['sucursal'] = $value->sucursal->nombre;
                    $valueDetalleCajaChicaFactura['sub_categoria_id'] =  $this->categorizar($catCajaChica->sub_categoria_id);
                }
                foreach ($detalleCajaChicaFactura as $key => $valuees) {
                    $factura->push($valuees);
                }
            }
            //PASO DOS RECIBO
            $groupwithcountRecibo = $recibo->groupBy('nombre')->map(function ($row) {
                return [
                    'nombre' =>  $row->first()['nombre'],
                    'sucursal' =>  $row->first()['sucursal'],
                    'sub_categoria_id' =>  $row->first()['sub_categoria_id'],
                    'suma_egreso' => $row->sum('suma_egreso')
                ];
            });

            foreach ($groupwithcountRecibo as $key => $valuezz) {
                $collectionFinalRecibo->push($valuezz);
            }
            foreach ($collectionFinalRecibo as $key => $valorR) {
                foreach ($valorR as $llave => $valor) {
                    if ($llave == "suma_egreso") {
                        $total_egresoRecibo +=  $valor;
                    }
                }
            }

            //PASO DOS FACTURA
            $groupwithcount = $factura->groupBy('nombre')->map(function ($row) {
                //  return $row->sum('suma_egreso');
                return [
                    'nombre' =>  $row->first()['nombre'],
                    'sucursal' =>  $row->first()['sucursal'],
                    'sub_categoria_id' =>  $row->first()['sub_categoria_id'],
                    'suma_egreso' => $row->sum('suma_egreso')
                ];
            });
            foreach ($groupwithcount as $key => $valuez) {
                $collectionFinalFactura->push($valuez);
            }
            // $collectionFinalFactura = new Collection([['nombre' => "Verduras",'sucursal'=>"Suc. Palmas",'suma_egreso'=>79.31],['nombre' => "Abarrotes",'sucursal'=>"Suc. Palmas",'suma_egreso'=>53.18],['nombre' => "Plasticos",'sucursal'=>"Suc. Palmas",'suma_egreso'=>13.5]]);    
            // echo "Coleccion Final Factura".$collectionFinalFactura.'</br>';
            foreach ($collectionFinalFactura as $key => $value) {
                foreach ($value as $llave => $valor) {
                    if ($llave == "suma_egreso") {
                        $total_egresoFactura +=  $valor;
                    }
                }
            }
            return view('contabilidad.reportes.consolidadoCajaChica', compact('total_egresoFactura', 'total_egresoRecibo', 'sucursales', 'collectionFinalFactura', 'collectionFinalRecibo', 'fecha_marcado_inicial', 'fecha_marcado_final'));
        }
    }
    public function categorizar($subCategoriaId)
    {
        $categoriaTxt = "";
        switch ($subCategoriaId) {
            case (1):
                $categoriaTxt = "Costo";
                break;
            case (2):
                $categoriaTxt = "Gasto";
                break;
            case (3):
                $categoriaTxt = "Otros Costos";
                break;
            default:
            break;
        }
        return $categoriaTxt;
    }

    public function filtrarCajaChica(Request $request)
    {
        $user = Auth::user();
        $sucursales = Sucursal::all();
        $sucursal = $request->get('sucursal_id');
        $fecha_marcado_inicial = $request->get('fecha_inicial');
        $fecha_marcado_final = $request->get('fecha_final');

        if ($user->roles[0]->id == 3) {
            $registros = GastosAdministrativos::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->where('sucursal_id', $user->sucursals[0]->id)->get();
        } else {
            if ($sucursal == 'x') {
                //dd('true');
                $registros = GastosAdministrativos::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->get();
            } else {
                //dd('false');
                $registros = GastosAdministrativos::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->where('sucursal_id', $sucursal)->get();
            }
        }
        return view('contabilidad.reportes.reporteCajaChica', compact('sucursales', 'registros', 'fecha_marcado_inicial', 'fecha_marcado_final'));
    }
}
