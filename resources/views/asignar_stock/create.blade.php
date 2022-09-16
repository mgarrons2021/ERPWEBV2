@extends('layouts.app', ['activePage' => 'asignar_stock', 'titlePage' => 'Productos_Proveedores'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Asignar Stock </h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha">Fecha<span class="required">*</span></label>
                                    <input type="date" class="form-control  @error('fecha') is-invalid @enderror" name="fecha" value="{{ $fecha_act }}" readonly>
                                    @error('fecha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="producto">Seleccione <span class="required">*</span></label>
                                    <div class="selectric-hide-select">
                                        <select name="producto" class="form-control selectric" id="producto">
                                            @foreach ($productos as $producto)
                                            <option value="{{ $producto->id }}">{{ $producto->nombre }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cantidad">Stock<span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('cantidad') is-invalid @enderror" id="cantidad" name="cantidad" step="any">
                                    @error('cantidad')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                          <div class="col-md-6">
                        <h6 class="card-title">Sucursal</h6>
                        <select class="form-select" aria-label="Default select example" name="sucursal_id" id="sucursal">
                            @foreach($sucursales as $sucursal)
                            <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                            @endforeach
                        </select>
                    </div> 
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary" id="agregar_detalle">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-md" style="width: 100%;" id="table">
                    <thead>
                        <th style="text-align: center;">Sucursal</th>
                        <th style="text-align: center;">Producto</th>
                        <th style="text-align: center;">Stock</th>
                        <th style="text-align: center;">Opciones</th>
                    </thead>
                    <tbody id="tbody">
                        @if (session('detalles_stock_ideal'))
                            @foreach (session('detalles_stock_ideal') as $indice => $item)
                            <tr>
                                <td style="text-align: center;">{{ $item['sucursal']['nombre']}}</td>
                                <td style="text-align: center;">{{ $item['producto_nombre']['nombre'] }}</td>
                                <td style="text-align: center;">{{ $item['cantidad'] }}</td>
                                <td style="text-align: center;"><button class="btn btn-danger" onclick="eliminar({{ $indice }});"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
            </div>

        </div>
        <div class="card-footer">
            <div class=" text-center">
                <button type="button" class="btn btn-primary" id="registrar_Stock">Registrar Stock </button>
                <button type="button" class="btn btn-danger" id="cancelar">Cancelar </button>
            </div>
        </div>
    </div>

</section>
@endsection
@section('scripts')

<script>
    $(document).ready(function() {
        $('#producto').select2({
            width: 'resolve',
        
        });
    });
</script>
<script type="text/javascript" src="{{ URL::asset('assets/js/asignar_stock/create.js') }}"> </script>
<script>
    let ruta_guardardetalle = "{{ route('asignar_stock.guardarDetalle') }}";
    let ruta_eliminardetalle = "{{ route('asignar_stock.eliminarDetalle') }}";
    let ruta_registrar_Stock = "{{ route('asignar_stock.registrar_Stock') }}";
    let ruta_registrar_Stock_index = "{{ route('asignar_stock.index') }}";
</script>

@endsection