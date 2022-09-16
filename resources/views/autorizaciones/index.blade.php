@extends('layouts.app', ['activePage' => 'formulario', 'titlePage' => 'Formulario'])

@section('content')
@section('css')
@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Autorizaciones </h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">                       
                    <a class="btn btn-outline-info" href="{{route('autorizacion.create')}}">Agregar Autorizacion</a><br><br>

                        <div class="table-responsive">

                            <table class="table table-striped " id="table">
                                <thead style="background-color: #6777ef;">                                    
                                        <th style="color: #fff;">Fecha Inicio</th>
                                        <th style="color: #fff;">Fecha Fin</th>
                                        <th style="color: #fff;">Autorizacion</th>
                                        <th style="color: #fff;">NIT</th>                               
                                        <th style="color: #fff;">Factura</th>
                                        <th style="color: #fff;">Llave</th>
                                        <th style="color: #fff;">Estado</th>
                                        <th style="color: #fff;">Sucursal</th>
                                    
                                </thead>                        
                                <tbody>
                                    @foreach ($autorizaciones as $autorizacion)
                                    <tr>  
                                        <td>{{ $autorizacion->fecha_inicial }}</td>
                                        <td>{{ $autorizacion->fecha_fin }}</td>
                                        <td>{{ $autorizacion->nro_autorizacion }}</td>
                                        <td>{{ $autorizacion->nit }}</td>
                                        <td>{{ $autorizacion->nro_factura }}</td>
                                        <td>{{ $autorizacion->llave }}</td>
                                        <td>{{ $autorizacion->estado==0?'ACTIVO':'INACTIVO' }}</td>
                                        <td>{{ $autorizacion->sucursal->nombre }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('scripts')