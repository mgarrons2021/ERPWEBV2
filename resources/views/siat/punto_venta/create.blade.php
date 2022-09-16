@extends('layouts.app', ['activePage' => 'categoria_plato', 'titlePage' => 'Categoria Plato'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nuevo Registro Punto Venta </h3>
    </div>
    <div class="section-body">
        
        <div class="row">
            <form action="{{ route('puntos_ventas.store') }}" method="POST" class="form-horizontal">
                <div class="card">
                    <div class="card-body">
                        <br>
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="categoria_id">Seleccione la Sucursal<span class="required">*</span></label>
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
                                 <button type="submit" class="btn btn-primary">Registrar Punto Venta</button>
                                 <a class="btn btn-danger" href="{{route('puntos_ventas.index')}}">Volver</a>
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