@extends('layouts.app', ['activePage' => 'productos', 'titlePage' => 'Productos'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nuevo Producto</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <br>
                        <form action="{{ route('productos.store') }}" method="POST" class="form-horizontal">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="codigo">Codigo<span class="required">*</span></label>
                                        <input type="text" class="form-control  @error('codigo') is-invalid @enderror" name="codigo" placeholder="Codigo del Producto...">
                                        @error('codigo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre<span class="required">*</span></label>
                                        <input type="text" class="form-control  @error('nombre') is-invalid @enderror" name="nombre" placeholder="Nombre del Producto...">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="categoria_id">Seleccione la Categoria<span class="required">*</span></label>
                                        <div class="selectric-hide-select">
                                            <select name="categoria_id" class="form-control selectric">
                                                @foreach($categorias as $categoria)
                                                <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="unidad_medida_compra_id">Unidad de medida de Compra <span class="required">*</span></label>
                                        <div class="selectric-hide-select">
                                            <select name="unidad_medida_compra_id" class="form-control selectric">
                                                @foreach($unidades as $unidad)
                                                <option value="{{$unidad->id}}">{{$unidad->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="unidad_medida_venta_id">Unidad de medida de Venta <span class="required">*</span></label>
                                        <div class="selectric-hide-select">
                                            <select name="unidad_medida_venta_id" class="form-control selectric">
                                                @foreach($unidades as $unidad)
                                                <option value="{{$unidad->id}}">{{$unidad->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-danger" href="{{route('productos.index')}}">Volver</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
