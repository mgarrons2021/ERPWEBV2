<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Vaucher de Pedidos</title>
    <style>

        .ticket {
            width: 265px;
            max-width: 265px;
        }

        * {
            /* width: 235px; */
            max-width: 265px;

            margin: 0;
            padding: 0;
            font-size: 12px;
            font-family: 'DejaVu Sans', serif;
        }

        td.cantidad {
            font-size: 11px;
        }

        td.producto {
            text-align: center;
        }

        body {
            text-align: center;
        }

        td,
        th,
        tr,
        table {
            border-top: 0.5px solid black;
            border-collapse: collapse;
        }

        td.unidad_medida {
            text-align: center;
            font-size: 12px;
            padding: 2px;
        }

        td.cantidad {
            font-size:15px;
            text-align: center;
        }

        td.producto {
            font-size: 15px;
            text-align: center;
        }

        th {
            font-size: 15px;
            padding: 5px;
            text-align: center;
        }

        h1 {

            font-size: 17px;
        }

        h2 {
            font-size: 13px;
        }

        .centrado {
            text-align: center;
            align-content: center;
        }
    </style>
</head>

<body>
    <div class="ticket centrado">

        @php
        $hora = new DateTime($pedido->created_at);
        $hora_solicitado = $hora->format('H:i:s')
        @endphp

        <h1>LISTADO DE PEDIDOS</h1>
        <h2>Fecha de Pedido: {{$pedido->fecha_actual}}</h2>
        <h2>Hora de Pedido: {{$hora_solicitado}}</h2>
        <h2>Cod {{$pedido->id}}-{{$pedido->sucursal_principal->id}}</h2>
        <h1>{{$pedido->sucursal_principal->nombre}}</h1>


        <table>
            <thead>
                <tr class="centrado">
                    <th class="producto">Insumo</th>
                    <th class="cantidad">Cantidad</th>
                    <th class="unidad_medida">U.M.</th>
                </tr>
            </thead>
            <tbody  class="centrado">
                @foreach ($pedido->detalle_pedidos as $detalle)
                <tr>
                    <td class="producto">{{$detalle->producto->nombre}}</td>
                    <td class="cantidad">{{$detalle->cantidad_solicitada}}</td>
                    @if(isset($detalle->producto->unidad_medida_venta->nombre))
                    <td class="unidad_medida">{{$detalle->producto->unidad_medida_venta->nombre}}</td>
                    @else
                    <td class="unidad_medida">Sin UM</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>



    </div>
</body>

</html>