@extends('layouts.app', ['activePage' => 'descuentos', 'titlePage' => 'Bonos'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Detalle del descuento </h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <table class="table table-bordered table-striped ">
                        <tbody>
                            <tr>
                                <th>Nombre del Empleado</th>
                                <td >{{ $descuento->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Monto Descontado</th>
                                <td ><span class="badge badge-primary">{{ $descuento->monto }}Bs</span></td>
                            </tr>
                            <tr>
                                <th>Fecha asignado</th>
                                <td>{!! $descuento->fecha!!}</td>
                            </tr>
                            <tr>
                                <th>Motivo del descuento</th>
                                <td>{{ $descuento->motivo }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="button-container ">
                        <a href="{{ route('descuentos.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
                     
                    </div>
                </div>
                <div>

                </div>
            </div>
        </div>
</section>




@endsection