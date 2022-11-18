<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <style>
        * {
            margin: 0;
            font-family: "Arial Black";
            color: #1f1f1f;
            font-size: 13px;
            width: 300px;
            max-width: 300px;

        }

        .container {
            background: #fff;
            padding: 20px 10px;
        }

        .cabecera {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="receipt">
            <div class="cabecera">
                FACTURA<br>
                CON DERECHO A CREDITO FISCAL<br>
                DONESCO SRL<br>
                {{$sucursal['nombre']}}<br>
                Nro Punto de Venta 0<br>
                {{$sucursal['direccion']}}<br>
                Tel. 78555410<br>
                Santa Cruz de la Sierra<br>
            </div>
            <div class="break">
                ----------------------------------------------------------------------------------
            </div>
            <div class="cabecera">
                NIT<br>
                166172023<br>
                FACTURA N*<br>
                {{$venta['numero_factura']}}<br>
                CODIGO AUTORIZACION<br>
                @php
                $cuf_part1 = " ".substr($venta['cuf'],0,39);
                $cuf_part2 = " ".substr($venta['cuf'],40,56);
                @endphp
                <p style="padding-left: 45px;"> {{$cuf_part1}} </p>
                <p style="padding-left: 25px;"> {{$cuf_part2}} </p>
            </div>
            <div class="break">
                ----------------------------------------------------------------------------------
            </div>
            <div class="">
                <div class="">
                    <div style="float: left; width: 75%;  ">NOMBRE/RAZON SOCIAL:</div>
                    <div style="margin-left: 35%;  ">{{$clienteNombre}}</div>
                </div>
                <div style="clear: left;"></div>
                @if(is_null($ClienteComplemento))
                <div class="">
                    <div style="clear: left; width: 75%;  ">NIT/CI/CEX:</div>
                    <div style="margin-left: 35%;   ">{{$clienteNit}}</div>
                </div>
                @else
                <div class="">
                    <div style="float: left; width: 75%;  ">NIT/CI/CEX:</div>
                    <div style="margin-left: 35%;">{{$clienteNit}} - {{$ClienteComplemento}}</div>
                </div>
                @endif
                <div style="clear: left;"></div>
                <div class="">
                    <div style=" float: left; width: 75%; ">COD. CLIENTE:</div>
                    <div style=" margin-left: 35%;">{{$ClienteId}}</div>
                </div>
                @php
                $fecha_emision = date_create($fecha);
                @endphp
                <div style="clear: left;"></div>
                <div class="">
                    <div style="float: left; width: 75%;  ">FECHA EMISION:</div>
                    <div style="margin-left: 35%; ">{{ date_format($fecha_emision,"d/m/Y")}} {{$hora}}</div>
                </div>
            </div>
            <div style="clear: left;"></div>
            <div class="break">
                ----------------------------------------------------------------------------------
            </div>
            <p style="text-align: center;">DETALLE</p>
            <div>
                @foreach($detalle_venta as $item)
                <div>
                    {{$item['plato']['id']}} - {{$item['plato']['nombre']}}
                </div>
                <div>
                    Unidad de Medida: Unidad (Servicios)
                </div>
                <div style="float: left; width: 85%;  ">
                    {{ number_format($item['cantidad'],2)}} x {{number_format($item['precio'],2)}} - {{ number_format($item['descuento'],2)}}
                </div>
                <div style="margin-left: 85%;  ">
                    {{number_format($item['subtotal'],2)}}
                </div>
                <div style="clear: left;"></div>
                @endforeach
            </div>
            <div class="break">
                ----------------------------------------------------------------------------------
            </div>
            <div style="text-align: center;">
                <div class="">
                    <div style="float: left;margin-left: 5%; width: 85%; ">SUBTOTAL Bs.</div>
                    <div style="margin-left: 5%; ">{{ number_format($venta['total_neto'],2)}}</div>
                </div>
                <div style="clear: left;"></div>
                <div>
                    <div style="float: left;margin-left: 5%; width: 85%; ">DESCUENTO Bs. </div>
                    <div style="margin-left: 5%; ">0.00</div>
                </div>
                <div style="clear: left;"></div>
                <div>
                    <div style="float: left;margin-left: 5%; width: 85%; ">TOTAL Bs. </div>
                    <div style="margin-left: 5%; ">{{number_format($venta['total_neto'],2)}}</div>
                </div>
                <div style="clear: left;"></div>
                <div>
                    <div style="float: left;margin-left: 5%; width: 85%; ">MONTO GIFT CARD Bs.</div>
                    <div style="margin-left: 5%; ">0.00</div>
                </div>
                <div style="clear: left;"></div>
                <div>
                    <div style="float: left;margin-left: 5%; width: 85%; ">MONTO A PAGAR Bs. </div>
                    <div style="margin-left: 5%; ">{{ number_format($venta['total_neto'],2) }}</div>
                </div>
                <div style="clear: left;"></div>
                <div>
                    <div style="float: left;margin-left: 5%; width: 85%; ">IMPORTE CREDITO FISCAL Bs.</div>
                    <div style="margin-left: 5%; ">{{ number_format($venta['total_neto'],2) }}</div>
                </div>
                <div style="clear: left;"></div>
                <p> Son: {{ $total }} 00/100 Bolivianos </p>
            </div>
            <div class="break">
                ----------------------------------------------------------------------------------
            </div>
            <div style="text-align: center;">
                <p>
                    ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS, EL USO ILÍCITO SERÁ SANCIONADO PENALMENTE DE ACUERDO A LEY <br><br>
                    {{$venta->leyenda_factura->descripcion_leyenda}}<br><br>
                    @if($venta['evento_significativo_id'] === null)
                    “Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido en una modalidad de facturación en línea”
                    @else
                    “Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido fuera de linea, verifique su envio con su proveedor o en la pagina web www.impuestos.gob.bo”
                    @endif
                    <br><br>
                </p>
                <img src="data:image/png;base64, {!! $qrcode !!}" style="width:150px;height:auto;margin-top:5px">
            </div>
        </div>

    </div>
</body>

</html>