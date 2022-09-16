@extends('layouts.app', ['activePage' => 'encargados', 'titlePage' => 'Encargados'])



@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Empleado Sucursal View</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card card-primary">
                            <br>
                            <form action="{{ route('encargados.store') }}" method="POST" class="form-horizontal">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre">Nombre<span class="required">*</span></label>
                                            <input type="text" class="form-control  @error('nombre') is-invalid @enderror" name="nombre">
                                            @error('nombre')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="codigo">Codigo<span class="required">*</span></label>
                                            <input type="number" class="form-control  @error('codigo') is-invalid @enderror" name="codigo">
                                            @error('codigo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="celular">Celular<span class="required">*</span></label>
                                            <input type="number" class="form-control  @error('celular') is-invalid @enderror" name="celular">
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
                                                    <option value="1">Activo</option>
                                                    <option value="0">Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sucursal_id">Asigne la Sucursal<span class="required">*</span></label>
                                            <div class="selectric-hide-select">
                                                <select name="sucursal_id" class="form-control selectric">
                                                    @foreach($sucursales as $sucursal)
                                                    <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
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
    </div>

</section>
@endsection