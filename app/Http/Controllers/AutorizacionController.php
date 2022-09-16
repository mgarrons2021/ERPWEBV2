<?php
namespace App\Http\Controllers;

use App\Models\Autorizacion;
use App\Models\Categoria;
use App\Models\Sucursal;
use App\Models\TurnoIngreso;
use App\Models\Venta;
use App\Models\Inventario;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioFacturacionCodigos;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioSiat;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SiatConfig;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class AutorizacionController extends Controller
{


    

    public function index()
    {
        $autorizaciones = Autorizacion::all();
        return view('autorizaciones.index')->with('autorizaciones', $autorizaciones);
    }

    public function create()
    {
        $sucursales = Sucursal::all();
        return view('autorizaciones.formdosificacion')->with('sucursales', $sucursales);
    }

    public function store(Request $request)
    {

        //   dd($request);
        $request->validate([
            'nro_autorizacion' => 'required',
            'fecha_inicial' => 'required',
            'fecha_fin' => 'required',
            'nro_factura' => 'required',
            'llave' => 'required',
            'estado' => 'required',
            'sucursal_id' => 'required',
        ]);
        $autorizacion = new Autorizacion();
        $autorizacion->nro_autorizacion = $request->nro_autorizacion;
        $autorizacion->fecha_inicial = $request->fecha_inicial;
        $autorizacion->fecha_fin = $request->fecha_fin;
        $autorizacion->nro_factura = $request->nro_factura;
        $autorizacion->llave = $request->llave;
        $autorizacion->nit = $request->nit;
        $autorizacion->estado = $request->estado;
        $autorizacion->sucursal_id = $request->sucursal_id;
        $autorizacion->save();

        return redirect()->route('autorizacion.index');
    }

    public function show($id)
    {
        $autorizacion = Autorizacion::find($id);
        return view('autorizaciones.show', ['autorizacion' => $autorizacion]);
    }

    public function verificar_cod_control()
    {
        $fecha = Carbon::now()->toDateString();
        $sucursal_user = Auth()->user()->sucursals[0]->id;


        $autorizacion = Autorizacion::where('sucursal_id', $sucursal_user)
            ->first();

        $venta = Venta::where('fecha_venta', $fecha)
            ->latest()
            ->get();

        return view('autorizaciones.verificar_codigo', compact('autorizacion', 'fecha', 'venta'));
    }

    public function generar_codigo()
    {

        return view('autorizaciones.verificar_codigo');
    }

    public function reporteTransacciones(Request $request)
    {
        $sucursales = Sucursal::all();
        if (isset($request->fecha_inicio) && isset($request->fecha_fin)) {
            $fecha_inicio = $request->fecha_inicio;
            $fecha_fin =  $request->fecha_fin;
            $sucursal_id = $request->sucursal_id;
        } else {
            $fecha_inicio = new Carbon();
            $fecha_fin = new Carbon();
            $sucursal_id = 1;
        }

        $sucursal_nombre = Sucursal::find($sucursal_id)->nombre;


        $hora_inicio = "08:00:00";
        $hora_fin = "23:59:59";

        $hora_inicio_formateada = new Carbon($hora_inicio);
        $hora_fin_formateada = new Carbon($hora_fin);

        $fecha_inicio_parseada = new Carbon($fecha_inicio);
        $fecha_fin_parseada  = new Carbon($fecha_fin);

        $collectionTransacciones_AM = collect();
        $collectionTransacciones_PM = collect();
        $fechas = collect();
        while ($fecha_fin_parseada >= $fecha_inicio_parseada) {
            $fechas->push($fecha_inicio_parseada->toDateString());
            $fecha_inicio_parseada->addDay();
        }



        while ($hora_fin_formateada > $hora_inicio_formateada) {
            $hora_actual = $hora_inicio_formateada;
            if ($hora_inicio_formateada->toTimeString() != "23:00:00") {
                $transacciones = Venta::selectRaw('ventas.fecha_venta as fecha_venta, count(ventas.total_venta) as TotalTransacciones')
                    ->whereBetween('hora_venta', [$hora_actual->toTimeString(), ($hora_actual->addHour())->toTimeString()])
                    ->where('tipo_pago', '<>', 'Comida Personal')
                    ->where('sucursal_id', $sucursal_id)
                    ->whereBetween('fecha_venta', [$fecha_inicio, $fecha_fin])
                    ->groupBy(['ventas.fecha_venta'])
                    ->get()->toArray();
                $hora_inicio_formateada->subHour();
                $total = $this->totalTransacciones_x_Hora($transacciones);
                array_push($transacciones, [
                    "fecha_venta" => $fecha_inicio . "-" . $fecha_fin,
                    "TotalTransacciones" => $total,
                ]);

                if ($hora_inicio_formateada < (new Carbon("16:00:00"))) {

                    $collectionTransacciones_AM->push([
                        "rango_horas" => $hora_inicio_formateada->toTimeString() . "-" . ($hora_inicio_formateada->addHour())->toTimeString(),
                        "transacciones_x_fecha" => $transacciones,
                    ]);
                } else {
                    $collectionTransacciones_PM->push([
                        "rango_horas" => $hora_inicio_formateada->toTimeString() . "-" . ($hora_inicio_formateada->addHour())->toTimeString(),
                        "transacciones_x_fecha" => $transacciones,
                    ]);
                }
            } else {
                $transacciones = Venta::selectRaw('ventas.fecha_venta as fecha_venta, count(ventas.total_venta) as TotalTransacciones')
                    ->whereBetween('hora_venta', [$hora_actual->toTimeString(), ($hora_inicio_formateada->addMinutes(59)->addSeconds(59))->toTimeString()])
                    ->where('tipo_pago', '<>', 'Comida Personal')
                    ->where('sucursal_id', $sucursal_id)
                    ->whereBetween('fecha_venta', [$fecha_inicio, $fecha_fin])
                    ->groupBy(['ventas.fecha_venta'])
                    ->get()->toArray();
                $hora_inicio_formateada->subMinutes(59)->subSeconds(59);
                $total = $this->totalTransacciones_x_Hora($transacciones);
                array_push($transacciones, [
                    "fecha_venta" => $fecha_inicio . "-" . $fecha_fin,
                    "TotalTransacciones" => $total,
                ]);

                if ($hora_inicio_formateada->toTimeString() < (new Carbon("16:00:00"))) {
                    $collectionTransacciones_AM->push([
                        "rango_horas" => $hora_inicio_formateada->toTimeString() . "-" . ($hora_inicio_formateada->addMinutes(59)->addSeconds(59))->toTimeString(),
                        "transacciones_x_fecha" => $transacciones,
                    ]);
                } else {
                    $collectionTransacciones_PM->push([
                        "rango_horas" => $hora_inicio_formateada->toTimeString() . "-" . ($hora_inicio_formateada->addMinutes(59)->addSeconds(59))->toTimeString(),
                        "transacciones_x_fecha" => $transacciones,
                    ]);
                }
            }
        }
        return view('ventas.reportes.reporteTransacciones', compact('collectionTransacciones_AM', 'collectionTransacciones_PM', 'sucursal_nombre', 'sucursales', 'fecha_inicio', 'fecha_fin', 'fechas'));
    }

    public function totalTransacciones_x_Hora($transacciones)
    {
        $total = 0;
        foreach ($transacciones as $transaccion) {
            $total += $transaccion['TotalTransacciones'];
        }

        return $total;
    }

    public function reporteVentas(Request $request)
    {

        if (isset($request->fecha_inicio)) {
            $fecha_inicio = $request->fecha_inicio;
            $fecha_fin =  $request->fecha_fin;
        } else {
            $fecha_inicio =  Carbon::now()->format('Y-m-d');
            $fecha_fin = Carbon::now()->format('Y-m-d');
        }

        $venta = DB::select(
            "select sum(ventas.total_venta) as total,ventas.sucursal_id,ventas.fecha_venta,turnos_ingresos.turno FROM `ventas`
             inner join turnos_ingresos on turnos_ingresos.id = ventas.turnos_ingreso_id where turnos_ingresos.fecha 
             BETWEEN '$fecha_inicio' and '$fecha_fin' GROUP by ventas.sucursal_id,ventas.fecha_venta,turnos_ingresos.turno order by
              ventas.sucursal_id, turnos_ingresos.turno , ventas.fecha_venta asc"
        );

        $sucursales =  Sucursal::orderBy('id', 'ASC')->get();

        return view('autorizaciones.reporteventa', compact('venta', 'fecha_inicio', 'fecha_fin', 'sucursales'));
    }

    public function ventas_fiscales(Request $request)
    {

        $fecha_inicial = $request->fecha_inicial;
        $fecha_final = $request->fecha_final;
        $fecha = Carbon::now()->toDateString();

        if (isset($fecha_inicial) && isset($fecha_final)) {

            $ventas_fiscales = Venta::selectRaw('sucursals.nombre as nombre_sucursal,
            sum(ventas.total_venta) as total_venta, 
            count(ventas.nro_transaccion) as total_transacciones,
            sum(ventas.nro_transaccion)/count(ventas.nro_transaccion) as ticket_promedio')
                ->join('detalles_ventas', 'detalles_ventas.venta_id', '=', 'ventas.id')
                ->join('platos', 'platos.id', '=', 'detalles_ventas.plato_id')
                ->join('platos_sucursales', 'platos_sucursales.plato_id', '=', 'platos.id')
                ->join('sucursals', 'sucursals.id', '=', 'platos_sucursales.sucursal_id')
                ->join('categorias_plato', 'categorias_plato.id', '=', 'platos_sucursales.categoria_plato_id')
                ->join('turnos_ingresos', 'turnos_ingresos.id', '=', 'ventas.turnos_ingreso_id')
                ->where('ventas.tipo_pago', "<>", 'Comida Personal')
                ->where('ventas.estado', 1)
                ->whereBetween('ventas.fecha_venta', [$fecha_inicial, $fecha_final])
                ->groupBy(['categorias_plato.nombre', 'sucursals.nombre'])
                ->get();
        } else {

            $ventas_fiscales = Venta::selectRaw('sucursals.nombre as nombre_sucursal,
            sum(ventas.total_venta) as total_venta, 
            count(ventas.nro_transaccion) as total_transacciones,
            sum(ventas.nro_transaccion)/count(ventas.nro_transaccion) as ticket_promedio')
                ->join('detalles_ventas', 'detalles_ventas.venta_id', '=', 'ventas.id')
                ->join('platos', 'platos.id', '=', 'detalles_ventas.plato_id')
                ->join('platos_sucursales', 'platos_sucursales.plato_id', '=', 'platos.id')
                ->join('sucursals', 'sucursals.id', '=', 'platos_sucursales.sucursal_id')
                ->join('categorias_plato', 'categorias_plato.id', '=', 'platos_sucursales.categoria_plato_id')
                ->join('turnos_ingresos', 'turnos_ingresos.id', '=', 'ventas.turnos_ingreso_id')
                ->where('ventas.tipo_pago', "<>", 'Comida Personal')
                ->where('ventas.estado', 1)
                ->whereBetween('ventas.fecha_venta', [$fecha, $fecha])
                ->groupBy(['categorias_plato.nombre', 'sucursals.nombre'])
                ->get();
        }

        return view('autorizaciones.ventas_fiscales', compact('ventas_fiscales', 'fecha'));
    }


 
}
