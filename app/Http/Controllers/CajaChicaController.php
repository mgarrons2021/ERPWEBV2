<?php

namespace App\Http\Controllers;

use App\Models\CajaChica;
use App\Models\CajaChicaSubCategoria;
use App\Models\CategoriaCajaChica;
use App\Models\CategoriaGastosAdministrativos;
use App\Models\DetalleCajaChica;
use App\Models\DetalleGastosAdministrativos;
use App\Models\DetGastoAdm;
use App\Models\GastosAdministrativos;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class CajaChicaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $sucursales = Sucursal::all();
        if ($user->roles[0]->id == 3) {
            $cajas_chicas = CajaChica::where('sucursal_id', $user->sucursals[0]->id)->get();
        } else {
            $cajas_chicas = CajaChica::all();
        }
        return view('cajas_chicas.index', compact('cajas_chicas'));
    }

    public function filtrarIndexCajaChica(Request $request)
    {
        $user = Auth::user();
        $sucursales = Sucursal::all();
        $fecha_marcado_inicial = $request->get('fecha_inicial');
        $fecha_marcado_final = $request->get('fecha_final');

        if ($user->roles[0]->id == 3) {
            $cajas_chicas = CajaChica::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->where('sucursal_id', $user->sucursals[0]->id)->get();
        } else {

            //dd('true');
            $cajas_chicas = CajaChica::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->get();
        }

        return view('cajas_chicas.index', compact('cajas_chicas'));
    }

    public function create()
    {
        $fecha_actual = Carbon::now()->locale('es')->isoFormat('dddd, D MMMM Y');
        $categorias_caja_chica = CategoriaCajaChica::all();
        return view('cajas_chicas.create', compact('categorias_caja_chica', 'fecha_actual'));
    }

    public function edit($id)
    {
        $caja_chica = CajaChica::find($id);

        return view('cajas_chicas.edit', compact('caja_chica'));
    }

    public function agregarDetalle(Request $request)
    {
        $tipo_egreso = CategoriaCajaChica::find($request->detalleCajaChica['tipo_egreso']);
        $detalle_egreso = [
            "egreso" => $request->detalleCajaChica['egreso'],
            "tipo_egreso_nombre" => $tipo_egreso->nombre,
            "tipo_egreso_id" => $tipo_egreso->id,
            "glosa" => $request->detalleCajaChica['glosa'],
            "tipo_comprobante" => $request->detalleCajaChica['tipo_comprobante'],
            "nro" => $request->detalleCajaChica['nro'],
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
        $caja_chica = CajaChica::find($id);
        $fecha_actual = Carbon::now()->locale('es')->isoFormat('dddd, D MMMM Y');

        return view('cajas_chicas.show', compact('caja_chica', 'fecha_actual'));
    }

    public function registrarCajaChica()
    {
        if (session('lista_egreso') != null) {
            $caja_chica = new CajaChica();
            $caja_chica->fecha = Carbon::now()->toDateString();
            $caja_chica->user_id = Auth::id();
            $caja_chica->sucursal_id = Auth::user()->sucursals[0]->id;
            $caja_chica->save();

            $total_cajachica = 0;
            foreach (session('lista_egreso') as $id => $item) {
                $total_cajachica += $item['egreso'];
                $detalle_caja_chica = new DetalleCajaChica();
                $detalle_caja_chica->egreso = $item['egreso'];
                $detalle_caja_chica->glosa = $item['glosa'];
                $detalle_caja_chica->tipo_comprobante = $item['tipo_comprobante'];
                $detalle_caja_chica->nro_comprobante = $item['nro'];
                $detalle_caja_chica->categoria_caja_chica_id = $item['tipo_egreso_id'];
                $detalle_caja_chica->caja_chica_id = $caja_chica->id;
                $detalle_caja_chica->save();
            }
            $caja_chica->update(['total_egreso' => $total_cajachica]);
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
        CajaChica::destroy($id);
        return response()->json(['success' => true], 200);
    }

    public function reporteCajaChica()
    {
        $sucursales = Sucursal::all();
        $fecha_marcado_inicial = Carbon::now()->startOfDay();
        $fecha_marcado_final = Carbon::now()->endOfDay();
        $registros = CajaChica::whereBetween('fecha', [Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->get();
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
            $registrosAll = CajaChica::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->get();
            foreach ($registrosAll as $key => $value) {
                $todasSucursalesEnRango->push($value->sucursal_id);
            }
            $todasSucursalesEnRango = array_unique($todasSucursalesEnRango->toArray());
            foreach ($todasSucursalesEnRango as $key => $value) {
                $recibo = new Collection();
                $factura = new Collection();
                $registros = CajaChica::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->where('sucursal_id', $value)->get();
                foreach ($registros as $key => $value) {
                    //  CON RECIBO
                    $detalleCajaChica = DetalleCajaChica::selectRaw('SUM(egreso) AS suma_egreso, categorias_caja_chica.nombre')
                        ->join('categorias_caja_chica', 'categorias_caja_chica.id', '=', 'categoria_caja_chica_id',)
                        ->where('caja_chica_id', $value->id)
                        ->where('tipo_comprobante', 'R')
                        ->groupBy('categorias_caja_chica.nombre')
                        ->get();
                    foreach ($detalleCajaChica as $key => $valueDetalleCajaChica) {
                        $catCajaChica = CategoriaCajaChica::where('nombre', $valueDetalleCajaChica->nombre)->first();
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
                        $catCajaChica = CategoriaCajaChica::where('nombre', $valueDetalleCajaChicaFactura->nombre)->first();
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
            $registros = CajaChica::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->where('sucursal_id', $sucursal)->get();
            foreach ($registros as $key => $value) {
                //  CON RECIBO
                $detalleCajaChica = DetalleCajaChica::selectRaw('SUM(egreso) AS suma_egreso, categorias_caja_chica.nombre')
                    ->join('categorias_caja_chica', 'categorias_caja_chica.id', '=', 'categoria_caja_chica_id',)
                    ->where('caja_chica_id', $value->id)
                    ->where('tipo_comprobante', 'R')
                    ->groupBy('categorias_caja_chica.nombre')
                    ->get();
                foreach ($detalleCajaChica as $key => $valueDetalleCajaChica) {
                    $catCajaChica = CategoriaCajaChica::where('nombre', $valueDetalleCajaChica->nombre)->first();
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
                    $catCajaChica = CategoriaCajaChica::where('nombre', $valueDetalleCajaChicaFactura->nombre)->first();
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
            $registros = CajaChica::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->where('sucursal_id', $user->sucursals[0]->id)->get();
        } else {
            if ($sucursal == 'x') {
                //dd('true');
                $registros = CajaChica::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->get();
            } else {
                //dd('false');
                $registros = CajaChica::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->where('sucursal_id', $sucursal)->get();
            }
        }
        return view('contabilidad.reportes.reporteCajaChica', compact('sucursales', 'registros', 'fecha_marcado_inicial', 'fecha_marcado_final'));
    }

    public function indexReporteGastos(){

        $detalleGastosAdm = [];
        $fecha = new Carbon();
        $request = null;
        $listOne= [];
        $listTwo= [];
        $total_egresoFactura = 0;
        return view('contabilidad.reportes.reporteGastos',compact('listOne','listTwo','total_egresoFactura','request'));
    }
    public function filtrarDatos(Request $request){

        $categoria_gastos_adm = CategoriaGastosAdministrativos::all();
        $detalleGastosAdm = DetalleGastosAdministrativos::selectRaw('SUM(detalles_gasto_admin.egreso) AS suma_egreso, categorias_gasto_admin.nombre,categorias_gasto_admin.codigo,categorias_gasto_admin.id')
        ->join('categorias_gasto_admin', 'categorias_gasto_admin.id', '=', 'categoria_gasto_id',)->whereBetween('fecha', [$request->fecha_inicial, $request->fecha_final])->groupBy(['categorias_gasto_admin.nombre','categorias_gasto_admin.id','categorias_gasto_admin.codigo'])
        ->get();
        $total_egresoFactura = 0;
        foreach ($detalleGastosAdm as $key => $value) {
            $categorias = CategoriaGastosAdministrativos::where('id',$value->id)->first();
            $total_egresoFactura+=$value->suma_egreso;
            $value['subcategoria'] = $categorias->sub_categoria->sub_categoria;
        }
        $listOne = new Collection();
        $listTwo = new Collection();
        foreach ($detalleGastosAdm as $key => $value) {
            if ($value->subcategoria=="Gastos de Administración") {
                $listOne->push($value);
            }else if($value->subcategoria=="Gastos de Comercialización"){
                $listTwo->push($value);
            }
        }
        return view('contabilidad.reportes.reporteGastos',compact('listOne','listTwo','total_egresoFactura','request'));
    }

    public function detalle(Request $request){
                                                            
        $detalleGastosAdm = DetalleGastosAdministrativos::select('sucursals.nombre','detalles_gasto_admin.fecha','detalles_gasto_admin.egreso','detalles_gasto_admin.glosa','detalles_gasto_admin.tipo_comprobante','detalles_gasto_admin.nro_comprobante','detalles_gasto_admin.id')
                ->where('categoria_gasto_id',$request->categoria)
                ->whereBetween('detalles_gasto_admin.fecha', [$request->fecha_inicial, $request->fecha_final])
                ->join('gastos_administrativo', 'gastos_administrativo.id', '=', 'detalles_gasto_admin.gastos_administrativos_id')
                ->join('sucursals', 'sucursals.id' ,'gastos_administrativo.sucursal_id')
                ->get();  
        return view('contabilidad.reportes.detalleGastos',compact('detalleGastosAdm'));
    }

}


