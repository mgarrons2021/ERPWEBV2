@extends('layouts.app', ['activePage' => 'platos_sucursales', 'titlePage' => 'Platos Sucursales'])

@section('content')

<section class="section">
    <div class="section-header">
        <h3 class="page__heading"> Actualizar Plato Sucursal</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <br>
                        <form action="{{ route('platos_sucursales.update',$plato_sucursal->id) }}" method="POST" class="form-horizontal">
                            @csrf
                            @method('PUT')
                            <div class="row ">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="categoria_plato">Categoria<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="categoria_plato" value="{{$plato_sucursal->categoria_plato->nombre}}" readonly>
                                    </div>
                                </div>
                               
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="plato">Plato<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="plato" value="{{$plato_sucursal->plato->nombre}}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sucursal">Sucursal Asignado<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="sucursal" value="{{$plato_sucursal->sucursal->nombre}}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="precio">New Price<span class="required">*</span></label>
                                        <input type="number" class="form-control" name="precio" value="{{$plato_sucursal->precio}}" step="any" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="precio_delivery">New Delivery Price<span class="required">*</span></label>
                                        <input type="number" class="form-control" name="precio_delivery" value="{{$plato_sucursal->precio_delivery}}" step="any" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary" tabindex="7">Actualizar</button>
                                <a href="{{route('platos_sucursales.index')}}" class="btn btn-danger" tabindex="8">Cancelar</a>
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