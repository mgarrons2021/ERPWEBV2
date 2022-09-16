@extends('layouts.app', ['activePage' => 'sucursales', 'titlePage' => 'Sucursales'])

@section('content')

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Actualizar Sucursal</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card card-primary">
                            <br>
                            <form action="{{ route('sucursales.update',$sucursal->id) }}" method="POST" class="form-horizontal">
                                @csrf
                                @method('PUT')
                                <div class="row ">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="direccion">Direccion<span class="required">*</span></label>
                                            <input type="text" class="form-control" name="direccion" value="{{$sucursal->direccion}}" required>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre">Nombre<span class="required">*</span></label>
                                            <input type="text" class="form-control" name="nombre" value="{{$sucursal->nombre}}" required>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="correo">Correo<span class="required">*</span></label>
                                            <input type="text" class="form-control" name="correo" value="{{$sucursal->correo}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nro_fiscal">Nro Fiscal<span class="required">*</span></label>
                                            <input type="number" class="form-control" name="nro_fiscal" value="{{$sucursal->nro_fiscal}}" required>
                                        </div>
                                    </div>
                             

                                <div class="row">
                                    
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
                                        <button type="submit" class="btn btn-primary" tabindex="7">Guardar</button>
                                        <a href="{{route('sucursales.index')}}" class="btn btn-danger" tabindex="8">Cancelar</a>
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