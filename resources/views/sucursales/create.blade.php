@extends('layouts.app', ['activePage' => 'sucursales', 'titlePage' => 'Sucursales'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nueva Sucursal</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="card card-primary">
                            <br>
                            <form action="{{ route('sucursales.store') }}" method="POST" class="form-horizontal">
                                @csrf

                                <div class="row ">
                                   

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
                                            <label for="direccion">Direccion<span class="required">*</span></label>
                                            <input type="text" class="form-control  @error('direccion') is-invalid @enderror" name="direccion">
                                            @error('direccion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="correo">Correo<span class="required">*</span></label>
                                            <input type="text" class="form-control @error('correo') is-invalid @enderror" name="correo">
                                            @error('correo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nro_fiscal">Numero Fiscal<span class="required">*</span></label>
                                        <input type="number" class="form-control  @error('nro_fiscal') is-invalid @enderror" name="nro_fiscal">
                                        @error('nro_fiscal')
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
                                                    <option value="activo">Activo</option>
                                                    <option value="inactivo">Inactivo</option>
                                                </select>
                                            </div>
                                            <!-- <input type="text" class="form-control" name="estado"> -->
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <a class="btn btn-danger" href="{{route('sucursales.index')}}">Volver</a>
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