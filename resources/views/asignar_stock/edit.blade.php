@extends('layouts.app', ['activePage' => 'pedidos', 'titlePage' => 'Pedidos'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Stock Nro: {{ $asignar_stock->id }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-header">
                        <h4>Datos del Pedido</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tbody>                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="producto">Seleccione el Producto<span class="required">*</span></label>
                                    <div class="selectric-hide-select">
                                        <select name="producto_id" class="form-control selectric" id="producto">
                                            <option value="x">Seleccione el Producto </option>
                                            @foreach($categorias as $categoria)
                                            @if( $categoria->nombre != "Produccion" )
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
                            </div>
                            <div class="col-md-6">
                                <label for="cantidad_solicitada">Cantidad*</label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control" value="">
                                <p class="text-left text-danger d-none" id="errorcantidad">Debe de ingresar una cantidad</p>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary" id="agregar_insumo">Agregar Insumo</button>
                            </div>
                            <input type="hidden" id="producto_nombre" name="producto_nombre" class="form-control" value="">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles del Pedido</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" >
                            <thead >
                                <th style="text-align: center;"> Editar </th>
                                <th style="text-align: center;"> Eliminar </th>
                                <th style="text-align: center;"> Insumo </th>     
                                <th style="text-align: center;"> Cantidad Solicitada </th>
                    
                            </thead>
                            <tbody id="cuerpotabla">
                                <input type="hidden" name="asignar__stock_id" id="asignar__stock_id" value="{{$asignar_stock->id}}">
                                @foreach($asignar_stock->detalle_asignar_stock as $detalle )
                                <tr>
                                    <td style="text-align:center ;">
                                        <!-- Rounded switch -->
                                        <label class="switch">
                                            <input type="checkbox" class="checkbox-editar" value="{{$detalle->id}}">
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td style="text-align:center ;">
                                        <label class="switch">
                                            <input type="checkbox" class="checkbox-eliminar" value="{{$detalle->id}}">
                                            <span class="slider round"></span>
                                        </label>
                                    </td>

                                    <td style="text-align: center;">{{$detalle->producto->nombre}}</td>
                                  
                                  
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="stock-{{$detalle->id}}" style="text-align:center" value="{{$detalle->cantidad}}" step="any" readonly>
                                    </td>
                                  
                                @endforeach
                            </tbody>
                       
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class=" text-center">
                            <button type="button" class="btn btn-primary" id="actualizarStock">Actualizar Stock</button>
                            <a href="{{ route('asignar_stock.index') }}" type="button" class="btn btn-danger" id="cancelar">Cancelar </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')

<script type="text/javascript" src="{{ URL::asset('assets/js/asignar_stock/edit.js') }}"></script>
<script>

let ruta_actualizarPedido = "{{ route('asignar_stock.actualizarStock') }}";
let ruta_asignar_stock_index = "{{ route('asignar_stock.index') }}";
let ruta_obtener_precios = "{{route('pedidos.obtenerPrecios')}}";

</script>

@endsection
@section('page_css')
<link href="{{ asset('assets/css/inventarios/edit.css') }}" rel="stylesheet" type="text/css" />
@endsection