@extends('layouts.app', ['activePage' => 'productos', 'titlePage' => 'productos'])

@section('content')

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Actualizar producto</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <br>
                        <form action="{{ route('productos.update',$producto->id) }}" method="POST" class="form-horizontal">
                            @csrf
                            @method('PUT')
                            <div class="row ">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="codigo">Codigo<span class="required">*</span></label>
                                        <input type="text" class="form-control  @error('codigo') is-invalid @enderror" name="codigo" value="{{$producto->codigo}}" readonly>
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
                                        <input type="text" class="form-control" name="nombre" value="{{$producto->nombre}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="estado">Estado<span class="required">*</span></label>
                                        <div class="selectric-hide-select">
                                            <select name="estado" class="form-control selectric">
                                                @if($producto->estado===1)
                                                <option value="1" selected>Activo</option>
                                                <option value="0">Inactivo</option>
                                                @endif
                                                @if($producto->estado===0)
                                                <option value="1">Activo</option>
                                                <option value="0" selected>Inactivo</option>
                                                @endif
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
                                                @if($categoria->id==$producto->categoria_id)
                                                <option value="{{$categoria->id}}" selected>{{$categoria->nombre}}</option>
                                                @else
                                                <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="unidad_medida_compra_id">Seleccione la Unidad de Medida de Compra</label>
                                        <div class="selectric-hide-select">
                                            <select name="unidad_medida_compra_id" class="form-control selectric">
                                                <option value="0">Seleccione ....</option>
                                                @foreach($unidades_medidas_compras as $unidad_medida_compra)
                                                @if($producto->unidad_medida_compra_id==$unidad_medida_compra->id)
                                                <option value="{{$unidad_medida_compra->id}}" selected>{{$unidad_medida_compra->nombre}}</option>
                                                @else
                                                <option value="{{$unidad_medida_compra->id}}">{{$unidad_medida_compra->nombre}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="unidad_medida_venta_id">Seleccione la Unidad de Medida de Venta</label>
                                        <div class="selectric-hide-select">
                                            <select name="unidad_medida_venta_id" class="form-control selectric">
                                                <option value="0">Seleccione ....</option>
                                                @foreach($unidades_medidas_compras as $unidad_medida_venta)
                                                @if($producto->unidad_medida_venta_id==$unidad_medida_venta->id)
                                                <option value="{{$unidad_medida_venta->id}}" selected>{{$unidad_medida_venta->nombre}}</option>
                                                @else
                                                <option value="{{$unidad_medida_venta->id}}">{{$unidad_medida_venta->nombre}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary" tabindex="7">Guardar</button>
                                <a href="{{route('productos.index')}}" class="btn btn-danger" tabindex="8">Cancelar</a>
                            </div>
                        </form>
                    </div>
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