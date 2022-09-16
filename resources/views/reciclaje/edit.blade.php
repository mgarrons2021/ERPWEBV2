@extends('layouts.app', ['activePage' => 'eliminaciones', 'titlePage' => 'Eliminaciones'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Reciclaje Nro: {{ $reciclaje->id }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Datos de Reciclaje</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tbody>
                                    <tr>
                                        <th>Fecha de eliminacion:</th>
                                        <td>{{ $reciclaje->fecha }}</td>
                                    </tr>
                                    <tr>
                                        <th> Usuario:</th>
                                        <td>{{$reciclaje->user->name}}</td>
                                    </tr>
                                    <tr>
                                        <th> Sucursal:</th>
                                        <td>{{$reciclaje->sucursal->nombre }}</td>
                                    </tr>
                                    <tr>
                                        <th> Turno:</th>
                                        <td>{{$reciclaje->turno->turno }}</td>
                                    </tr>
                                    @if(isset($reciclaje->inventario->id))
                                    <tr>
                                        <th> Inventario del Que se Elimino:</th>
                                        <td>Inventario: {{ $reciclaje->inventario->id }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th> ¿ Tiene Reciclaje ?</th>
                                        @if ($reciclaje->estado=="Con reciclaje")
                                        <td> <span class="badge badge-info">Con Reciclaje</span></td>
                                        @endif
                                        @if ($reciclaje->estado=="Sin reciclaje")
                                        <td><span class="badge badge-info">Sin Reciclaje</span></td>
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
                                        <option value="">Seleccionar Producto</option>
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
                                    <label for="stock_actual">Stock Actual</label>
                                    <input type="number" name="stock_actual" id="stock_actual" class="form-control" step="any " placeholder="Stock Actual" readonly>
                                    <p class="text-left text-danger d-none" id="errorstockactual">Debe seleccionar un producto para validar este campo </p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock">Cantidad a reciclar </label>
                                    <input type="number" name="stock" id="cantidad" class="form-control" placeholder="Ingrese el stock del producto..." step="any ">
                                    <p class="text-left text-danger d-none" id="errorstock">Debe ingresar la cantidad</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock_nuevo">Nuevo Stock</label>
                                    <input type="number" name="stock_nuevo" id="stock_nuevo" class="form-control" placeholder="Stock Nuevo" step="any " readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock">Observacion </label>
                                    <textarea class="form-control" id="observacion" rows="3" placeholder="Observacion..."></textarea>
                                    <p class="text-left text-danger d-none" id="errorobservacion">Debe ingresar la observacion</p>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button class="btn btn-info" id="agregar_nuevo_reciclaje">Agregar Nuevo Reciclaje </button><br><br>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles del Reciclaje</h4>
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
                                    <input type="hidden" name="reciclaje_id" id="reciclaje_id" value="{{$reciclaje->id}}">
                                    @foreach($reciclaje->detalles_reciclaje as $index => $detalle )
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
                                        <td style="text-align: center;">{{$detalle->producto->unidad_medida_venta->nombre}}</td>
                                        <td style="text-align: center;">
                                            <input type="number" class="form-control stock" id="stock-{{$detalle->id}}" style="text-align:center" value="{{ number_format( $detalle->cantidad,0 ) }}" step="any" readonly>
                                        </td>
                                        <td style="text-align: center;" class="precio" id="precio-{{$detalle->id}}"> {{ number_format( $detalle->precio,2 )}}</td>
                                        <td style="text-align: center;" class="td_observacion" id="observaciones-{{$detalle->id}}"> {{$detalle->observacion}}</td>
                                        <td style="text-align: center;" class="td_subtotal" id="subtotal-{{$detalle->id}}"> {{number_format( $detalle->subtotal,2 ) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <td colspan="7" style="text-align: center;"> Total Reciclaje</td>
                                    <td colspan="1" style="text-align: center;" id="total_reciclaje">{{ number_format( $reciclaje->total , 2)}}</td>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class=" text-center">
                            <button type="button" class="btn btn-primary" id="actualizar_reciclaje">Actualizar
                                Reciclaje</button>
                            <a href="{{ route('reciclajes.index') }}" type="button" class="btn btn-danger" id="cancelar">Cancelar </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')

<script>
    let ruta_actualizarReciclaje =
        "{{ route('reciclajes.actualizarReciclaje') }}";
    let ruta_eliminaciones_index = "{{ route('reciclajes.index') }}";
    let ruta_obtenerDatosProducto = "{{ route('reciclajes.obtenerDatosProducto') }}";
</script>

<script type="text/javascript" src="{{ URL::asset('assets/js/reciclajes/edit.js') }}"></script>

@endsection
@section('page_css')
<link href="{{ asset('assets/css/eliminaciones/edit.css') }}" rel="stylesheet" type="text/css" />

@endsection