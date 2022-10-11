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
                                        <td>{{$pedido->fecha_actual }}</td>
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
                                        <td>{{ $pedido->sucursal_principal->nombre  }}</td>
                                    </tr>
                                    <tr>
                                        <th> Estado Pedido:</th>

                                        @if ($pedido->estado==1)
                                        <td> <span class="badge badge-warning"> Recibido </span></td>
                                        @endif
                                        @if ($pedido->estado==0)
                                        <td class="badge badge-success"> Entregado</td>
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
                                        @foreach($categorias as $categoria)
                                        <optgroup label="{{Str::upper( $categoria->nombre)}}" class="title-select">
                                            @foreach($categoria->productos as $producto)
                                            <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                            @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>
                                    <p class="text-left text-danger d-none" id="errorproducto">Debe seleccionar un producto</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button id="agregar_insumo" class="btn btn-primary ">Agregar </button>
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
                                <th style="text-align: center;"> UM </th>
                                <th style="text-align: center;"> Cantidad Solicitada </th>
                                <th style="text-align: center;"> Cantidad Enviada </th>
                                <th style="text-align: center;"> Costo </th>
                                <th style="text-align: center;"> Subtotal Enviado </th>
                            </thead>
                            <tbody id="cuerpotabla">
                                <input type="hidden" name="pedido_id" id="pedido_id" value="{{$pedido->id}}">
                                @if( count($pedido->detalle_pedidos)<=0 ) <tr>
                                    <td style="text-align: center;" colspan="6"> SIN PEDIDOS </td>
                                    </tr>
                                    @endif
                                    @foreach($detallePedido as $index => $detalle )
                                    <tr>
                                        <td style="text-align: center;">{{$detalle->nombre}}</td>

                                        @if(isset($detalle->UnidadMedidaNombre))
                                        <td style="text-align: center;">{{$detalle->UnidadMedidaNombre}}</td>
                                        @else
                                        <td>S/U</td>
                                        @endif
                                        <td style="text-align: center;">{{ number_format($detalle->cantidad_solicitada,2)}}</td>
                                        <td style="text-align: center;">
                                            @if($detalle->cantidad_enviada!=null)
                                            <input type="number" class="form-control stock" id="stock-{{$detalle->id}}" style="text-align:center" name="cantidad_enviada" value="{{$detalle->cantidad_enviada}}" step="any">
                                            @else
                                            <input type="number" class="form-control stock" id="stock-{{$detalle->id}}" style="text-align:center" name="cantidad_enviada" value="{{$detalle->cantidad_solicitada}}" step="any">
                                            @endif
                                        </td>
                                        <td style="text-align: center;" class="precios" id="precio-{{$detalle->id}}"> {{$detalle->precio}}</td>
                                        <td style="text-align: center;" class="td_subtotal" name="subtotal_enviado" id="subtotal-{{$detalle->id}}"> 
                                            @if($detalle->subtotal_enviado!=null)
                                            {{$detalle->subtotal_enviado}}
                                            @else
                                            {{$detalle->cantidad_solicitada * $detalle->precio}}
                                            @endif
                                        </td>
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
                            <button type="button" class="btn btn-primary" id="actualizar_pedido">Actualizar Pedido</button>
                            <a href="{{ route('pedidos.index') }}" type="button" class="btn btn-danger" id="cancelar">Cancelar </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/js/pedidos/editenviado.js') }}"></script>
<script>
    let ruta_obtener_precios = "{{route('pedidos.obtenerPrecios')}}"
    let ruta_actualizar_pedido_enviado = "{{ route('pedidos.actualizarPedidoEnviado') }}";
    let ruta_pedidos_index = "{{ route('pedidos.index') }}";
</script>
@endsection
@section('page_css')
<link href="{{ asset('assets/css/inventarios/edit.css') }}" rel="stylesheet" type="text/css" />
@endsection