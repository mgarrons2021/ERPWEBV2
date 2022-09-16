@extends('layouts.app', ['activePage' => 'inventarios', 'titlePage' => 'Inventarios'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Inventario  Nro: {{ $inventario->id }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-header">
                        <h4>Datos del Inventario  </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tbody>
                                    <tr>
                                        <th>Fecha de inventario:</th>
                                        <td>{{ $inventario->fecha }}</td>
                                    </tr>
                                    <tr>
                                        <th> Usuario:</th>
                                        <td>{{$inventario->user->name}}</td>
                                    </tr>
                                    <tr>
                                        <th> Sucursal:</th>
                                        <td>{{ $inventario->sucursal->nombre  }}</td>
                                    </tr>
                                    <tr>
                                        <th> Tipo de Inventario:</th>
                                        @if ($inventario->tipo_inventario=="D")
                                        <td> <span class="badge badge-info"> Diario </span></td>
                                        @endif
                                        @if ($inventario->tipo_inventario=="S")
                                        <td><span class="badge badge-info">Semanal </span></td>
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
                            <input type="hidden" name="unidad_medida_venta_id" id="unidad_medida_venta_id" class="form-control" placeholder="U.M." readonly>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock">Stock </label>
                                    <input type="number" name="stock" id="cantidad" class="form-control" placeholder="Ingrese el stock del producto..." step="any ">
                                    <p class="text-left text-danger d-none" id="errorstock">Debe ingresar el stock</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button id="agregar_producto" class="btn btn-primary ">Agregar </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles del Inventario</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <th style="text-align: center;"> Editar </th>
                                    <th style="text-align: center;"> Eliminar </th>
                                    <th style="text-align: center;"> Insumo </th>
                                    <th style="text-align: center;"> UM </th>
                                    <th style="text-align: center;"> Stock </th>
                                    <th style="text-align: center;"> Costo </th>
                                    <th style="text-align: center;"> Subtotal </th>
                                </thead>
                                <tbody id="cuerpoTabla">
                                    <input type="hidden" name="inventario_id" id="inventario_id" value="{{$inventario->id}}">
                                    @foreach($inventario->detalle_inventarios as $index => $detalle )
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
                                        @if(isset($detalle->producto->unidad_medida_venta->nombre))
                                        <td style="text-align: center;">{{$detalle->producto->unidad_medida_venta->nombre}}</td>
                                        @else
                                        <td style="text-align: center;">S/U</td>
                                        @endif
                                        <td style="text-align: center;">
                                            <input type="number" class="form-control stock" id="stock-{{$detalle->id}}" style="text-align:center" value="{{$detalle->stock}}" step="any" readonly>
                                        </td>
                                        <td style="text-align: center;" class="precio" id="precio-{{$detalle->id}}"> {{$detalle->precio}}</td>
                                        <td style="text-align: center;" class="td_subtotal" id="subtotal-{{$detalle->id}}"> {{ number_format( $detalle->subtotal,2 ) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <td colspan="6" style="text-align: center;"> Total Inventario</td>
                                    <td colspan="1" style="text-align: center;" id="total_inventario">{{$inventario->total}}</td>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class=" text-center">
                            <button type="button" class="btn btn-primary" id="actualizar_inventario">Actualizar
                                Inventario</button>
                            <a href="{{ route('inventarios.index') }}" type="button" class="btn btn-danger" id="cancelar">Cancelar </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('scripts')
<script type="text/javascript" src="{{ URL::asset('assets/js/inventarios/edit.js') }}"></script>
<script>
    let ruta_actualizarInventario = "{{ route('inventarios.actualizarInventario') }}";
    let ruta_inventarios_index = "{{ route('inventarios.index') }}";
    let ruta_obtener_precio = "{{ route('inventarios.obtenerPrecios') }}";
    let ruta_producto_categoria = "{{ route('inventarios.obtenerProductosxId') }}";
</script>
@endsection
@section('page_css')
<link href="{{ asset('assets/css/inventarios/edit.css') }}" rel="stylesheet" type="text/css" />
@endsection
