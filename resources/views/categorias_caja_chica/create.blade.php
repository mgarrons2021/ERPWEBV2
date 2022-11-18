@extends('layouts.app', ['activePage' => 'categorias_caja_chica', 'titlePage' => 'Categorias_Caja_Chica'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nueva Categoria de Caja de Chica</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card card-primary">
                            <br>
                            <form action="{{ route('categorias_caja_chica.store') }}" method="POST" class="form-horizontal">
                                @csrf
                                <div class="row ">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre">Nombre <span class="required">*</span></label>
                                            <input type="text" class="form-control  @error('nombre') is-invalid @enderror" name="nombre" placeholder="Nombre de la Categoria...">
                                            <label for="nombre">Categoria de Gastos <span class="required">*</span></label>
                                            <div class="selectric-hide-select">
                                            <select name="sub_categoria_id" class="form-control selectric" placeholder="Seleccione Sub Categoria">                            
                                                <option> Seleeciones Categoria </option>
                                                @foreach($subCategorias as $subcategoria)
                                                <option value="{{$subcategoria->id}}">{{$subcategoria->sub_categoria}}</option>
                                                @endforeach
                                            </select>
                                            @error('nombre')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                    <a class="btn btn-danger" href="{{route('categorias_caja_chica.index')}}">Volver</a>
                                </div>
                                <br>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection