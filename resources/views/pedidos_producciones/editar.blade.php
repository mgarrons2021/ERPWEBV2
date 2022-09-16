@extends('layouts.app', ['activePage' => 'Pedidos Producion', 'titlePage' => 'Pedidos Produccion'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Pedido Nro: {{ $pedido->id }}</h3>
    </div>
    <div class="section-body">
        <div class="row">

            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-header">
                        <h4>Datos del Pedido Produccion</h4>
                    </div>
                    <div class="card-body"> 
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tbody>
                                    @php
                                    $hora = new DateTime($pedido->created_at);
                                    $hora_solicitado = $hora->format('H:i:s');

                                    @endphp

                                    <tr>
                                        <th>Fecha pedido:</th>
                                        <td>{{$pedido->fecha }}</td>
                                    </tr>
                                    <tr>
                                        <th>Hora pedido:</th>
                                        <td>{{ $hora_solicitado }}</td>
                                    </tr>

                                    <tr>
                                        <th>Fecha Entrega:</th>
                                        <td>{{ $pedido->fecha_pedido }}</td>
                                    </tr>

                                    <tr>
                                        <th> Total Solicitado:</th>
                                        <td>{{ number_format($pedido->total_solicitado,2) }} Bs</td>
                                    </tr>
                                    <tr>
                                        <th> Sucursal:</th>
                                        <td>{{  $pedido->sucursal_pedido->nombre  }}</td>
                                    </tr>
                                    <tr>
                                        <th> Estado Pedido:</th>                                        
                                        @if ($pedido->estado == 'S' )
                                        <td class=""> <span class="badge badge-warning"> Solicitado </span></td>
                                        @elseif($pedido->estado == 'E' )
                                        <td class="">  <span class="badge badge-success"> En Espera </span> </td>
                                        @elseif($pedido->estado =='A')
                                        <td class=""> <span class="badge badge-info"> Aceptado </button></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th> Realizado Por</th>
                                        <td>{{$pedido->user->name}}</td>
                                    </tr>
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
                                                <select name="plato_id" class="form-control selectric" id="plato">
                                                    <option value="x">Seleccione los Platos </option>
                                                    @if(isset($menu_semanal->detalle_menus_semanales))
                                                        @foreach($menu_semanal->detalle_menus_semanales as $detalle)
                                                            @if( $detalle->plato->estado != 0 )
                                                            <option value="{{$detalle->plato->id}}">{{$detalle->plato->nombre}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif       
                                                </select>
                                        <p class="text-left text-danger d-none" id="errorproducto">Debe seleccionar un producto</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="cantidad_solicitada">Cantidad*</label>
                                <input type="number" name="cantidad_solicitada" id="cantidad_solicitada" class="form-control" value="">
                                <p class="text-left text-danger d-none" id="errorcantidad">Debe de ingresar una cantidad</p>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary" id="agregar_insumo">Agregar Insumo</button>
                            </div>
                            <input type="hidden" id="producto_nombre" name="producto_nombre" class="form-control" value="">
                            <input type="hidden" id="unidad_medida" name="unidad_medida" class="form-control" value="">
                            <input type="hidden" id="precio" name="precio" class="form-control" value="" placeholder="Bs" readonly>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles del Pedido Produccion</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th style="text-align: center;"> Editar </th>
                                <th style="text-align: center;"> Eliminar </th>
                                <th style="text-align: center;"> Insumo </th>
                                <th style="text-align: center;"> UM </th>
                                <th style="text-align: center;"> Cantidad Solicitada </th>
                                <th style="text-align: center;"> Costo </th>
                                <th style="text-align: center;"> Subtotal </th>
                            </thead>
                            <tbody>
                                <input type="hidden" name="pedido_id" id="pedido_id" value="{{$pedido->id}}">
                                @foreach($pedido->detalle_pedido_produccion as $index => $detalle )
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

                                    <td style="text-align: center;">{{$detalle->plato->nombre}}</td>
                                    @if(isset($detalle->producto->unidad_medida_venta->nombre))
                                    <td style="text-align: center;">{{$detalle->producto->unidad_medida_venta->nombre}}</td>
                                    @else 
                                    <td>SIN U/M</td>
                                    @endif
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="stock-{{$detalle->id}}" style="text-align:center" value="{{$detalle->cantidad_solicitada}}" step="any" readonly>
                                    </td>
                                    <td style="text-align: center;" class="precio" id="precio-{{$detalle->id}}"> {{$detalle->precio}}</td>
                                    <td style="text-align: center;" class="td_subtotal" id="subtotal-{{$detalle->id}}"> {{$detalle->subtotal_solicitado}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <td colspan="6" style="text-align: center;"> Total Solicitado del Pedido</td>
                                <td colspan="1" style="text-align: center;" id="total_pedido">{{$pedido->total_solicitado}}</td>
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class=" text-center">
                            <button type="button" class="btn btn-primary" id="actualizar_pedido">Actualizar Pedido</button>
                            <a href="{{ route('pedidos_producciones.index') }}" type="button" class="btn btn-danger" id="cancelar">Cancelar </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')

<script type="text/javascript" src="{{ URL::asset('assets/js/pedidos_producciones/editar.js') }}"></script>

<script>
    const csrfToken = document.head.querySelector( "[name~=csrf-token][content]" ).content;

    let ruta_obtener_precios = "{{route('pedidos.obtenerPrecios')}}"
    let ruta_actualizarPedido = "{{ route('pedidos.actualizarPedido') }}";
    let ruta_inventarios_index = "{{ route('pedidos.index') }}";    
    let ruta_obtener_precio="{{ route('pedidos_producciones.obtenerPrecioPlato') }}";
    let ruta_obtener_costo = "{{route('pedidos_producciones.obtenerCostoPlato')}}"
    let ruta_guardar_pedido = "{{ route('pedidos_producciones.store') }}";
    let ruta_pedidos = "{{ route('pedidos_producciones.index') }}";
</script>

</script>

@endsection
@section('page_css')
<link href="{{ asset('assets/css/inventarios/edit.css') }}" rel="stylesheet" type="text/css" />
@endsection