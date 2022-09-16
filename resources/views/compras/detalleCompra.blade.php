@extends('layouts.app', ['activePage' => 'compras', 'titlePage' => 'Compras'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Compra Nro: {{ $compra->id }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">

                    <div class="card-header">
                        <h4>Datos de la Compra</h4>
                        <div class="col-xl-10 text-right">
                            <a href="{{ route('compras.download-pdf', $compra->id) }}" class="btn btn-danger btn-sm">Exportar a PDF</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive"></div>
                        <table class="table table-bordered table-md">
                            <tbody>
                                <tr>
                                    <th>Fecha compra:</th>
                                    <td>{{ $compra->fecha_compra }}</td>
                                </tr>
                                <tr>
                                    <th> Proveedor:</th>
                                    <td> <span class="badge badge-success"> {{ $compra->proveedor->nombre }} </span></td>
                                </tr>
                                <tr>
                                    <th> Usuario:</th>
                                    <td>{{$compra->user->name}}</td>
                                </tr>
                                <tr>
                                    <th> Sucursal:</th>
                                    <td>{{ $compra->sucursal->nombre  }}</td>
                                </tr>
                                <tr>
                                    <th> Tipo de Comprobante:</th>
                                    @if ($compra->tipo_comprobante=="S")
                                    <td> <span class="badge badge-info"> Sin Comprobante </span></td>
                                    @endif
                                    @if ($compra->tipo_comprobante=="R")
                                    <td>Recibo</td>
                                    @endif
                                    @if ($compra->tipo_comprobante=="F")
                                    <td>Factura</td>
                                    @endif
                                </tr>
                                @if ($compra->tipo_comprobante=="R")
                                <tr>
                                    <th>Nro de Recibo</th>
                                    <td>
                                        @if(isset($compra->comprobante_recibo->nro_recibo))
                                        {{$compra->comprobante_recibo->nro_recibo}}
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @if ($compra->tipo_comprobante=="F")
                                <tr>
                                    <th>Nro Factura</th>
                                    <td>
                                        @if(isset($compra->comprobante_factura->numero_factura))
                                        {{$compra->comprobante_factura->numero_factura}}}
                                        @endif
                                    </td>
                                </tr>
                                @endif


                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Detalles de la Compra</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <th style="text-align: center;"> Producto </th>
                            <th style="text-align: center;"> UM </th>
                            <th style="text-align: center;"> Precio </th>
                            <th style="text-align: center;"> Cantidad </th>
                            <th style="text-align: center;"> Subtotal </th>

                        </thead>
                        <tbody>
                            @foreach($detalle_compra as $detalle)
                            <tr>

                                <td style="text-align: center;">{{$detalle->producto->nombre}}</td>
                                @if(isset($detalle->producto->unidad_medida_compra->nombre))
                                <td style="text-align: center;">{{$detalle->producto->unidad_medida_compra->nombre}}</td>
                                @else
                                <td style="text-align: center;">Sin UM</td>
                                @endif
                                <td style="text-align: center;">{{$detalle->precio_compra}}</td>
                                <td style="text-align: center;"> {{$detalle->cantidad}}</td>
                                <td style="text-align: center;"> {{$detalle->subtotal}} Bs. </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td colspan="3" style="text-align: center;"> Total Compra</td>
                            <td colspan="1" style="text-align: center;"> {{$compra->total}} Bs. </td>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>


        <div class="button-container ">
            <a href="{{ route('compras.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
            <a href="" class="btn btn-info btn-twitter"> Editar </a>
        </div>

        <div>

        </div>
    </div>

</section>
@endsection