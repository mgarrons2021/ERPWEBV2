@extends('layouts.app', ['activePage' => 'proveedores', 'titlePage' => 'Proveedores'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Vista detallada del proveedor: {{ $proveedor->nombre }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <table class="table table-bordered table-striped ">
                        <tbody>
                            
                            <tr>
                                <th>Nombre Completo</th>
                                <td>{{ $proveedor->nombre }}</td>
                            </tr>
                            <tr>
                                <th>Celular</th>
                                <td><span class="badge badge-primary">{{ $proveedor->celular }}</span></td>
                            </tr>
                           
                            <tr>
                                <th>Direccion</th>
                                <td>{{ $proveedor->direccion }}
                                </td>
                            </tr>
                            <tr>
                                <th>Nro Nit</th>
                                <td><a href="#" target="_blank">{{ $proveedor->nit  }}</a></td>
                            </tr>
                            <tr>
                                <th>Estado Proveedor</th>
                                @if($proveedor->estado==1)
                                <td><div class="badge badge-success">Activo</div></td>
                                @endif
                                @if($proveedor->estado==0)
                                <td><div class="badge badge-danger">Inactivo</div></td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                    <div class="button-container ">
                        <a href="{{ route('proveedores.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
                        <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="btn btn-info btn-twitter"> Editar </a>
                    </div>
                </div>
                <div>
                   
                </div>
            </div>
        </div>
</section>




@endsection