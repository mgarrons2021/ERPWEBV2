@extends('layouts.app', ['activePage' => 'eliminaciones', 'titlePage' => 'Eliminaciones'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Eliminacion Nro: {{ $eliminacion->id }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Datos de la Eliminacion</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tbody>
                                    <tr>
                                        <th>Fecha de eliminacion:</th>
                                        <td>{{ $eliminacion->fecha }}</td>
                                    </tr>
                                    <tr>
                                        <th> Usuario:</th>
                                        <td>{{$eliminacion->user->name}}</td>
                                    </tr>
                                    <tr>
                                        <th> Sucursal:</th>
                                        <td>{{ $eliminacion->sucursal->nombre  }}</td>
                                    </tr>
                                    <tr>
                                        <th> Turno:</th>
                                        <td>{{ $eliminacion->turno->turno  }}</td>
                                    </tr>
                                    @if(isset($eliminacion->inventario->id))
                                    <tr>
                                        <th> Inventario del Que se Elimino:</th>
                                        <td>Numero {{ $eliminacion->inventario->id }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th> ¿ Tiene Eliminacion ?</th>
                                        @if ($eliminacion->estado=="Con Eliminacion")
                                        <td> <span class="badge badge-info">Con Eliminacion</span></td>
                                        @endif
                                        @if ($eliminacion->estado=="Sin Eliminacion")
                                        <td><span class="badge badge-info">Sin Eliminacion</span></td>
                                        @endif
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
                            <input type="hidden" name="unidad_medida" id="unidad_medida" class="form-control" placeholder="U.M." readonly>
                            <input type="hidden" name="precio" id="precio" class="form-control" readonly>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="observacion">Observacion</label>
                                    <input type="text" class="form-control" id="observacion" placeholder="Observacion...">
                                    <p class="text-left text-danger d-none" id="errorobservacion">Debe ingresar la observacion de eliminacion</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="stock_actual">Stock Actual</label>
                                    <input type="number" name="stock_actual" id="stock_actual" class="form-control" step="any " placeholder="Stock Actual" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad_eliminar">Cantidad a Eliminar</label>
                                    <input type="number" name="cantidad_eliminar" id="cantidad_eliminar" class="form-control" placeholder="Cantidad a Eliminar..." step="any ">
                                    <input type="hidden" name="precio" id="precio" class="form-control" step="any ">
                                    <input type="hidden" name="unidad_medida" class="form-control" step="any ">
                                    <p class="text-left text-danger d-none" id="errorcantidad">Debe rellenar la cantidad a eliminar</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="stock_nuevo">Nuevo Stock</label>
                                    <input type="number" name="stock_nuevo" id="stock_nuevo" class="form-control" placeholder="Stock Nuevo" step="any " readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button id="agregar_nueva_eliminacion" class="btn btn-primary ">Agregar </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles de la Eliminacion</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table">
                                <thead>
                                    <th style="text-align: center;"> Editar </th>
                                    <th style="text-align: center;"> Eliminar </th>
                                    <th style="text-align: center;"> Producto </th>
                                    <th style="text-align: center;"> UM </th>
                                    <th style="text-align: center;"> Cantidad Eliminada </th>
                                    <th style="text-align: center;"> Costo </th>
                                    <th style="text-align: center;"> Observacion </th>
                                    <th style="text-align: center;"> Subtotal </th>
                                </thead>
                                <tbody id="cuerpo_tabla">
                                    <input type="hidden" name="eliminacion_id" id="eliminacion_id" value="{{$eliminacion->id}}">
                                    @foreach($eliminacion->detalles_eliminacion as $index => $detalle )
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
                                        @if(isset($detalle->producto->nombre))
                                        <td style="text-align: center;">{{$detalle->producto->nombre}}</td>
                                        <td style="text-align: center;">{{$detalle->producto->unidad_medida_venta->nombre}}</td>
                                        @endif
                                        @if(isset($detalle->plato->nombre))
                                        <td style="text-align: center;">{{$detalle->plato->nombre}}</td>
                                        <td style="text-align: center;">{{$detalle->plato->unidad_medida_compra->nombre}}</td>
                                        @endif
                                        <td style="text-align: center;">
                                            <input type="number" class="form-control stock" id="stock-{{$detalle->id}}" style="text-align:center" value="{{$detalle->cantidad}}" step="any" readonly>
                                        </td>                   
                                        <td style="text-align: center;" class="precio" id="precio-{{$detalle->id}}"> {{$detalle->precio}}</td>
                                        <td style="text-align: center;" class="td_observacion" id="observaciones-{{$detalle->id}}"> {{$detalle->observacion}}</td>
                                        <td style="text-align: center;" class="td_subtotal" id="subtotal-{{$detalle->id}}"> {{$detalle->subtotal}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <td colspan="7" style="text-align: center;"> Total Eliminacion</td>
                                    <td colspan="1" style="text-align: center;" id="total_eliminacion">{{$eliminacion->total}}</td>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class=" text-center">
                            <button type="button" class="btn btn-primary" id="actualizar_eliminacion">Actualizar
                                Eliminacion</button>
                            <a href="{{ route('eliminaciones.index') }}" type="button" class="btn btn-danger" id="cancelar">Cancelar </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('assets/js/eliminaciones/edit.js') }}"></script>

<script>
    let ruta_obtenerDatosProducto = "{{ route('eliminaciones.obtenerDatosProducto') }}";
    let ruta_actualizarEliminacion =
        "{{ route('eliminaciones.actualizarEliminacion') }}";
    let ruta_eliminaciones_index = "{{ route('eliminaciones.index') }}";
</script>
@endsection
@section('page_css')
<link href="{{ asset('assets/css/eliminaciones/edit.css') }}" rel="stylesheet" type="text/css" />

@endsection