@extends('layouts.app', ['activePage' => 'proveedores', 'titlePage' => 'Proveedores'])

@section('content')

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Actualizar Proveedor</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-body">
                            <br>
                            <form action="{{ route('proveedores.update',$proveedor->id) }}" method="POST" class="form-horizontal">
                                @csrf
                                @method('PUT')
                                <div class="row ">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="direccion">Direccion<span class="required">*</span></label>
                                            <input type="text" class="form-control" name="direccion" value="{{$proveedor->direccion}}" required>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre">Nombre<span class="required">*</span></label>
                                            <input type="text" class="form-control" name="nombre" value="{{$proveedor->nombre}}" required>
                                        </div>

                                    </div>
                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nit">Nit<span class="required">*</span></label>
                                                <input type="number" class="form-control" name="nit" value="{{$proveedor->nit}}" required>
                                            </div>
                                        </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="celular">Celular<span class="required">*</span></label>
                                            <input type="number" class="form-control" name="celular" value="{{$proveedor->celular}}" required>
                                        </div>
                                    </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="estado">Estado<span class="required">*</span></label>
                                                <div class="selectric-hide-select">
                                                    <select name="estado" class="form-control selectric">
                                                        @if($proveedor->estado===1)
                                                        <option value="1" selected>Activo</option>
                                                        <option value="0">Inactivo</option>
                                                        @endif
                                                        @if($proveedor->estado===0)
                                                        <option value="1">Activo</option>
                                                        <option value="0" selected>Inactivo</option>
                                                        @endif
                                                    </select>
                                                </div>
                                               
                                            </div>
                                        </div>


                                        
                                    </div>
                                    <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary" tabindex="7">Guardar</button>
                                            <a href="{{route('proveedores.index')}}" class="btn btn-danger" tabindex="8">Cancelar</a>
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