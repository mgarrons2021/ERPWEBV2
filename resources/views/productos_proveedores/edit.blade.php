@extends('layouts.app', ['activePage' => 'productos_proveedores', 'titlePage' => 'productos_proveedores'])

@section('content')

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Actualizar Producto Proveedor</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <br>
                        <form action="{{ route('productos_proveedores.update',$producto_proveedor->id) }}" method="POST" class="form-horizontal">
                            @csrf
                            @method('PUT')
                            <div class="row ">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha">Fecha<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="fecha" value="{{$producto_proveedor->fecha}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="proveedor">Producto<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="proveedor" value="{{$producto_proveedor->proveedor->nombre}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="producto">Producto<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="producto" value="{{$producto_proveedor->producto->nombre}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="estado">Estado del Precio<span class="required">*</span></label>
                                        <select name="estado" id="estado" class="form-control" >
                                            <option value="Habilitado">Habilitado</option>
                                            <option value="Deshabilitado">Deshabilitado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="precio_producto">Nuevo Precio del Producto<span class="required">*</span></label>
                                        <input type="number" class="form-control" name="precio_producto" value="{{$producto_proveedor->precio}}" step="any" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary" tabindex="7">Guardar</button>
                                <a href="{{route('productos_proveedores.index')}}" class="btn btn-danger" tabindex="8">Cancelar</a>
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