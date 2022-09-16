@extends('layouts.app', ['activePage' => 'proveedores', 'titlePage' => 'Proveedores'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nuevo Proveedor</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card card-primary">
                    <div class="card-body">
                        <br>
                        <form action="{{ route('proveedores.store') }}" method="POST" class="form-horizontal">
                            @csrf

                            <div class="row ">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre<span class="required">*</span></label>
                                        <input type="text" class="form-control  @error('nombre') is-invalid @enderror" name="nombre" placeholder="Nombre Proveedor..">
                                        @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="celular">Celular<span class="required">*</span></label>
                                        <input type="number" class="form-control  @error('celular') is-invalid @enderror" name="celular" placeholder="Nro de Celular">
                                        @error('celular')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nit">Nit<span class="required">*</span></label>
                                        <input type="number" class="form-control @error('nit') is-invalid @enderror" name="nit" placeholder="Nro de Nit">
                                        @error('nit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="direccion">Direccion<span class="required">*</span></label>
                                        <input type="text" class="form-control  @error('direccion') is-invalid @enderror" name="direccion" placeholder="Direccion..">
                                        @error('direccion')
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
                                        <!-- <input type="text" class="form-control" name="estado"> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-danger" href="{{route('proveedores.index')}}">Volver</a>
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