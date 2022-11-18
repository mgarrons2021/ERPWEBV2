<?php

namespace App\Models;

use App\Models\Siat\EventoSignificativo;
use App\Models\Siat\SiatCufd;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Siat\DocumentoSector;
use App\Models\siat\DocumentoIdentidad;
use App\Models\Siat\LeyendaFactura;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Venta extends Model
{
    use HasFactory;
    protected $table = 'ventas';
    protected $fillable =
    [
        'fecha_venta', 'hora_venta', 'numero_factura', 'nro_transaccion',
        'total_venta', 'total_descuento', 'total_neto',
        'tipo_pago', 'estado', 'estado_emision', 'user_id',
        'cliente_id', 'sucursal_id', 'turnos_ingreso_id',
        'codigo_control', 'qr', 'cuf', 'evento_significativo_id',
        'documento_identidad_id', 'leyenda_factura_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function autorizacion()
    {
        return $this->belongsTo(Autorizacion::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function turno_ingreso()
    {
        return $this->belongsTo(TurnoIngreso::class);
    }

    public function registros_visitas()
    {
        return $this->hasMany(RegistroVisita::class);
    }

    public function evento_significativo()
    {
        return $this->belongsTo(EventoSignificativo::class);
    }

    public function cufd()
    {
        return $this->belongsTo(SiatCufd::class);
    }

    public function documento_identidad()
    {
        return $this->belongsTo(DocumentoIdentidad::class);
    }

    public function leyenda_factura()
    {
        return $this->belongsTo(LeyendaFactura::class);
    }

    public function getSales($fecha_inicio, $fecha_fin, $sucursal)
    {
        $fecha = Carbon::now()->toDateString();
        if (isset($fecha_inicio) && isset($fecha_fin)) {
            /*   return $fecha_inicio; */
            $plates = Venta::where('sucursal_id', $sucursal)->whereBetween('fecha_venta', [$fecha_inicio, $fecha_fin])->get();
            /* $sql = "select (@rownum:=@rownum+1) AS nro_registro,ventas.id , ventas.fecha_venta ,users.name as user, ventas.hora_venta , turnos_ingreso_id as turno , ventas.tipo_pago, ventas.total_venta, ventas.estado,
                ventas.numero_factura,ventas.lugar , ventas.nro_transaccion,turnos_ingresos.turno
                from (SELECT @rownum:=0) r,ventas 
                inner join users on users.id= ventas.user_id
                inner join turnos_ingresos on turnos_ingresos.id= ventas.turnos_ingreso_id
                where ventas.fecha_venta between $fecha_inicio and $fecha_fin and ventas.sucursal_id = $sucursal";
            $plates = DB::select($sql); */
            return $plates;
        } else {
            /*  return $sucursal; */
            $plates = Venta::where('sucursal_id', $sucursal)->whereBetween('fecha_venta', [$fecha, $fecha])->get();
            /* $sql = "select (@rownum:=@rownum+1) AS nro_registro,ventas.id , ventas.fecha_venta , users.name as user, ventas.hora_venta , turnos_ingreso_id as turno , ventas.tipo_pago , ventas.total_venta , ventas.estado, 
            ventas.numero_factura,ventas.lugar, ventas.nro_transaccion,turnos_ingresos.turno
            from (SELECT @rownum:=0) r,ventas  
            inner join users on users.id= ventas.user_id       
            inner join turnos_ingresos on turnos_ingresos.id= ventas.turnos_ingreso_id
            where ventas.fecha_venta between $fecha and $fecha and ventas.sucursal_id = $sucursal";
            $plates = DB::select($sql); */
            return $plates;
        }
    }

    public function getsalesDetail($venta_id)
    {

        $sql = "select platos.id as plato_id, platos.nombre , detalles_ventas.cantidad , detalles_ventas.precio , detalles_ventas.subtotal, detalles_ventas.descuento as descuento
        from ventas 
        JOIN detalles_ventas on detalles_ventas.venta_id = ventas.id
        JOIN platos on platos.id = detalles_ventas.plato_id
        and ventas.id = $venta_id
        order by detalles_ventas.plato_id";

        $plates_detail = DB::select($sql);
        return $plates_detail;
    }



    public function obtener_ventas_x_plato($turno_id, $sucursal_id)
    {

        $ventas_turnos = Venta::selectRaw('platos.nombre, sum( detalles_ventas.cantidad) as cantidad, sum(detalles_ventas.subtotal) as subtotal')
            ->join('detalles_ventas', 'detalles_ventas.venta_id', '=', 'ventas.id')
            ->join('platos', 'platos.id', '=', 'detalles_ventas.plato_id')
            ->join('turnos_ingresos', 'turnos_ingresos.id', '=', 'ventas.turnos_ingreso_id')
            ->where('ventas.turnos_ingreso_id', $turno_id)
            ->where('ventas.sucursal_id', $sucursal_id)
            ->groupBy(['platos.nombre'])
            ->get();

        return  $ventas_turnos;
    }

    public function obtener_ventas_x_categoria($turno_id)
    {
        $ventas_turnos_categoria = Venta::selectRaw('categorias_plato.nombre, sum(detalles_ventas.cantidad) as cantidad, sum(detalles_ventas.subtotal) as subtotal')
            ->join('detalles_ventas', 'detalles_ventas.venta_id', '=', 'ventas.id')
            ->join('platos', 'platos.id', '=', 'detalles_ventas.plato_id')
            ->join('platos_sucursales', 'platos_sucursales.plato_id', '=', 'platos.id')
            ->join('categorias_plato', 'categorias_plato.id', '=', 'platos_sucursales.categoria_plato_id')
            ->join('turnos_ingresos', 'turnos_ingresos.id', '=', 'ventas.turnos_ingreso_id')
            ->where('ventas.turnos_ingreso_id', $turno_id)
            ->groupBy(['categorias_plato.nombre'])
            ->get();

        return $ventas_turnos_categoria;
    }

    public function obtener_comida_personal($turno_id)
    {

        $obtener_comida_personal = Venta::selectRaw('platos.nombre, sum(detalles_ventas.cantidad) as cantidad , sum(detalles_ventas.subtotal) as subtotal')
            ->join('detalles_ventas', 'detalles_ventas.venta_id', '=', 'ventas.id')
            ->join('platos', 'platos.id', '=', 'detalles_ventas.plato_id')
            ->join('turnos_ingresos', 'turnos_ingresos.id', '=', 'ventas.turnos_ingreso_id')
            ->where('ventas.tipo_pago', '=', 'Comida Personal')
            ->where('ventas.turnos_ingreso_id', $turno_id)
            ->groupBy(['ventas.tipo_pago', 'platos.nombre'])
            ->get();

        return $obtener_comida_personal;
    }

    public function obtener_ventas_anuladas($turno_id)
    {

        $obtener_ventas_anuladas = Venta::selectRaw('platos.nombre, sum(detalles_ventas.cantidad) as cantidad , sum(detalles_ventas.subtotal) as subtotal')
            ->join('detalles_ventas', 'detalles_ventas.venta_id', '=', 'ventas.id')
            ->join('platos', 'platos.id', '=', 'detalles_ventas.plato_id')
            ->join('turnos_ingresos', 'turnos_ingresos.id', '=', 'ventas.turnos_ingreso_id')
            ->where('turnos_ingresos.id', $turno_id)
            ->where('ventas.estado', 0)
            ->groupBy(['platos.nombre'])
            ->get();

        return $obtener_ventas_anuladas;
    }



    public function sales_for_id($id_venta)
    {
        $venta = Venta::selectRaw("ventas.numero_factura,ventas.cuf,clientes.id as idcliente , clientes.contador_visitas, autorizaciones.nro_autorizacion, ventas.sucursal_id as sucursal,  
         sucursals.nombre as sucursal_nombre, ventas.codigo_control,  clientes.telefono,autorizaciones.fecha_fin,autorizaciones.nit,ventas.fecha_venta,ventas.hora_venta, ventas.evento_significativo_id,
        clientes.nombre,clientes.ci_nit,clientes.complemento, ventas.total_venta , ventas.total_descuento, ventas.total_neto,ventas.tipo_pago,ventas.qr,clientes.telefono, clientes.correo, ventas.leyenda_factura_id as leyendaID,
        sucursals.direccion, sucursals.codigo_fiscal")
            ->join('sucursals', 'sucursals.id', '=', 'ventas.sucursal_id')
            ->Leftjoin('clientes', 'clientes.id', '=', 'ventas.cliente_id')
            ->Leftjoin('autorizaciones', 'autorizaciones.id', '=', 'ventas.autorizacion_id')
            ->where('ventas.id', '=', $id_venta)

            ->first();

        return $venta;
    }



    public function sales_for_id_personal($id_venta)
    {

        $venta = Venta::selectRaw(" ventas.fecha_venta , ventas.hora_venta , clientes.nombre , ventas.sucursal_id as sucursal,  sucursals.nombre as sucursal, ventas.total_venta ")
            ->Leftjoin('clientes', 'clientes.id', '=', 'ventas.cliente_id')
            ->join('sucursals', 'sucursals.id', '=', 'ventas.sucursal_id')
            ->where('ventas.id', '=', $id_venta)
            ->first();

        return $venta;
    }
}
