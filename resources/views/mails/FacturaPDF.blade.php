<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> FACTURA</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray
        }

        h3,
        h5 {
            text-align: center;
            margin: 2px;
        }

        .bordes {
            border: 1px solid black;
            border-spacing: 0;
            border-collapse: collapse;
        }

        .box {
            border: 5px solid darkblue;
            height: 30px;
            width: 10px;
        }

        .fernandin {
            white-space: initial;
        }

        table {
            table-layout: fixed;
        }

        td {
            word-wrap: break-word
        }
    </style>
</head>

<body>
    <table width="100%">
        <tr style="text-align: left;width:100%">
            <td style="width: 70%;text-align:left;" rowspan="4">
                <p style="text-align: center;">
                <pre>
                <strong>DONESCO S.R.L
                {{$sucursal['nombre']}}</strong>
                {{ $sucursal['direccion'] }}
                Teléfono: 78555410
                Santa Cruz
                </pre>
                </p>
            </td>
            <td style="width:10%;vertical-align:text-top;">
                NIT
            </td>
            <td style="width:20%;vertical-align:text-top;">166172023 </td>
        </tr>
        <tr style="text-align: left;" width="100%">
            <td style="max-width:400px;min-width:300px;vertical-align:text-top;">
                FACTURA N*
            </td>
            <td style="width:20%;vertical-align:text-top;"> {{ $venta['numero_factura'] }} </td>
        </tr>
        <tr style="text-align: left;">
            <td style="width:10%;vertical-align:text-top;">
                CUF
            </td>
            <td style="max-width:400px;min-width:300px;vertical-align:text-top;">
                {{ $venta['cuf'] }}
            </td>
        </tr>
        <tr style="text-align: left;" width="100%">
            <td style="width:10%;vertical-align:text-top;">
                ACTIVIDAD
            </td>
            <td style="width:20%;vertical-align:text-top;">RESTAURANTE</td>
        </tr>
    </table>

    <h3>FACTURA</h3>
    <h5>(Con derecho a credito fiscal)</h5>

    <table width="100%;" style="text-align:left;">
        <tr>
            <td><strong>Fecha:</strong> </td>
            <td> {{ $fecha }} {{ $hora }} </td>
            <td style="text-align: right;"><strong>NIT/CI/CEX:</strong></td>
            <td> {{ $clienteNit }} </td>

            <td style="text-align: right;"><strong>Cod. Cliente:</strong></td>
            <td> {{ $ClienteId }} </td>
        </tr>
        <tr>
            <td><strong>Nombre/Razon Social:</strong></td>
            <td>{{ $clienteNombre}} </td>
        </tr>
    </table>

    <br />

    <table width="100%">
        <thead style="background-color: lightgray;">
            <tr class="">
                <th class="">
                    <p>CODIGO <BR>PRODUCTO /<BR> SERVICIO</p>
                </th>
                <th class="">CANTIDAD</th>
                <th class="">UNIDAD DE MEDIDA</th>
                <th class="">DESCRIPCION</th>
                <th class="">
                    <P>PRECIO<BR> UNITARIO</P>
                </th>
                <th class="">DESCUENTO</th>
                <th class="">SUBTOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detalle_venta as $item)
            <tr class="active-row">
                <td style="text-align: center;">{{$item['plato_id']}}</td>
                <td style="text-align: center;">{{ number_format($item['cantidad'],2) }}</td>
                <td style="text-align: center;"> UNIDAD (SERVICIOS)</td><
                <td style="text-align: center;">{{$item->plato->nombre}}</td>
                <td style="text-align: right;">{{number_format($item->precio,2)}}</td>
                <td style="text-align: right;">{{number_format($item->descuento,2)}}</td>
                <td style="text-align: right;">{{number_format($item['subtotal'],2)}}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3"></td>
                <td colspan="2" style="text-align: right;">SUBTOTAL Bs.</td>
                <td style="text-align: right;"> {{ $venta['total_venta'] }} </td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2" style="text-align: right;">DESCUENTO Bs.</td>
                <td style="text-align: right;"> {{ $venta['total_descuento'] }} </td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2" style="text-align: right;">TOTAL Bs.</td>
                <td style="text-align: right;"> {{ number_format($venta['total_venta'] - $venta['total_descuento'],2) }} </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: left;"> <b> Son: {{ $total }} 00/100 Bolivianos <b></td>
                <td colspan="2" style="text-align: right;">MONTO GIFT CARD Bs.</td>
                <td style="text-align: right;"> 0 </td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2" style="text-align: right;"><b>MONTO A PAGAR Bs. </b> </td>
                <td style="text-align: right;"><b> {{ number_format($venta['total_venta'] - $venta['total_descuento'],2) }} </b> </td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2" style="text-align: right;"><b>IMPORTE BASE CREDITO FISCAL Bs. </b> </td>
                <td style="text-align: right;"> <b>{{ number_format($venta['total_venta'] - $venta['total_descuento'],2) }} </b> </td>
            </tr>
        </tbody>
    </table>

    <div style="width:100%;display:inline-block;">
        <small style="float: left; text-align:center;width:80%;font-size:9px;">
            <pre>
            ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS, EL USO ILÍCITO SERÁ SANCIONADO PENALMENTE DE ACUERDO A LEY <br>
            Ley Nro 453: Tienes derecho a recibir información sobre las características y contenidos de los servicios que utilices. <br>
            “Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido en una modalidad de facturación en línea” <br>
            </pre>
        </small>
        <img style="float:right;width:15%;align-items:center;" src="data:image/png;base64, {!! $qrcode !!}">
    </div>
</body>

</html>