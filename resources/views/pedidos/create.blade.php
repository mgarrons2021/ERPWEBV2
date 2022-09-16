@extends('layouts.app', ['activePage' => 'Precio Sucursales', 'titlePage' => 'Precio Sucursales'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading"> Solicitud de Pedidos de Insumos/Zumos a CDP </h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="background-color: #6777ef;">
                        <h4 style="color:white;">Pedido: Nro {{$last_pedido}}. &nbsp;</h4>
                        <h4 style="text-align:right;color:white;">Fecha: {{$fecha_actual}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_pedido">Fecha Entrega*</label>
                                    <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <p class="text-left text-danger d-none" id="errorfecha">Debe ingresar una fecha </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="producto">Seleccione el Producto</label>
                                    <select name="producto" class="form-select select22" id="producto" style="width: 100%;">
                                        <option value="x">Seleccione el Producto </option>
                                        @foreach($categorias as $categoria)
                                        @if( $categoria->nombre != "Produccion" && $categoria->nombre != "Bebidas" )
                                        <optgroup label="{{Str::upper( $categoria->nombre)}}" class="title-select">
                                            @foreach($categoria->productos as $producto)
                                            @if( $producto->estado != 0 )
                                            <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                            @endif
                                            @endforeach
                                        </optgroup>
                                        @endif
                                        @endforeach
                                    </select>
                                    <p class="text-left text-danger d-none" id="errorproducto">Debe seleccionar un producto</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="cantidad_solicitada">Cantidad*</label>
                                <input type="number" name="cantidad_solicitada" id="cantidad_solicitada" class="form-control" value="">
                                <p class="text-left text-danger d-none" id="errorcantidad">Debe de ingresar una cantidad</p>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-outline-success" id="agregar_insumo">Agregar Insumo</button>
                            </div>
                            <input type="hidden" id="producto_nombre" name="producto_nombre" class="form-control" value="">
                            <input type="hidden" id="precio" name="precio" class="form-control" value="" placeholder="Bs" readonly>
                            <input type="hidden" id="subtotal_solicitado" name="subtotal_solicitado" class="form-control" value="" placeholder="Bs" readonly>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" style="width: 100%;" id="table">
                    <thead class="table-info">
                        {{-- <th style="text-align: center;">Sucursal </th> --}}
                        <th style="text-align: center;">Producto</th>
                        <th style="text-align: center;">Cantidad Solicitada</th>
                        <th style="text-align: center;">Unidad Medida</th>
                        <th style="text-align: center;">Costo Unitario </th>
                        <th style="text-align: center;">Sub Total </th>

                        <th style="text-align: center;">Opciones</th>
                    </thead>
                    <tbody id="tbody">
                        @php
                        $total =0;
                        @endphp
                        @if (session('pedidos_sucursales'))
                        @foreach (session('pedidos_sucursales') as $indice => $value)
                        <tr>

                            <td style="text-align: center;">{{$value['producto_nombre']}} </td>
                            <td style="text-align: center;"> {{ $value['cantidad_solicitada'] }}</td>
                            <td style="text-align: center;"> {{ $value['unidad_medida'] }}</td>

                            <td style="text-align: center;">{{ $value['precio'] }} Bs</td>
                            <td style="text-align: center;">{{ $value['subtotal_solicitado'] }} Bs</td>

                            @php
                            $total += $value['subtotal_solicitado'];
                            @endphp
                            <td style="text-align: center;">
                                <button class="btn btn-danger" onclick="eliminar({{ $indice }});"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                        <tr>
                            <td colspan="6" style="text-align: center;" class="table-info">Total: {{ number_format($total,3) }} Bs</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="card-footer">
            <div class=" text-center">
                <button type="button" class="btn btn-outline-info" id="guardar_pedido"> Registrar Pedido </button>
                <button type="button" class="btn btn-outline-danger" id="cancelar">Cancelar </button>
            </div>
        </div>
    </div>

</section>
@endsection
@section('scripts')

<script type="text/javascript" src="{{ URL::asset('assets/js/pedidos/create.js') }}"> </script>
<script>
    let ruta_agregar_insumo = "{{ route('pedidos.agregarInsumo') }}";
    let ruta_obtener_precios = "{{route('pedidos.obtenerPrecios')}}"
    let ruta_eliminar_insumo = "{{ route('pedidos.eliminarInsumo') }}";
    let ruta_guardar_pedido = "{{ route('pedidos.store') }}";
    let ruta_pedidos = "{{ route('pedidos.index') }}";

    let ruta_obtener_plato = "{{route('platos_sucursales.obtenerPlato')}}";
</script>

{{-- <script>
    sucursal.addEventListener("change", () => {
        sucursal.disabled = "readonly";
    });
</script> --}}

@endsection