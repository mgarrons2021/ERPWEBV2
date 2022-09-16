@extends('layouts.app', ['activePage' => 'sucursales', 'titlePage' => 'Sucursales'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Vista detallada de la sucursal: {{ $sucursal->nombre }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <table class="table table-bordered table-striped ">
                        <tbody>
                            
                            <tr>
                                <th>Nombre</th>
                                <td>{{ $sucursal->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Direccion</th>
                                <td><span class="">{{ $sucursal->direccion }}</span></td>
                            </tr>
                            <tr>
                                <th>Correo</th>
                                <td>{!! $sucursal->correo !!}</td>
                            </tr>
                            <tr>
                                <th>Numero Fiscal</th>
                                <td>{{ $sucursal->nro_fiscal }}
                                </td>
                            </tr>
                            
                            <tr>
                                <th>Estado sucursal</th>
                                @if($sucursal->estado==1)
                                <td><div class="badge badge-success">Activo</div></td>
                                @endif
                                @if($sucursal->estado==0)
                                <td><div class="badge badge-warning">Inactivo</div></td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                    <div class="button-container ">
                        <a href="{{ route('sucursales.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
                        <a href="{{ route('sucursales.edit', $sucursal->id) }}" class="btn btn-info btn-twitter"> Editar </a>
                    </div>
                </div>
                <div>
                   
                </div>
            </div>
        </div>
</section>




@endsection