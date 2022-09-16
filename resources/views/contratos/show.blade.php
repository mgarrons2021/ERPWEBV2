@extends('layouts.app', ['activePage' => 'contratos', 'titlePage' => 'Contratos'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Vista detallada del contrato</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <table class="table table-bordered table-striped ">
                        <tbody>
                            <tr>
                                <th>Tipo de Contrato</th>
                                <td >{{ $contrato->tipo_contrato }}</td>
                            </tr>
                            <tr>
                                <th>Sueldo</th>
                                <td><span class="badge badge-primary">{!! $contrato->sueldo!!} Bs</span></td>
                            </tr>
                            <tr>
                                <th>Duracion del Contrato</th>
                                <td>{{ $contrato->duracion_contrato }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="button-container ">
                        <a href="{{ route('contratos.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
                        <a href="{{ route('contratos.edit', $contrato->id) }}" class="btn btn-info btn-twitter"> Editar </a>
                    </div>
                </div>
                <div>

                </div>
            </div>
        </div>
</section>




@endsection