@extends('layouts.app', ['activePage' => 'categoria_plato', 'titlePage' => 'Categoria Plato'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nueva Categoria Plato</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card card-primary">
                    <div class="card-body">
                        <br>
                        <form action="{{ route('categorias_platos.store') }}" method="POST" class="form-horizontal">
                            @csrf

                            <div class="row ">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre<span class="required">*</span></label>
                                        <input type="text" class="form-control  @error('nombre') is-invalid @enderror" name="nombre" placeholder="Nombre Categoria..">
                                        @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                               

                              
                               
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="estado">Estado<span class="required">*</span></label>
                                        <div class="selectric-hide-select">
                                            <select name="estado" class="form-control selectric">
                                                <option value="1">Activo</option>
                                                <option value="0">Inactivo</option>
                                            </select>
                                        </div>
                                
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-danger" href="{{route('categorias_platos.index')}}">Volver</a>
                            </div>
                    </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
    </div>

</section>
@endsection