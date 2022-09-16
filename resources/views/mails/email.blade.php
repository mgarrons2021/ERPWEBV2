<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMAILS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            font-family: sans-serif;
            min-width: 200px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }

        .styled-table thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: center;
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
        }

        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }

        .styled-table tbody tr.active-row {
            font-weight: bold;
            color: #009879;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center; margin:5px;">{{$details['title']}}</h1><br>

    <table class="styled-table" style="text-align: center;">
        <tbody>
            <tr>
                <th style="text-align: center;">Nombre del Producto:</th>
                <td>{{$details['body']['producto']}}</td>
            </tr>
            <tr>
                <th style="text-align: center;"> Precio Anterior:</th>
                <td> <span class="badge badge-success"> {{ $details['body']['precioanterior']}} bs. </span></td>
            </tr>
            <tr>
                <th style="text-align: center;"> Precio Nuevo a Cambiar:</th>
                <td>{{$details["body"]["precionuevo"]}}</td>
            </tr>
            <tr>
                <th style="text-align: center;"> Motivo del Cambio:</th>
                <td>{{$details['body']['motivo']}}</td>
            </tr>

        </tbody>
    </table>
    <h3 style="text-align:center ;margin:5px;">HISTORAL DE PRECIOS DEL PRODUCTO</h3>
    <table class="styled-table" style="text-align: center;">
        <thead>
            <tr>
                <th>Fecha de Cambio</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details["body"]["historial"] as $item)
            <tr class="active-row">
                @php
                $fecha_formateada = \Carbon\Carbon::parse($item->fecha_compra)->format('d-m-Y');
                @endphp
                <td>{{$fecha_formateada}}</td>
                <td>{{$item->precio_compra}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-right:auto;margin-left:auto;">
        <form method="GET" action="{{route('productos_proveedores.solicitudCambioPrecioSave')}}">
            <input type="hidden" id="" name="producto_proveedor_id" value="{{$details["body"]["producto_proveedor"]}}" />
            <input type="hidden" id="" name="precio_nuevo" value="{{$details["body"]["precionuevo"]}}" />
            <input type="hidden" id="" name="solicitud_id" value="{{$details["body"]["solicitud_id"]}}" />
            <input type="hidden" id="" name="nombre" value="{{$details["body"]["producto"]}}" />
            <input type="hidden" id="" name="precio_anterior" value="{{$details["body"]["precioanterior"]}}" />
            <button type="submit" style="background-color: blue;padding:10px;color:white; text-align:center;border:0px;">ACEPTAR EL CAMBIO DE PRECIO</button>
        </form>
    </div>
</body>

</html>
<script>

</script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>