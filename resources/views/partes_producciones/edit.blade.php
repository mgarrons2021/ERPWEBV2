@extends('layouts.app', ['activePage' => 'pedidos', 'titlePage' => 'Pedidos'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Pedido Nro: {{ $partes_producciones->id }}</h3>
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
                                    $hora = new DateTime($partes_producciones->created_at);
                                    $hora_solicitado = $hora->format('H:i:s');

                                    @endphp

                                    <tr>
                                        <th>Fecha pedido:</th>
                                        <td>{{$partes_producciones->fecha_actual }}</td>
                                    </tr>
                                    <tr>
                                        <th>Hora pedido:</th>
                                        <td>{{ $hora_solicitado }}</td>
                                    </tr>

                                    <tr>
                                        <th>Fecha Entrega:</th>
                                        <td>{{ $partes_producciones->fecha_pedido }}</td>
                                    </tr>

                                    <tr>
                                        <th> Total Solicitado:</th>
                                        <td>{{$partes_producciones->total}} Bs</td>
                                    </tr>
                                  
                                    <tr>
                                        <th> Estado Pedido:</th>

                                        @if ($partes_producciones->estado==1)
                                        <td> <span class="badge badge-warning"> Recibido </span></td>
                                        @endif
                                        @if ($partes_producciones->estado==0)
                                        <td class="badge badge-success"> Entregado</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th> Realizado Por</th>
                                        <td>{{$partes_producciones->user->name}}</td>
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
                                <label for="cantidad">Cantidad*</label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control" value="">
                                <p class="text-left text-danger d-none" id="errorcantidad">Debe de ingresar una cantidad</p>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary" id="agregar_insumo">Agregar Insumo</button>
                            </div>
                            <input type="hidden" id="producto_nombre" name="producto_nombre" class="form-control" value="">
                            <input type="hidden" id="unidad_medida" name="unidad_medida" class="form-control" value="">
                            <input type="hidden" id="precio" name="precio" class="form-control" value="" placeholder="Bs" readonly>
                            <input type="hidden" id="subtotal" name="subtotal" class="form-control" value="" placeholder="Bs" readonly>
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
                                <!-- <th style="text-align: center;"> UM </th> -->
                                <th style="text-align: center;"> Cantidad Solicitada </th>
                                <th style="text-align: center;"> Costo </th>
                                <th style="text-align: center;"> Subtotal </th>
                            </thead>
                            <tbody id="cuerpotabla">
                                <input type="hidden" name="parte_produccion_id" id="parte_produccion_id" value="{{$partes_producciones->id}}">
                                @foreach($partes_producciones->detalle_partes_producciones as $index => $detalle )
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
                                  <!--   @if(isset($detalle->producto->unidad_medida_venta->nombre))
                                    <td style="text-align: center;">{{$detalle->producto->unidad_medida_venta->nombre}}</td>
                                    @else 
                                    <td>SIN U/M</td>
                                    @endif -->
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="stock-{{$detalle->id}}" style="text-align:center" value="{{$detalle->cantidad}}" step="any" readonly>
                                    </td>
                                    <td style="text-align: center;" class="precio" id="precio-{{$detalle->id}}"> {{$detalle->precio}}</td>
                                    <td style="text-align: center;" class="subtotal" id="subtotal-{{$detalle->id}}"> {{$detalle->subtotal}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <td colspan="5" style="text-align: center;"> Total Parte Produccion</td>
                                <td colspan="1" style="text-align: center;" id="total">{{$partes_producciones->total}} Bs</td>
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class=" text-center">
                            <button type="button" class="btn btn-primary" id="actualizar_pedido">Actualizar Pedido</button>
                            <a href="{{ route('partes_producciones.index') }}" type="button" class="btn btn-danger" id="cancelar">Cancelar </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')

<script type="text/javascript" src="{{ URL::asset('assets/js/partes_producciones/edit.js') }}"></script>
<script>
    let ruta_obtener_precios = "{{route('partes_producciones.obtenerPrecios')}}";
    let ruta_actualizarPedido = "{{ route('partes_producciones.actualizarPedido') }}";
    let ruta_pedidos_index = "{{ route('partes_producciones.index') }}";
    let ruta_actualizar_pedido_enviado ="{{route('partes_producciones.actualizarPedido')}}"; 
</script>

@endsection
@section('page_css')

<link href="{{ asset('assets/css/inventarios/edit.css') }}" rel="stylesheet" type="text/css" />

@endsection
