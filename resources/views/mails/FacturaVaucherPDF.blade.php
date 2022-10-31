<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <style>
        .ticket {
            width: 270px;
            max-width: 270px;
        }

        * {
            max-width: 270px;
            font-size: 12px;
            font-family: Helvetica;
            padding-right: -10px;
        }

        .centrado {
            text-align: center;
        }

        p {
            line-height: 80%;
        }
    </style>
</head>

<body>
    <div class="ticket centrado">
        <div style="text-align: start;">
            <p>FACTURA</p>
            <p>CON DERECHO A CREDITO FISCAL</p>
            <p>DONESCO SRL</p>
            <p>{{$sucursal['nombre']}}</p>
            <p>Nro Punto de Venta 0</p>
            <p>{{$sucursal['direccion']}}</p>
            <p>Tel. 78555410</p>
            <p>Santa Cruz de la Sierra</p>
        </div>
        <p style="text-align: start;">-----------------------------------------------------------------------------------------</p>
        <div style="text-align: start;">
            <p>NIT</p>
            <p>166172023</p>
            <p>FACTURA N*</p>
            <p>{{$venta['numero_factura']}}</p>
            <p>CODIGO AUTORIZACION</p>
            @php
            $cuf_part1 = " ".substr($venta['cuf'],0,39);
            $cuf_part2 = " ".substr($venta['cuf'],40,56);
            @endphp
            <p style="padding-left: 45px;"> {{$cuf_part1}} </p>
            <p style="padding-left: 25px;"> {{$cuf_part2}} </p>
        </div>
        <p style="text-align: start;">-----------------------------------------------------------------------------------------</p>
        <div style="text-align: start;">
            <p>NOMBRE/RAZON SOCIAL: {{$clienteNombre}}</p>
            @if(is_null($ClienteComplemento))
            <p>NIT/CI/CEX: {{$clienteNit}}</p>
            @else
            <p>NIT/CI/CEX: {{$clienteNit}} - {{$ClienteComplemento}} </p>
            @endif
            <p>COD. CLIENTE: {{$ClienteId}}</p>
            @php
            $fecha_emision = date_create($fecha);
            @endphp
            <p>FECHA EMISION: {{ date_format($fecha_emision,"d/m/Y")}} {{$hora}}</p>
        </div>
        <p style="text-align: start;">-----------------------------------------------------------------------------------------</p>
        <p>DETALLE</p>
        <div style="text-align: start;">
            @foreach($detalle_venta as $item)
            <p>{{ number_format($item['cantidad'],2)}} x {{number_format($item['precio'],2)}} - {{ number_format($item['descuento'],2)}} &nbsp; &nbsp; &nbsp; {{number_format($item['subtotal'],2)}}</p>
            @endforeach
        </div>
        <p style="text-align: start;">-----------------------------------------------------------------------------------------</p>
        <div style="text-align: start;">
            <p>SUBTOTAL Bs. &nbsp; {{ number_format($venta['total_neto'],2)}}</p>
            <p>DESCUENTO Bs. &nbsp; 0</p>
            <p>TOTAL Bs. &nbsp; {{number_format($venta['total_neto'],2)}}</p>
            <p>MONTO GIFT CARD Bs. &nbsp; 0</p>
            <p>MONTO A PAGAR Bs. &nbsp; {{ number_format($venta['total_neto'],2) }}</p>
            <p>IMPORTE CREDITO FISCAL Bs. &nbsp; {{ number_format($venta['total_neto'],2) }}</p>
            <p> Son: {{ $total }} 00/100 Bolivianos </p>
        </div>
        <p style="text-align: start;">-----------------------------------------------------------------------------------------</p>
        <div style="text-align: start;">
            <p>
                ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS, EL USO ILÍCITO SERÁ SANCIONADO PENALMENTE DE ACUERDO A LEY <br>
                {{$venta->leyenda_factura->descripcion_leyenda}}<br>
                @if($venta['evento_significativo_id'] === null)
                “Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido en una modalidad de facturación en línea”
                @else
                “Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido fuera de linea”
                @endif

                <br>
            </p>
            <img src="data:image/png;base64, {!! $qrcode !!}">
        </div>
    </div>
</body>

</html>