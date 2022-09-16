@extends('layouts.app', ['activePage' => 'cajas_chicas', 'titlePage' => 'Cajas_Chicas'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Registro Nro: {{ $caja_chica->id }} de Caja Chica</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">

                    <div class="card-header">
                        <h4> Datos de la Caja Chica &nbsp;- &nbsp;{{$fecha_actual}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive"></div>
                        <table class="table table-bordered table-md">
                            <tbody>
                                <tr>
                                    <th> Funcionario Encargado:</th>
                                    <td> <span class="badge badge-success"> {{ $caja_chica->user->name }} </span></td>
                                </tr>
                                <tr>
                                    <th> Sucursal:</th>
                                    <td> {{ $caja_chica->sucursal->nombre }}</td>
                                </tr>
                                <tr>
                                    <th>Fecha de Registro:</th>
                                    <td>{{ $caja_chica->fecha }}</td>
                                </tr>
                                <tr>
                                    <th> Total Egreso:</th>
                                    <td>{{ $caja_chica->total_egreso }} BS</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles de Caja Chica &nbsp;- &nbsp;  {{$fecha_actual}} </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th style="text-align: center;"> Tipo de Comprobante </th>
                                <th style="text-align: center;"> Nro de Comprobante </th>
                                <th style="text-align: center;"> Tipo de Egreso </th>
                                <th style="text-align: center;"> Glosa </th>
                                <th style="text-align: center;"> Egreso </th>

                            </thead>
                            <tbody>
                                @foreach($caja_chica->detalles_caja_chica as $detalle)
                                <tr>

                                    @if($detalle->tipo_comprobante =="R")
                                    <td style="text-align: center;">Recibo</td>
                                    @else
                                    <td style="text-align: center;">Factura</td>
                                    @endif
                                    <td style="text-align: center;">{{$detalle->nro_comprobante}}</td>
                                    <td style="text-align: center;">{{$detalle->categoria_caja_chica->nombre}}</td>
                                    <td style="text-align: center;">{{$detalle->glosa}}</td>
                                    <td style="text-align: center;">{{$detalle->egreso}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <td colspan="4" style="text-align: center;"> Total Caja Chica</td>
                                <td colspan="1" style="text-align: center;"> {{$caja_chica->total_egreso}} Bs. </td>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <div class="button-container ">
            <a href="{{ route('cajas_chicas.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
            <a href="" class="btn btn-info btn-twitter"> Editar </a>
        </div>

        <div>

        </div>
    </div>

</section>
@endsection