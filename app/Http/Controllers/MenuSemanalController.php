<?php

namespace App\Http\Controllers;

use App\Models\DetalleMenuSemanal;
use App\Models\MenuCalificacion;
use App\Models\MenuSemanal;
use App\Models\Plato;
use \Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PedidoProduccion;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MenuSemanalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus_semanales = MenuSemanal::all();
        return view('menus_semanales.index', compact('menus_semanales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $menu_semanal = MenuSemanal::all();
        $platos = Plato::all();
        $fecha_actual = Carbon::now()->toDateString();
        return view('menus_semanales.create', compact('menu_semanal', 'platos', 'fecha_actual'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $menu_semanal = new MenuSemanal();
        $menu_semanal->fecha = Carbon::now()->toDateString();
        $menu_semanal->dia = $request->dia;
        $menu_semanal->save();

        foreach (session('menus_semanales') as $id => $item) {
            $detalle_menu = new DetalleMenuSemanal();
            $detalle_menu->plato_id = $item['plato_id'];

            $detalle_menu->menu_semanal_id = $menu_semanal->id;
            $detalle_menu->save();
        }

        session()->forget('menus_semanales');
        session()->get('menus_asignados');
        session()->put('menus_asignados', 'ok');

        return response()->json(
            [
                'success' => true
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu_semanal = MenuSemanal::find($id);
        return view('menus_semanales.show', compact('menu_semanal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu_semanal = MenuSemanal::find($id);
        $platos = Plato::all();
        return view('menus_semanales.edit', compact('menu_semanal', 'platos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu_semanal = MenuSemanal::find($id);
        MenuSemanal::destroy($id);
        return redirect()->route('menus_semanales.index')->with('eliminar', 'ok');
    }

    public function agregarPlato(Request $request)
    {
        $plato = Plato::find($request->detalleMenu["plato"]);
        $menu_semanal_array = [
            "plato_id" => $plato->id,
            "plato_nombre" => $plato->nombre,
            "costo_plato" => $plato->costo_plato,
            "estado" => $plato->estado,
            "dia" => $request->detalleMenu['dia'],
        ];
        session()->get('menus_semanales');
        session()->push('menus_semanales', $menu_semanal_array);
        return response()->json([
            'menus_semanales' => session('menus_semanales'),
            'success' => true,
        ]);
    }

    public function eliminarPlato(Request $request)
    {
        $platos_asignados = session('menus_semanales');
        unset($platos_asignados[$request->data]);

        session()->put('menus_semanales', $platos_asignados);

        return response()->json([
            'menus_semanales' => session()->get('menus_semanales'),
            'success' => true,
        ]);
    }

    public function obtenerDatosPlatos(Request $request)
    {
        $plato = Plato::find($request->plato_id);

        $datos_platos = [
            "plato_nombre" => $plato->nombre,
            "plato_id" => $plato->id,
            "plato_costo" => $plato->costo_plato,
            "plato_estado" => $plato->estado,
        ];

        return response()->json([
            'datos_platos' => $datos_platos,
            'success' => true,
        ]);
    }
   
    public function reporteMenu(Request $request)
    {
        $user=User::find(  Auth::id() );
        if (empty($request->dia)) {
            $fecha_actual =  Carbon::now()->locale('es')->isoFormat('dddd');
        } else {
            $fecha_actual = $request->dia;
        }
        /* dd($fecha_actual); */
        $detalle_menu = DetalleMenuSemanal::all();
        $menu_semanal = MenuSemanal::where('dia', $fecha_actual)
            ->latest()
            ->take(1)
            ->get();
        $cantidad = 0;
        /* dd($menu_semanal); */
        if ( count($menu_semanal)==0  ) {
            $menu_semanal = new MenuSemanal();
            $menucalificacion = new MenuCalificacion();     
        }else{
            //$ddd=$menu_semanal[0];
            //dd($menu_semanal[0]->detalle_menus_semanales);
            $menucalificacion = MenuCalificacion::where('menu_semanal_id', $menu_semanal[0]->id)
                                ->where('sucursal_id',$user->sucursals[0]->id)
                                ->first();
            if (is_null($menucalificacion)==true  ) {
                $menucalificacion = new MenuCalificacion();
            }else{
                $idsucursal=$menucalificacion->sucursal_id;
                //$use = User::find($idd);
                //dd($use->sucursals[0]->nombre);
                $cantidad = count($menucalificacion->menu_calificacion_detalle);
            }
        }
        //dd( $menucalificacion->menu_calificacion_detalle[0]->id );
        return view('menus_semanales.menu_reporte', compact('detalle_menu', 'menu_semanal', 'fecha_actual', 'menucalificacion', 'cantidad','user'));
    }                                                                                                                     

    public function actualizarMenu(Request $request)
    {
        $menu_semanal = MenuSemanal::find($request->menu_id);

        if (sizeof($request->detallesAEliminar_id) != 0) {
            foreach ($request->detallesAEliminar_id as $index => $detalleEliminar) {
                $detalle_menu = DetalleMenuSemanal::find($detalleEliminar);
                if ($detalle_menu != null) {
                    $detalle_menu->delete();
                }
            }
        }

        if (sizeof($request->detallesAAgregar_datos) != 0) {
            foreach ($request->detallesAAgregar_datos as $index => $detalleAgregar) {
                $detalle_menu = new DetalleMenuSemanal();
                $detalle_menu->plato_id = $detalleAgregar['plato_id'];
                $detalle_menu->menu_semanal_id = $menu_semanal->id;
                $detalle_menu->save();
            }
        }
        return response()->json(
            [
                'success' => true
            ]
        );
    }
}
