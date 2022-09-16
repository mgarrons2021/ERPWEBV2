@extends('layouts.app', ['activePage' => 'cronologias', 'titlePage' => 'Cronologias'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Vista detallada de la cronologia</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <table class="table table-bordered table-striped ">
                        <tbody>
                            <tr>
                                <th>Nombre del Funcionario</th>
                                <td >{{ $cronologia->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Fecha</th>
                                <td><span class="badge badge-primary">{!! $cronologia->fecha_cronologia!!} </span></td>
                            </tr>
                            <tr>
                                <th>Descripcion</th>
                                <td>{{ $cronologia->descripcion }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="button-container ">
                        <a href="{{ route('cronologias.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
                        <a href="{{ route('cronologias.edit', $cronologia->id) }}" class="btn btn-info btn-twitter"> Editar </a>
                    </div>
                </div>
                <div>

                </div>
            </div>
        </div>
</section>




@endsection