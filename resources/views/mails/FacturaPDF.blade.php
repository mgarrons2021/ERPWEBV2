<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Aloha!</title>

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
        h3,h5{
            text-align: center;
            margin:2px;
        }
        .bordes{
            border:1px solid black;
            border-spacing: 0;
            border-collapse: collapse;
        }

    </style>

</head>

<body>

    <table width="100%">
        <tr width="100%" >
            <td style="width: 70%;text-align:center;" rowspan="4">
                <pre>
                <strong>PRUEBA
                CASA MATRIZ</strong>
                Calle Juan Pablo II #54
                Teléfono: 2457896
                La Paz
                </pre>        
            </td>
            <td  style="width:10%;">
               NIT
            </td>
            <td style="width: 20;" >635654654664</td>
        </tr>
        <tr style="text-align: left;" width="100%">
            <td  style="width:10%;">
               FACTURA N*
            </td>
            <td style="width: 20;" >635654654664</td>
        </tr>
        <tr style="text-align: left;" width="100%">
            <td  style="width:10%;">
               CUF
            </td>
            <td style="width: 20;" ><p>6356546546645435345345345435435435435435435345345345435435353<p></td>
        </tr>
        <tr style="text-align: left;" width="100%">
            <td  style="width:10%;">
               ACTIVIDAD
            </td>
            <td style="width: 20;" >RESTAURANTE</td>
        </tr>

    </table>


    <h3>FACTURA</h3>
    <h5>(Con derecho a credito fiscal)</h5>

    <table width="100%;" style="text-align:left;">
        <tr>
            <td><strong>Fecha:</strong> </td>
            <td> 2022 - 09 - 27 A.M. </td>
            <td><strong>NIT/CI/CEX:</strong></td>
            <td> 5654645645654</td>
        </tr>
        <tr>
            <td><strong>Nombre/Razon Social:</strong></td>
            <td>Patricio y Jhonatan </td>
        </tr>

    </table>

    <br />

    <table width="100%">
        <thead style="background-color: lightgray;">
            <tr class="">
                <th class=""><p>CODIGO <BR>PRODUCTO /<BR> SERVICIO</p></th>
                <th class="">CANTIDAD</th>
                <th class="">DESCRIPCION</th>
                <th class=""><P>PRECIO<BR> UNITARIO</P></th>
                <th class="">SUBTOTAL</th>
                <th class="">DESCUENTO</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detalle_venta as $item)
            <tr class="active-row">
                <td  >{{$item['plato_id']}}</td>
                <td  >{{$item['cantidad']}}</td>
                <td  >{{$item['plato']}}</td>
                <td   style="text-align: right;">{{$item['costo']}}</td>
                <td   style="text-align: right;">0</td>
                <td   style="text-align: right;">{{$item['subtotal']}}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3"></td>
                <td  colspan="2" style="text-align: right;">TOTAL BS.</td>
                <td style="text-align: right;"> 20</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td  colspan="2" style="text-align: right;">IMPORTE BASE CREDITO FISCAL</td>
                <td style="text-align: right;"> 20</td>
            </tr>
        </tbody>
    </table>
    <p><small>Son: veinticinco 00/100 Bolivianos</small></p>


</body>

</html>