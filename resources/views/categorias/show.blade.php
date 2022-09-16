@extends('layouts.app', ['activePage' => 'categorias', 'titlePage' => 'Categorias'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Vista detallada de la categoria: {{ $categoria->nombre }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <table class="table table-bordered table-striped ">
                        <tbody>
                            
                            <tr>
                                <th>Nombre</th>
                                <td>{{ $categoria->nombre }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="button-container ">
                        <a href="{{ route('categorias.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
                        <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-info btn-twitter"> Editar </a>
                    </div>
                </div>
                <div>
                   
                </div>
            </div>
        </div>
</section>




@endsection