@extends('layouts.app', ['activePage' => 'compras', 'titlePage' => 'Compras'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Pago Nro: {{ $pago->id }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                
                    <div class="card-header">
                        <h4>Pago Nro {{$pago->id}}</h4>
                        <div class="col-xl-10 text-right">
                            <a href="{{ route('pagos.download-pdf', $pago->id) }}" class="btn btn-danger btn-sm">Exportar a PDF</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tbody>
                                    <tr>
                                        <th>Fecha de Pago: </th>
                                        <td> {{ $pago->fecha }} </td>
                                    </tr>
                                    <tr>
                                        <th>Banco:</th>
                                        <td> <span class="badge badge-warning"> {{ $pago->banco }} </span></td>
                                    </tr>
                                    <tr>
                                        <th> Nro Cuenta:</th>
                                        <td>{{ $pago->nro_cuenta }}</td>
                                    </tr>
                                    <tr>
                                        <th> Tipo Pago:</th>
                                        <td>{{$pago->tipo_pago}}</td>
                                    </tr>
                                    <tr>
                                        <th> Nro Comprobante:</th>
                                        <td>{{ $pago->nro_comprobante }}</td>
                                    </tr>
                                    <tr>
                                        <th> Nro Cheque:</th>
                                        <td>{{ $pago->nro_cheque  }}</td>
                                    </tr>
                                    <tr>
                                        <th> Total:</th>
                                        <td>{{ $pago->total  }} Bs</td>
                                    </tr>
                                    <tr>
                                        <th> Usuario :</th>
                                        <td>{{ $pago->user->name  }} {{$pago->user->apellido}}</td>
                                    </tr>
                                    <tr>
                                        <th> Proveedor :</th>
                                        <td>{{ $pago->proveedor->nombre  }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles del Pago {{$pago->id}}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th style="text-align: center;"> Nota de Compra </th>
                                <th style="text-align: center;"> Fecha de Compra </th>
                                <th style="text-align: center;"> Nro de Factura </th>
                                <th style="text-align: center;"> Sucursal </th>
                                <th style="text-align: center;"> Monto Pagado</th>
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
                            <tfoot>
                                <td colspan="4" style="text-align: center;"> Total Pago</td>
                                <td colspan="1" style="text-align: center;"> {{$pago->total}} Bs. </td>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="button-container ">
                <a href="{{ route('pagos.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
            </div>

        </div>
    </div>
</section>
@endsection