@extends('layouts.app', ['activePage' => 'productos', 'titlePage' => 'productos'])

@section('content')

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Actualizar Encargado</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card card-primary">
                            <br>
                            <form action="{{ route('encargados.update',$encargado->id) }}" method="POST" class="form-horizontal">
                                @csrf
                                @method('PUT')
                                <div class="row ">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre">Nombre<span class="required">*</span></label>
                                            <input type="text" class="form-control" name="nombre" value="{{$encargado->nombre}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="codigo">Codigo<span class="required">*</span></label>
                                            <input type="number" class="form-control" name="codigo" value="{{$encargado->codigo}}" required>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="celular">Celular<span class="required">*</span></label>
                                            <input type="number" class="form-control  @error('celular') is-invalid @enderror" name="celular" value="{{$encargado->celular}}">
                                            @error('celular')
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
                                                    @if($encargado->estado===1)
                                                    <option value="1" selected>Activo</option>
                                                    <option value="0">Inactivo</option>
                                                    @endif
                                                    @if($encargado->estado===0)
                                                    <option value="1">Activo</option>
                                                    <option value="0" selected>Inactivo</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="categoria_id">Seleccione la Sucursal<span class="required">*</span></label>
                                            <div class="selectric-hide-select">
                                                <select name="categoria_id" class="form-control selectric">
                                                    @foreach($sucursales as $sucursal)
                                                    @if($sucursal->id==$encargado->sucursal_id)
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
                                        <button type="submit" class="btn btn-primary" tabindex="7">Guardar</button>
                                        <a href="{{route('productos.index')}}" class="btn btn-danger" tabindex="8">Cancelar</a>
                                    </div>
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
    </div>

</section>
@endsection