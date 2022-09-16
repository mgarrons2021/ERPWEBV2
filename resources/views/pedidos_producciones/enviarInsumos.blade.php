@extends('layouts.app', ['activePage' => 'pedidos', 'titlePage' => 'Pedidos'])

@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Editar Pedido Enviado Nro: {{ $pedido->id }}</h3>
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
                                        <td>{{$pedido->total_solicitado}} Bs</td>
                                    </tr>
                                    <tr>
                                        <th> Sucursal:</th>
                                        <td>{{ $pedido->sucursal_usuario->nombre  }}</td>
                                    </tr>
                                    <tr>
                                        <th> Estado Pedido:</th>

                                        @if ($pedido->estado === 'E')
                                        <td class="badge badge-success"> Enviado</td>
                                        @elseif ($pedido->estado == 'S')
                                        <td> <span class="badge badge-warning"> Solicitado </span></td>
                                        @else
                                        <td> <span class="badge badge-success"> Aceptado </span></td>
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
                                    <label for="producto">Seleccione el Producto</label>
                                    <select name="producto" id="producto" class="form-select select22" style="width: 100%;">
                                        <option value="sin_seleccionar">Seleccionar Producto</option>
                                        @foreach($platos as $producto)
                                        <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-left text-danger d-none" id="errorproducto">Debe seleccionar un producto</p>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button id="agregar_nuevo_producto" class="btn btn-primary ">Agregar </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" id="producto_nombre" name="producto_nombre" class="form-control" value="">
            <input type="hidden" id="unidad_medida" name="unidad_medida" class="form-control" value="">
            <input type="hidden" id="precio" name="precio" class="form-control" value="" placeholder="Bs" readonly>
            <input type="hidden" id="subtotal_solicitado" name="subtotal_solicitado" class="form-control" value="" placeholder="Bs" readonly>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles del Pedido</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th style="text-align: center;"> Insumo </th>
                                <th style="text-align: center;"> Cantidad Solicitada </th>
                                <th style="text-align: center;"> UM </th>
                                <th style="text-align: center;"> Cantidad Enviada </th>
                                <th style="text-align: center;"> Costo </th>
                                <th style="text-align: center;"> Subtotal Enviado </th>
                            </thead>
                            <tbody id="cuerpotabla">
                                <input type="hidden" name="pedido_id" id="pedido_id" value="{{$pedido->id}}">
                                @if( count($pedido->detalle_pedido_produccion)<=0 ) <tr>
                                    <td style="text-align: center;" colspan="6"> SIN PEDIDOS </td>
                                    </tr>
                                    @endif
                                    @foreach($pedido->detalle_pedido_produccion as $index => $detalle )
                                    <tr>
                                        <td style="text-align: center;">{{$detalle->plato->nombre}}</td>
                                        <td style="text-align: center;">{{ number_format($detalle->cantidad_solicitada,2)}}</td>

                                        @if(isset($detalle->plato->unidad_medida_venta->nombre))
                                        <td style="text-align: center;">{{$detalle->plato->unidad_medida_venta->nombre}}</td>
                                        @else
                                        <td>Sin U/M</td>
                                        @endif

                                        <td style="text-align: center;">
                                            <input type="number" class="form-control stock" id="stock-{{$detalle->id}}" style="text-align:center" name="cantidad_enviada" value="{{$detalle->cantidad_enviada}}" step="any">
                                        </td>
                                        <td style="text-align: center;" class="precios" id="precio-{{$detalle->id}}"> {{$detalle->precio}}</td>
                                        <td style="text-align: center;" class="td_subtotal" name="subtotal_enviado" id="subtotal-{{$detalle->id}}"> {{$detalle->subtotal_enviado}}</td>
                                    </tr>
                                    @endforeach
                            </tbody>
                            <tfoot>
                                <td colspan="5" style="text-align: center;"> Total Enviado del Pedido</td>
                                <td colspan="1" style="text-align: center;" name="total_enviado" id="total_pedido">{{$pedido->total_enviado}}</td>
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class=" text-center">
                            <button type="button" class="btn btn-primary" id="actualizar_pedido_enviado">Actualizar Pedido</button>
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
<script type="text/javascript" src="{{ asset('assets/js/pedidos_producciones/editinsumos.js') }}"></script>

<script>
    let ruta_actualizar_pedido_enviado = "{{ route('pedidos_producciones.actualizarPedidoEnviado') }}";

    let ruta_obtener_precios = "{{route('pedidos_producciones.obtenerDatosPlato')}}";

    let ruta_pedidos_producciones_index = "{{ route('pedidos_producciones.index') }}";
</script>
@endsection
@section('page_css')
<link href="{{ asset('assets/css/inventarios/edit.css') }}" rel="stylesheet" type="text/css" />
@endsection