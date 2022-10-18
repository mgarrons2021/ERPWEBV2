<?php

namespace App\Services;

use App\Models\Autorizacion;
use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\TurnoIngreso;
use App\Models\User;
use App\Models\Venta;
use Carbon\Carbon;

class VentaService
{

    public function registrarVenta($ventaData)
    {
        /* return response()->json($ventaData['user_id']); */

        $fecha = Carbon::now()->toDateString();
        $hora_actual = Carbon::now()->toTimeString();
        $cantidad_transacciones = 1;
        $user = User::find($ventaData['user_id']);

        $venta = new Venta();
        $venta->fecha_venta = $ventaData['fechaEmision'];
        $venta->hora_venta = $ventaData['fechaEmision'];
        $venta->total_venta = $ventaData['total_venta'];
        $venta->total_descuento = $ventaData['total_descuento'];
        $venta->total_neto = $ventaData['total_neto'];
        $venta->tipo_pago = $ventaData['tipo_pago'];
        $venta->lugar = $ventaData['lugar'];
        if ($ventaData['lugar'] == "Delivery") {
            $venta->nombre_delivery = $ventaData['delivery'];
        }
        $venta->nro_transaccion = $cantidad_transacciones;
        $venta->estado = 1;

        $venta->estado_emision = "R";
        $venta->turnos_ingreso_id = $ventaData['turno_id'];
        $venta->user_id = $user->id;
        $venta->cliente_id = $ventaData['cliente_id'];
        $venta->sucursal_id = $user->sucursals[0]->id;
        $lastventa = Venta::where('sucursal_id', $user->sucursals[0]->id)->where('turnos_ingreso_id', $ventaData['turno_id'])->count();
        $cantidad_transacciones = intval($lastventa) + 1;

        $turno = TurnoIngreso::find($ventaData['turno_id']);

        $turno->nro_transacciones++;
        $venta->nro_transaccion = $turno->nro_transacciones;
        $venta->evento_significativo_id = $ventaData['evento_significativo_id'];
        $venta->leyenda_factura_id = $ventaData['leyenda_factura_id'];
        $venta->documento_identidad_id = $ventaData['documento_identidad_id'];


        $venta->cuf = $ventaData['cuf'];
        $venta->cufd_id = $ventaData['cufd_id'];
        $venta->estado_emision = 'P';
        $venta->created_at = $ventaData['fechaEmision'];
        $turno->save();

        $venta->numero_factura = $ventaData['numero_factura'];
        if ($ventaData['tipo_pago'] != 'Comida Personal') {
            $venta->qr = $ventaData['qr'];
        } else {
            $venta->numero_factura = 0;
            $venta->qr = '0';
        }

        return $venta->save() ? $venta : "";
    }

    public function registrarDetalleVenta($detalle, $venta_id)
    {
        $detalle_venta = new DetalleVenta();
        $detalle_venta->cantidad = $detalle["cantidad"];
        $detalle_venta->precio = $detalle["costo"];
        $detalle_venta->descuento = $detalle["descuento"];
        $detalle_venta->subtotal = $detalle["subtotal"];
        $detalle_venta->subtotal_neto = $detalle_venta["subtotal"] - $detalle["descuento"];
        $detalle_venta->plato_id = $detalle["plato_id"];
        $detalle_venta->venta_id = $venta_id;
        $detalle_venta->save();
    }
}
