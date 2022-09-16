<?php

namespace App\Http\Controllers;

use App\Models\Bono;
use App\Models\Cargo;
use App\Models\CategoriaSancion;
use App\Models\CargoSucursal;
use App\Models\Categoria;
use App\Models\Contrato;
use App\Models\Descuento;
use App\Models\DetalleContrato;
use App\Models\Educacion;
use App\Models\Evaluacion;
use App\Models\EvaluacionUser;
use App\Models\EvaluacionUser2;
use App\Models\ExperienciaLaboral;
use App\Models\Habilidad;
use App\Models\RegistroAsistencia;
use App\Models\RegistroTarea;
use App\Models\Sucursal;
use App\Models\Sanciones;
use App\Models\Tarea;
use App\Models\TareaUser;
use App\Models\Turno;
use App\Models\TurnoIngreso;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserTarea;
use App\Models\Vacacion;
use App\Models\Venta;
use COM;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use LaraIzitoast\Toaster;
use LaraIzitoast\LaraIzitoastServiceProvider;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{

    public function index()
    {
        $personales = User::all();

        return view('personales.index', compact('personales'));
    }

    public function create()
    {
        $correo = 'donesco@gmail.com';
        $user_cod = rand(10000, 99999);
        $sucursales = Sucursal::all();
        $contratos = Contrato::all();
        return view('personales.create', compact('sucursales', 'contratos', 'user_cod', 'correo'));
    }
    public function showDetalleContrato($id)
    {
        $user = User::find($id);
        $detalleContratos = DetalleContrato::where('user_id', $id)->get();

        return view('personales.show', compact('user', 'detalleContratos'));
    }
    public function contratar(Request $request)
    {
        /* dd($request); */
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'fecha_nacimiento' => 'required',
            'carnet_identidad' => 'required',
            'domicilio' => 'required',
            'zona' => 'required',
            'nro_celular_personal' => 'required',
            'fecha_inicio_contrato' => 'required',
            'fecha_fin_contrato' => 'required',
            'codigo' => 'unique:users|max:5',
        ]);

        $contratar_personal = new User();
        $contratar_personal->email = $request->get('email');
        $contratar_personal->name = $request->get('nombre');
        $contratar_personal->apellido = $request->get('apellido');
        $contratar_personal->fecha_nacimiento = $request->get('fecha_nacimiento');
        $contratar_personal->ci = $request->get('carnet_identidad');
        $contratar_personal->domicilio = $request->get('domicilio');
        $contratar_personal->zona = $request->get('zona');
        $contratar_personal->celular_personal = $request->get('nro_celular_personal');
        $contratar_personal->celular_referencia = $request->get('nro_celular_referencia');
        $contratar_personal->password = '12345678';
        $contratar_personal->estado = 1;
        $contratar_personal->codigo =  $request->get('codigo');
        $contratar_personal->tipo_usuario_id =  2;
        if ($request->hasFile("foto")) {
            $file = $request->file('foto');
            $destinationPath = 'img/contratos/';
            $filename = time() . '-' . $file->getClientOriginalName();
            $uploadSuccess = $request->file('foto')->move($destinationPath, $filename);
            $contratar_personal->foto = $destinationPath . $filename;
        }
        $contratar_personal->save();


        if ($contratar_personal->save()) {
            for ($i = 0; $i < sizeof($request->habilidades); $i++) {
                if ($request->habilidades[$i] != "") {
                    Habilidad::create([
                        'habilidad' => $request->habilidades[$i],
                        'user_id' => $contratar_personal->id,
                    ]);
                }
            }
            for ($j = 0; $j < sizeof($request->nombre_empresas); $j++) {
                if ($request->cargos[$j] != "" && $request->nombre_empresas[$j] != "") {
                    ExperienciaLaboral::create([
                        'cargo' => $request->cargos[$j],
                        'nombre_empresa' => $request->nombre_empresas[$j],
                        'descripcion' => $request->descripciones[$j],
                        'user_id' => $contratar_personal->id,
                    ]);
                }
            }
            for ($j = 0; $j < sizeof($request->instituciones); $j++) {
                if ($request->instituciones[$j] != "" && $request->carreras[$j] != "" && $request->fecha_inicio_educacion[$j] != "" && $request->fecha_fin_educacion[$j] != "") {
                    Educacion::create([
                        'nombre_institucion' => $request->instituciones[$j],
                        'nombre_carrera' => $request->carreras[$j],
                        'fecha_inicio_educacion' => $request->fecha_inicio_educacion[$j],
                        'fecha_fin_educacion' => $request->fecha_fin_educacion[$j],
                        'user_id' => $contratar_personal->id,
                    ]);
                }
            }

            DetalleContrato::create([
                'fecha_inicio_contrato' => $request->fecha_inicio_contrato,
                'fecha_fin_contrato' => $request->fecha_fin_contrato,
                'disponibilidad' => $request->disponibilidad,
                'contrato_id' => $request->contrato_id,
                'user_id' =>  $contratar_personal->id,
            ]);
        }
        return redirect()->route('personales.index')->with('contratar', 'ok');
    }

    public function actualizarContratoUser(Request $request)
    {
        $request->validate([
            'fecha_inicio_contrato' => 'required',
            'fecha_fin_contrato' => 'required',
        ]);
        $detalleContrato = new DetalleContrato();
        $detalleContrato->fecha_inicio_contrato = $request->get('fecha_inicio_contrato');
        $detalleContrato->fecha_fin_contrato = $request->get('fecha_fin_contrato');
        $detalleContrato->disponibilidad = $request->get('disponibilidad');
        $detalleContrato->contrato_id = $request->get('contrato_id');
        $detalleContrato->user_id = $request->get('usuario_id');

        $detalleContrato->save();

        if ($detalleContrato->save()) {
            return redirect()->route('personales.showDetalleContrato', $detalleContrato->user_id);
        }
    }

    public function editContratoUser($id)
    {
        $contratos = Contrato::all();
        $usuario = User::find($id);
        $detalleContratos = DetalleContrato::where('user_id', $id)->get();
        return view('personales.contratos.editContratoUser', compact('contratos', 'usuario'));
    }

    public function editBonoUser($id)
    {
        $usuario = User::find($id);
        $bono = Bono::where('user_id', $id)->get();
        return view('personales.bonos.editBonoUser', compact('bono', 'usuario'));
    }

    public function editDescountUser($id)
    {
        $usuario = User::find($id);
        $descuento = Descuento::where('user_id', $id)->get();
        return view('personales.descuentos.editDescountUser', compact('usuario', 'descuento'));
    }

    public function editSanctionsUser($id)
    {
        $user = User::find($id);
        $categoria = Categoria::all();
        $users = User::all();
        $sucursales = Sucursal::all();
        $sanciones = CategoriaSancion::all();

        $sancion = Sanciones::where('user_id', $id)->get();

        return view('personales.sanciones.editSanctionsUser', compact('user', 'categoria', 'sancion', 'users', 'sucursales', 'sanciones'));
    }


    public function editDatosBasicos($id)
    {
        $roles = Role::all();
        $cargos = CargoSucursal::all();
        $usuario = User::find($id);
        return view('personales.datos_basicos.editDatosBasicos', compact('usuario', 'roles', 'cargos'));
    }

    public function actualizarDatosBasicos($id, Request $request)
    {
        $user = User::find($id);
        //Metodo para sincronizar roles un usuario
        $user->roles()->sync($request->roles);
        $user->cargosucursals()->sync($request->cargosucursals);
        $user->name = $request->get('nombre');
        $user->apellido = $request->get('apellido');
        $user->domicilio = $request->get('domicilio');
        $user->zona = $request->get('zona');
        $user->celular_personal = $request->get('celular_personal');
        $user->celular_referencia = $request->get('celular_referencia');
        $user->email = $request->get('email');
        $user->ci = $request->get('ci');
        $user->estado = $request->get('estado');
        /* $mi_imagen = public_path() . '/imgages/products/mi_imagen.jpg'; */
        if ($request->hasFile("foto")) {
            if (isset($user->foto)  ) {
                unlink($user->foto);
                $file = $request->file('foto');
                $destinationPath = 'img/contratos/';
                $filename = time() . '-' . $file->getClientOriginalName();
                $uploadSuccess = $request->file('foto')->move($destinationPath, $filename);
                $user->foto = $destinationPath . $filename;
            } else {
                $file = $request->file('foto');
                $destinationPath = 'img/contratos/';
                $filename = time() . '-' . $file->getClientOriginalName();
                $uploadSuccess = $request->file('foto')->move($destinationPath, $filename);
                $user->foto = $destinationPath . $filename;
            }
        }
        $user->save();

        return redirect()->route('personales.showDetalleContrato', $user->id)->with('actualizado', 'ok');
    }

    public function vencimientoContratos()
    {
        /* $user =  User::all();
        $user_id = User::where('estado',1)->get(); */


        /*       $detalleContratos = DetalleContrato::where('user_id',$user_id[0]->id); */
        $detalleContratos =  DetalleContrato::all();

        return view('personales.reportes.vencimientoContratos', compact('detalleContratos'));
    }

    public function filtrarContratos(Request $request)
    {
        $fecha_inicial = $request->get('fecha_inicial');
        $fecha_final = $request->get('fecha_final');

        $detalleContratos = DetalleContrato::where('fecha_fin_contrato', '>=', $fecha_inicial)->where('fecha_fin_contrato', '<=', $fecha_final)->get();
        return view('personales.reportes.vencimientoContratos', compact('detalleContratos'));
    }
    public function rolesPersonales($id)
    {
        $roles = Role::all();
        $usuario = User::find($id);
        return redirect()->route('personales.rolesPersonales', compact('usuario', 'roles'));
    }

    public function retiroForm($id)
    {
        $user = User::find($id);
        return view('personales.contratos.retiroForm', compact('user'));
    }

    public function retiroFormSave(Request $request)
    {
        dd($request);
    }

    public function asignarSucursal($id)
    {
        $user = User::find($id);
        $sucursales = Sucursal::all();
        return view('personales.datos_basicos.asignarSucursal', compact('user', 'sucursales'));
    }

    public function saveasignarSucursal($id, Request $request)
    {

        $user = User::find($id);
        $user->sucursals()->sync($request->sucursals);
        $user->save();

        return redirect()->route('personales.index');
    }

    /*View para Asignar un cargo a un User */
    public function asignarCargo($id)
    {
        $user = User::find($id);
        $cargos = CargoSucursal::all();

        return view('personales.datos_basicos.asignarCargo', compact('user', 'cargos'));
    }

    /*Guardar cargos */
    public function saveAsignarCargo($id, Request $request)
    {
        $user = User::find($id);
        $user->cargosucursals()->sync($request->cargosucursals);


        return redirect()->route('personales.index');
    }

    public function cronologiaPersonales($id)
    {
        $user = User::find($id);
        $data = [];
        for ($i = 4; $i >= 0; $i--) {
            $fecha = Carbon::now()->locale('es')->subMonth($i);
            /* echo $fecha->monthName . "<br>"; */
            $sanciones = Sanciones::where('user_id', $user->id)->whereBetween('fecha', [$fecha->startOfMonth()->format('Y-m-d'), $fecha->endOfMonth()->format('Y-m-d')])->count();
            $bonos = Bono::where('user_id', $user->id)->whereBetween('fecha', [$fecha->startOfMonth()->format('Y-m-d'), $fecha->endOfMonth()->format('Y-m-d')])->count();
            $descuentos = Descuento::where('user_id', $user->id)->whereBetween('fecha', [$fecha->startOfMonth()->format('Y-m-d'), $fecha->endOfMonth()->format('Y-m-d')])->count();
            $vacaciones = Vacacion::where('user_id', $user->id)->whereBetween('fecha_inicio', [$fecha->startOfMonth()->format('Y-m-d'), $fecha->endOfMonth()->format('Y-m-d')])->count();

            $totales = [
                'nombre_mes' => ucfirst($fecha->monthName),
                'sanciones' => $sanciones,
                'bonos' => $bonos,
                'descuentos' => $descuentos,
                'vacaciones' => $vacaciones,
            ];

            array_push($data, $totales);
        }

        return view('personales.reportes.cronologiaPersonales', compact('user', 'data'));
    }

    public function listaTareas()
    {
        $user_login = Auth::id();
        $user = User::find($user_login);
        $fecha_actual = Carbon::now()->locale('es')->isoFormat('dddd');

        if (isset($user->cargosucursales[0])) {
            $cargo_id = $user->cargosucursals[0]->id;
        }

        //dd( $user->cargosucursals ) ;

        if (isset($user->cargosucursals[0]->id)) {
            $cargo_id = $user->cargosucursals[0]->id;
        } else {
            return redirect()->route('home')->with('status', 'false');
        }

        ///echo $cargo_id;

        $tareas = Tarea::where('cargo_id', '=', $cargo_id)
            ->where('sucursal_id', Auth::user()->sucursals[0]->id)
            ->where('dia_semana', $fecha_actual)
            ->orWhere('dia_semana', 'todos')
            ->get();

        // dd($tareas);
        // dd( $tareas );

        $fecha_actual = Carbon::now()->format('Y-m-d');
        $pivot = TareaUser::where('user_id', $user_login)->whereDate('created_at', $fecha_actual)->get();

        if (isset($pivot[0])) {
            $pivote = $pivot;
        } else {
            $pivote = 0;
        }

        /* dd($pivote);  */

        return view('personales.tareas.tarea', compact('tareas', 'user', 'pivote', 'fecha_actual'));
    }

    public function saveTareas($id, Request $request)
    {
        //dd($request);
        $user = User::find($id);
        
        $fecha_actual = Carbon::now()->format('Y-m-d');
        
        
        $tareas = Tarea::where('cargo_id', '=', $user->cargosucursales[0]->id)
        ->where('sucursal_id', Auth::user()->sucursals[0]->id)
        ->where('dia_semana', $fecha_actual)
        ->orWhere('dia_semana', 'todos')
        ->get();
        /* dd($tareas); */
        $user->tareas()->attach($request->tareas);
        $pivot = TareaUser::where('user_id', $user->id)->whereDate('created_at', $fecha_actual)->get();

        if (isset($pivot[0])) {
            $pivote = $pivot;
        } else {
            $pivote = 0;
        }


        /* dd($pivote); */

        return redirect()->route('personales.listaTareas', compact('user', 'pivot', 'tareas'));
    }

    public function reporteTareas()
    {
        $usuarios = User::all();
        return view('personales.tareas.reporteTareas',  compact('usuarios'));
    }

    public function actividadesUsuario($id)
    {
        $user_log = Auth::user();
        $sucursal_usuario = $user_log->sucursals[0]->id;
        $user = User::find($id);
        $cargo_id = $user->cargosucursals[0]->id;

        $tareas_ingreso = Tarea::where('cargo_id', '=', $cargo_id)
            ->where('sucursal_id', $sucursal_usuario)
            ->where('turno', 'Ingreso')
            ->get();

        $tareas_preturno = Tarea::where('cargo_id', '=', $cargo_id)
            ->where('sucursal_id', $sucursal_usuario)
            ->where('turno', 'Pre Turno')
            ->get();

        $tareas_despacho = Tarea::where('cargo_id', '=', $cargo_id)
            ->where('sucursal_id', $sucursal_usuario)
            ->where('turno', 'Despacho')
            ->get();

        $tareas_turno = Tarea::where('cargo_id', '=', $cargo_id)
            ->where('sucursal_id', $sucursal_usuario)
            ->where('turno', 'Turno')
            ->get();

        $tareas_posturno = Tarea::where('cargo_id', '=', $cargo_id)
            ->where('sucursal_id', $sucursal_usuario )
            ->where('turno', 'Post Turno')
            ->get();

        //dd($tareas_ingreso);

        $fecha = Carbon::now();
        
        $tarea_user = TareaUser::whereBetween('created_at', [$fecha->startOfDay()->format('Y-m-d H:i:s'), $fecha->endOfDay()->format('Y-m-d H:i:s')])
        ->where('user_id', $user->id)
        ->get();

        /* dd($tarea_user);  */
        return view('personales.tareas.actividadesUsuario', compact('user', 'fecha', 'tareas_ingreso', 'tareas_preturno', 'tareas_despacho', 'tareas_turno', 'tareas_posturno', 'tarea_user'));
    }
    public function filtrarActividades(Request $request, $id)
    {

        $user_log = Auth::user();
        $sucursal_usuario = $user_log->sucursals[0]->id;

        $fecha = new Carbon($request->get('fecha_inicial'));
        $user = User::find($id);
        $cargo_id = $user->cargosucursals[0]->id;
        $tareas_ingreso = Tarea::where('cargo_id', '=', $cargo_id)
            ->where('sucursal_id', $sucursal_usuario)
            ->where('turno', 'Ingreso')
            ->get();

        $tareas_preturno = Tarea::where('cargo_id', '=', $cargo_id)
            ->where('sucursal_id', $sucursal_usuario)
            ->where('turno', 'Pre Turno')
            ->get();

        $tareas_despacho = Tarea::where('cargo_id', '=', $cargo_id)
            ->where('sucursal_id', $sucursal_usuario)
            ->where('turno', 'Despacho')
            ->get();

        $tareas_turno = Tarea::where('cargo_id', '=', $cargo_id)
            ->where('sucursal_id', $sucursal_usuario)
            ->where('turno', 'Turno')
            ->get();

        $tareas_posturno = Tarea::where('cargo_id', '=', $cargo_id)
            ->where('sucursal_id', $sucursal_usuario)
            ->where('turno', 'Post Turno')
            ->get();
        /* dd($tareas); */
        
        $tarea_user = TareaUser::whereBetween('created_at', [$fecha->startOfDay()->format('Y-m-d H:i:s'), $fecha->endOfDay()->format('Y-m-d H:i:s')])
        ->where('user_id', $user->id)
        ->get();
        
        return view('personales.tareas.actividadesUsuario', compact(
            'user',
            'fecha',
            'tareas_ingreso',
            'tarea_user',
            'tareas_preturno',
            'tareas_turno',
            'tareas_despacho',
            'tareas_posturno'
        ));
    }

    public function marcadoAsistencia()
    {

        $fecha = Carbon::today()->format('d-m-Y');
        $hora_entrada = Carbon::now()->format('H:m:s');
        /* 
        RegistroAsistencia::create([
            'fecha'=> $fecha,
            'hora_entrada' => $hora_entrada,
            'hora_salida' => null,
            'user_id'=> $user,
        ]); */
        return view('personales.marcadoAsistencia', compact('fecha', 'hora_entrada'));
    }

    public function marcar_asistencia(Request $request)
    {
        $user_log = Auth::user();
        $sucursal_usuario = $user_log->sucursals[0]->id;
        $mensaje_de_alerta = "";
        $user = User::where('codigo', $request->get('codigo'))->first();
        $fecha = Carbon::now()->format('Y-m-d');
        $hora_entrada_p =  Carbon::now()->format('H:i:s');
        $hora_entrada =  new Carbon($hora_entrada_p);
        /* dd($hora_entrada); */
 
        if ($user == null) {
            $mensaje_de_alerta = "Codigo de Usuario Incorrecto";
            return redirect()->route('marcadoAsistencia')->with('mensaje', $mensaje_de_alerta);
        }

        $hora_salida_am = DB::select("select hora_salida from registro_asistencia where fecha='$fecha' and user_id='$user->id' and turno=0");
        $hora_salida_pm = DB::select("select hora_salida from registro_asistencia where fecha='$fecha' and user_id='$user->id' and turno=1");

        if ($hora_salida_am == null) {
            RegistroAsistencia::create([
                'fecha' => $fecha,
                'hora_entrada' => $hora_entrada,
                'hora_salida' => 0,
                'user_id' => $user->id,
                'turno' => 0,
                'sucursal_id' => $user->sucursals[0]->id,
            ]);
            $mensaje_de_alerta = "Registro de Ingreso Exitoso";
            return redirect()->route('marcadoAsistencia')->with('mensaje', $mensaje_de_alerta);

        } else {
            

            if ($hora_salida_am[0]->hora_salida == "00:00:00") {

                $venta_turno_am = TurnoIngreso::select('ventas')
                ->where('turno',0)  /* 0 es Am 1 es Pm  */
                ->where('fecha',$fecha)
                ->where('sucursal_id',$user->sucursals[0]->id)
                ->get();
                /* dd($venta_turno_am); */

                $hora_entrada_final_am =DB::table('registro_asistencia')
                ->select('hora_entrada')
                ->where('fecha',$fecha)
                ->where('turno',0)
                ->where('user_id',$user->id)
                ->get();
                

                $horas_trabajadas_am = $hora_entrada->diffInHours($hora_entrada_final_am[0]->hora_entrada); 
                
                 $hora_final = DB::table('registro_asistencia')
                ->where('user_id', $user->id)
                ->update([
                    'hora_salida' => $hora_entrada,   
                    'horas_trabajadas' => $horas_trabajadas_am, 
                ]); 
                
           
                $mensaje_de_alerta = "Registro de Salida Exitoso";
                return redirect()->route('marcadoAsistencia')->with('mensaje', $mensaje_de_alerta);
            } else {
                
                if ($hora_salida_pm == null) {
                    RegistroAsistencia::create([
                        'fecha' => $fecha,
                        'hora_entrada' => $hora_entrada,
                        'hora_salida' => 0,
                        'user_id' => $user->id,
                        'turno' => 1,
                        'sucursal_id' => $user->sucursals[0]->id,
                    ]);
                    $mensaje_de_alerta = "Registro de Ingreso Exitoso";
                    return redirect()->route('marcadoAsistencia')->with('mensaje', $mensaje_de_alerta);
                } else {

                
                    if ($hora_salida_pm[0]->hora_salida == "00:00:00") {

                        $venta_turno_pm = TurnoIngreso::select('ventas')
                        ->where('turno',1)  /* 0 es Am 1 es Pm  */
                        ->where('fecha',$fecha)
                        ->where('sucursal_id',$user->sucursals[0]->id)
                        ->get();

                        dd($venta_turno_pm);

                        $hora_entrada_final_pm =DB::table('registro_asistencia')
                        ->select('hora_entrada')
                        ->where('fecha',$fecha)
                        ->where('turno',1)
                        ->where('user_id',$user->id)
                        ->get();
                        
                        $horas_trabajadas_pm = $hora_entrada->diffInHours($hora_entrada_final_pm[0]->hora_entrada); 
                        
                        
                        $hora_final = DB::table('registro_asistencia')
                        ->where('user_id', $user->id)
                        ->where('turno', 1)
                        ->update([
                            'hora_salida' => $hora_entrada,
                            'horas_trabajadas' => $horas_trabajadas_pm
                        ]);
                        
                        $mensaje_de_alerta = "Registro de Salida Exitoso";
                        return redirect()->route('marcadoAsistencia')->with('mensaje', $mensaje_de_alerta);
                    } else {
                        $mensaje_de_alerta = "Ya Registro de Salida y Entrada Exitoso";
                        return redirect()->route('marcadoAsistencia')->with('mensaje', $mensaje_de_alerta);
                    }
                }
            }
        }
    }

    public function reporteMarcadoAsistencia(Request $request)
    {
        $fecha_marcado_inicial = $request->get('fecha_inicial');
        $fecha_marcado_final = $request->get('fecha_final');
        $sucursales = Sucursal::all();

        $user_rol = Auth::user()->roles[0]->id;
        $user_sucursal = Auth::user()->sucursals[0]->id;
        if ($user_rol ==3){
            $registros = RegistroAsistencia::where('fecha', Carbon::now()->format('Y-m-d'))
            ->where('sucursal_id',$user_sucursal)
            ->get();
        }else{
            $registros = RegistroAsistencia::where('fecha', Carbon::now()->format('Y-m-d'))->get();
        }

        return view('personales.reportes.reporteMarcadoAsistencia', compact('registros', 'fecha_marcado_inicial', 'fecha_marcado_final', 'sucursales'));
    }

    public function filtrarMarcadoAsistencia(Request $request)
    {
        $fecha_marcado_inicial = $request->get('fecha_inicial');
        $fecha_marcado_final = $request->get('fecha_final');
        $sucursal_id = $request->get('sucursal_id');

        
        $sucursales = Sucursal::all();

        if ($sucursal_id != 0) {
            $registros = RegistroAsistencia::where('fecha', '>=', $fecha_marcado_inicial)->where('fecha', '<=', $fecha_marcado_final)->where('sucursal_id', $sucursal_id)->get();
        } else {
            $registros = RegistroAsistencia::where('fecha', '>=', $fecha_marcado_inicial)->where('fecha', '<=', $fecha_marcado_final)->get();
        }


        return view('personales.reportes.reporteMarcadoAsistencia', compact('registros', 'fecha_marcado_inicial', 'fecha_marcado_final', 'sucursales'));
    }
    public function listaEvaluaciones()
    {
        $evaluaciones = Evaluacion::all();
        $user_login = Auth::id();
        $user = User::find($user_login);
        $role = $user->roles();
        $sucursales = $user->sucursals[0];
        foreach ($user->roles as $rol) {
            if ($rol->id == 3) {
                $usuarios = User::whereHas('sucursals', function ($q) {
                    $id = Auth::id();
                    $user = User::find($id);
                    $sucursales = $user->sucursals[0];

                    $q->where('sucursals.id', '=',   $sucursales->id);
                })->get();
                return view('personales.evaluaciones.evaluaciones', compact('usuarios', 'sucursales', 'evaluaciones', 'user_login'));
            } else {
                $usuarios = User::all();
                $sucursales = Sucursal::all();
                return view('personales.evaluaciones.evaluaciones', compact('usuarios', 'sucursales', 'evaluaciones', 'user_login'));
            }
        }
    }
    public function guardarEvaluaciones(Request $request)
    {
        try {

            for ($i = 0; $i < sizeof($request->valor_evaluacion); $i++) {
                $evaluaciones_user = new EvaluacionUser();
                $evaluaciones_user->puntaje = $request->valor_evaluacion[$i];
                $evaluaciones_user->evaluacion_id = $request->evaluaciones_id[$i];
                $evaluaciones_user->user_id = $request->user_id_evaluado;
                $evaluaciones_user->save();

                $evaluaciones_user2 = new EvaluacionUser2();
                $evaluaciones_user2->evaluacion_user =  $evaluaciones_user->id;
                $evaluaciones_user2->user_id = $request->user_id;
                $evaluaciones_user2->save();
            }
            if ($evaluaciones_user->save() &&  $evaluaciones_user2->save()) {
                $data = [
                    'success' => true,
                ];
                return response()->json($data);
            } else {

                $data = [
                    'success' => false,
                ];
                return response()->json($data);
            }
        } catch (Exception $e) {
            return $e;
        }
    }
    public function reporteEvaluaciones()
    {
        $usuarios = User::all();
        return view('personales.evaluaciones.reporteEvaluaciones',  compact('usuarios'));
    }
    public function evaluacionesUsuario($id)
    {
        $user = User::find($id);
        $fecha = Carbon::now();
        $evaluaciones_user = EvaluacionUser::where('user_id', $user->id)->whereBetween('created_at', [$fecha->startOfDay()->format('Y-m-d H:i:s'), $fecha->endOfDay()->format('Y-m-d H:i:s')])->get();
        if (isset($evaluaciones_user[0])) {
            $user_id = EvaluacionUser2::where('evaluacion_user', $evaluaciones_user[0]->id)->get();
            $evaluador = User::where('id', $user_id[0]->user_id)->get();
            return view('personales.evaluaciones.evaluacionesUsuario', compact('user', 'fecha', 'evaluaciones_user', 'evaluador'));
        }
        return view('personales.evaluaciones.evaluacionesUsuario', compact('user', 'fecha', 'evaluaciones_user'));
    }

    public function filtrarEvaluacionUsuario(Request $request, $id)
    {
        $user = User::find($id);
        $fecha = new Carbon($request->get('fecha_inicial'));
        $evaluaciones_user = EvaluacionUser::where('user_id', $user->id)->whereBetween('created_at', [$fecha->startOfDay()->format('Y-m-d H:i:s'), $fecha->endOfDay()->format('Y-m-d H:i:s')])->get();
        if (isset($evaluaciones_user[0])) {
            $user_id = EvaluacionUser2::where('evaluacion_user', $evaluaciones_user[0]->id)->get();
            $evaluador = User::where('id', $user_id[0]->user_id)->get();
            return view('personales.evaluaciones.evaluacionesUsuario', compact('user', 'fecha', 'evaluaciones_user', 'evaluador'));
        }
        return view('personales.evaluaciones.evaluacionesUsuario', compact('user', 'fecha', 'evaluaciones_user'));
    }

    public function assignTurnView($id)
    {
        $user = User::find($id);
        $turnos = Turno::all();

        return view('personales.datos_basicos.assignTurnView', compact('user', 'turnos'));
    }

    public function assignTurn($id, Request $request)
    {
        $users = User::find($id);
        $users->turnos()->sync($request->turnos);

        return redirect()->route('personales.assignTurnView', $users->id);
    }

    public function reporteSeguimientoActividades(Request $request)
    {
        $user = User::find($request->idusuario);
        //dd( count($user->cargosucursals) );
        $cargo_id = count($user->cargosucursals) == 0 ? 0 : $user->cargosucursals[0]->id;

        $fecha = Carbon::now();
        $desde = new Carbon($request->desde);
        $hasta = new Carbon($request->hasta);
        //$tareas_preturno = Tarea::where('cargo_id', '=', $cargo_id)->where('turno', 'Pre Turno')->whereBetween('created_at',[ (is_null($desde)?$fecha->startOfDay()->format('Y-m-d H:i:s'):$desde)  , (is_null($hasta)?$fecha->endOfDay()->format('Y-m-d H:i:s'):$hasta->endOfDay())  ])->get();
        $tareas_ingreso = Tarea::where('cargo_id', '=', $cargo_id)->where('turno', 'Ingreso')->get();
        $tareas_preturno = Tarea::where('cargo_id', '=', $cargo_id)->where('turno', 'Pre Turno')->get();
        $tareas_despacho = Tarea::where('cargo_id', '=', $cargo_id)->where('turno', 'Despacho')->get();
        $tareas_turno = Tarea::where('cargo_id', '=', $cargo_id)->where('turno', 'Turno')->get();
        $tareas_posturno = Tarea::where('cargo_id', '=', $cargo_id)->where('turno', 'Post Turno')->get();
        $tarea_user = TareaUser::whereBetween('created_at', [(is_null($desde) ? $fecha->startOfDay()->format('Y-m-d H:i:s') : $desde), (is_null($hasta) ? $fecha->endOfDay()->format('Y-m-d H:i:s') : $hasta->endOfDay())])->where('user_id', $user->id)->get();

        $totalevaluados = Tarea::selectRaw(
            'turno, count( tarea_user.id ) as total'
        )->leftJoin('tarea_user', 'tarea_user.tarea_id', '=', 'tareas.id')
            ->where('tarea_user.user_id', $user->id)
            ->whereBetween('tarea_user.created_at', [(is_null($desde) ? $fecha->startOfDay()->format('Y-m-d H:i:s') : $desde), (is_null($hasta) ? $fecha->endOfDay()->format('Y-m-d H:i:s') : $hasta->endOfDay())])
            ->groupBy(['turno'])->get();

        return view('reportes.showuser', compact('totalevaluados', 'user', 'fecha', 'tareas_ingreso', 'tareas_preturno', 'tareas_despacho', 'tareas_turno', 'tareas_posturno', 'tarea_user', 'desde', 'hasta'));
    }

    public function obtenerTotales()
    {
        
    }

    public function mostrarUsuarios()
    {
        $usuarios = User::all();
        return view('reportes.index', compact('usuarios'));
    }
}
