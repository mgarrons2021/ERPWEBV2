@extends('layouts.app', ['activePage' => 'observaciones', 'titlePage' => 'Observaciones'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Vista detallada de la Observacion</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <table class="table table-bordered table-striped ">
                        <tbody>
                             <tr>
                                <th>Fecha</th>
                                <td>{!! $observacion->fecha_observacion!!} </td>
                            </tr>
                            <tr>
                                <th>Nombre del Encargado </th>
                                <td >{{ $observacion->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Nombre del Personal Observado </th>
                                <td >{{ $observacion->detalleObservacion->user->name }}</td>
                            </tr>
                           
                            <tr>
                                <th>Respaldo</th>
                                <td>
                                    <p>&nbsp</p>
                                    <img id="" src="{{url($observacion->foto) }}" alt="" style="width:85%;max-width:150px" class="img-responsive center-block">
                                    <p>&nbsp</p>
                                </td>
                            </tr>      
                            <tr>
                                <th>Descripcion</th>
                                <td><span class="badge badge-primary">{{ $observacion->descripcion }}</span></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="button-container ">
                        <a href="{{ route('observaciones.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
                        <a href="{{ route('observaciones.edit', $observacion->id) }}" class="btn btn-info btn-twitter"> Editar </a>
                    </div>
                </div>
                <div>

                </div>
            </div>
        </div>
</section>




@endsection