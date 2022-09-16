<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Comprobante de Pago</title>
    <style>
        @import url('fonts/BrixSansRegular.css');
        @import url('fonts/BrixSansBlack.css');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        p,
        label,
        span,
        table {
            font-family: 'BrixSansRegular';
            font-size: 10pt;
        }

        .h2 {
            font-family: 'BrixSansBlack';
            font-size: 16pt;
        }

        .h3 {
            font-family: 'BrixSansBlack';
            font-size: 14pt;
            display: block;
            background: #0a4661;
            color: #FFF;
            text-align: center;
            padding: 3px;
            margin-bottom: 5px;
        }

        #page_pdf {
            width: 95%;
            margin: 15px auto 10px auto;
        }

        #factura_head,
        #factura_cliente,
        #factura_detalle {
            width: 100%;
            margin-bottom: 10px;
        }

        #factura_cliente th {
            padding-left: 125px;
            text-align: left;

        }

        #factura_cliente td {
            padding-left: 15px;
            text-align: left;

        }

        .logo_factura {
            width: 25%;
        }

        .info_empresa {
            width: 50%;
            text-align: center;
        }

        .info_factura {
            width: 25%;
        }

        .info_cliente {
            width: 100%;
        }

        .datos_cliente {
            width: 100%;
        }

        .datos_cliente tr td {
            width: 50%;
        }

        .datos_cliente {
            padding: 10px 10px 0 10px;
        }

        .datos_cliente label {
            width: 75px;
            display: inline-block;
        }

        .datos_cliente p {
            display: inline-block;
        }

        .textright {
            text-align: right;
        }

        .textleft {
            text-align: left;
        }

        .textcenter {
            text-align: center;
        }

        .round {
            border-radius: 10px;
            border: 1px solid #0a4661;
            overflow: hidden;
            padding-bottom: 15px;
        }

        .round p {
            padding: 0 15px;
        }

        #factura_detalle {
            border-collapse: collapse;
        }

        #factura_detalle thead th {
            background: #058167;
            color: #FFF;
            padding: 5px;
        }

        #detalle_productos tr:nth-child(even) {
            background: #ededed;

        }

        #detalle_totales span {
            font-family: 'BrixSansBlack';
        }

        .nota {
            font-size: 8pt;
            text-align: center;

        }

        .label_gracias {
            font-family: verdana;
            font-weight: bold;
            font-style: italic;
            text-align: center;
            margin-top: 40px;
        }

        .pagada {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translateX(-50%) translateY(-50%);
        }

        .entregada {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translateX(-50%) translateY(-50%);
        }

        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            border-radius: 10px;
            border: 1px solid #0a4661;
            overflow: hidden;
            padding-bottom: 15px;
        }

        #customers td,
        #customers th {

            border: 0px solid #ddd;
            padding: 8px;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #0a4661;
            color: white;
        }
    </style>
</head>

<body>
    <div id="page_pdf">
        <table id="factura_head">
            <p><img class="" src="{{ asset('img/LogoDonesco.png') }}" width="150px" style="padding-bottom: 15px;"> </p>
            <h6>Av. 3er anillo externo y Av. Santos Dumont</h6>
            <h6>Santa Cruz-Bolivia</h6>
            <h6>Email: donesco@gmail.com</h6>
            <tr>
                <td class="info_empresa">
                    <div>
                        <h1>COMPROBANTE DE PAGO</h1>
                    </div>
                    @php
                    $fecha_pago_formateada= date('d-m-Y', strtotime($pago->fecha));
                    @endphp
                    <h4 style="text-align: center;">Fecha de Pago: {{$fecha_pago_formateada}}</h4>
                </td>
            </tr>
        </table>
        <table id="factura_cliente">
            <tbody>
                <tr>
                    <th>Banco:</th>
                    @if(isset($pago->banco))
                    <td>{{$pago->banco}}</td>
                    @else
                    <td> S/ Banco</td>
                    @endif
                </tr>
                <tr>
                    <th>Nro Cuenta:</th>
                    @if(isset($pago->nro_cuenta))
                    <td>{{$pago->nro_cuenta}}</td>
                    @else
                    <td> S/Nro Cuenta</td>
                    @endif
                </tr>
                <tr>
                    <th>Nro de Comprobante:</th>
                    @if(isset($pago->nro_comprobante))
                    <td>{{$pago->nro_comprobante}}</td>
                    @else
                    <td> S/Nro de Comprobante</td>
                    @endif
                </tr>
                <tr>
                    <th>Nro de Cheque:</th>
                    @if(isset($pago->nro_cheque))
                    <td>{{$pago->nro_cheque}}</td>
                    @else
                    <td> S/Nro de Cheque</td>
                    @endif
                </tr>
                <tr>
                    <th>Usuario:</th>
                    @if(isset($pago->user->name))
                    <td>{{$pago->user->name}} {{$pago->user->apellido}}</td>
                    @else
                    <td> S/ Nombre</td>
                    @endif
                </tr>
                <tr>
                    <th>Proveedor</th>
                    @if(isset($pago->proveedor->nombre))
                    <td>{{$pago->proveedor->nombre}}</td>
                    @else
                    <td> S/ Proveedor</td>
                    @endif
                </tr>
            </tbody>
        </table>

        <!-- Items -->
        <div class="row justify-content-center">
            <div class="col-md-auto">
                <table id="customers">
                    <thead>
                        <tr>
                            <th>Nota de Compra</th>
                            <th>Fecha de Compra</th>
                            <th>Nro de Factura</th>
                            <th>Sucursal</th>
                            <th>Monto Pagado</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pago->detallePagos as $detalle)
                        <tr>

                            <td style="text-align: center;">{{$detalle->compra->id}}</td>
                            <td style="text-align: center;">{{$detalle->compra->fecha_compra}}</td>
                            @if ($detalle->compra->tipo_comprobante=="R")
                            <td style="text-align: center;">{{$detalle->compra->comprobante_recibo->nro_recibo}}</td>
                            @elseif ($detalle->compra->tipo_comprobante=="F")
                            <td style="text-align: center;">{{$detalle->compra->comprobante_factura->numero_factura}}</td>
                            @else
                            <td style="text-align: center;">S/F</td>
                            @endif
                            <td style="text-align: center;"> {{$detalle->compra->sucursal->nombre}}</td>
                            <td style="text-align: center;"> {{$detalle->compra->total}} Bs. </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot id="detalle_totales">
                        <tr>
                            <td colspan="4" style="text-align: center;color:black">
                                <h4>Total Pagado</h4>
                            </td>
                            <td colspan="1" style="text-align: center;">
                                <h4>{{$pago->total}} Bs. </h4>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div>
            <p class="nota">Si usted tiene preguntas sobre este comprobante, <br>pongase en contacto con el proveedor</p>
        </div>
    </div>
</body>

</html>