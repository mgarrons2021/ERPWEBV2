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
                        <form action="{{ route('asignar_stock.update',$asignar_stock->id) }}" method="POST" class="form-horizontal">
                            @csrf
                            @method('PUT')
                            <div class="row ">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha">Fecha<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="fecha" value="{{$asignar_stock->fecha}}" readonly>
                                    </div>
                                </div>
                                
                                <div class="col-md-6"></div>
                                    <div class="form-group">
                                        <label for="producto">Producto<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="producto" value="{{$asignar_stock->producto->nombre}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="precio_producto">Nuevo Stock<span class="required">*</span></label>
                                        <input type="number" class="form-control" name="precio_producto" value="{{$asignar_stock->precio}}" step="any" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary" tabindex="7">Guardar</button>
                                <a href="{{route('asignar_stock.index')}}" class="btn btn-danger" tabindex="8">Cancelar</a>
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