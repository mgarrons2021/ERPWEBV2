<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>EMAILS</title>
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
    <h3 style="text-align:center ;margin:5px;">FACTURA</h3>
    <table class="styled-table" style="text-align: center;">
        <thead>
            <tr>
                <th>Codigo Servicio/Producto</th>
                <th>Cantidad</th>
                <th>Descripcion</th>
                <th>Unidad de Medida</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detalle_venta as $item)
            <tr class="active-row">
                <td>{{$item->plato_id}}</td>
                <td>{{$item->cantidad}}</td>
                <td>{{$item->plato}}</td>
                <td>{{$item->plato}}</td>
                <td>{{$item->costo}}</td>
                <td>{{$item->subtotal}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>