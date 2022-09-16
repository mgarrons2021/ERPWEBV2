@extends('layouts.app', ['activePage' => 'reciclajes', 'titlePage' => 'Reciclajes'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nuevo Reciclaje</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="background-color: #6777ef;">
                        <h4 style="color:white;">Reciclaje: Nro {{$ultimo_reciclaje}}. &nbsp;</h4>
                        <h4 style="text-align:right;color:white;">Fecha: {{$fecha_actual}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""> Tipo de registro </label>
                                    <select name="estado" id="estado" class="form-select">
                                        <option value=""> Seleccione </option>
                                        <option value="Con reciclaje">Reciclaje</option>
                                        <option value="Sin reciclaje">Sin Reciclaje</option>
                                    </select>
                                    <p class="text-left text-danger d-none" id="errorregistro">Debe seleccionar un tipo de registro</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="turno">Seleccione el Turno</label>
                                    <select name="turno" id="turno" class="form-select">
                                        <option value=""> Seleccione </option>
                                        <option value="1">AM</option>
                                        <option value="2">PM</option>
                                    </select>
                                    <p class="text-left text-danger d-none" id="errorturno">Debe seleccionar un turno</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="categoria_producto">Seleccione el tipo de Producto</label>
                                    <select name="categoria_producto" id="categoria_producto" class="form-select">
                                        <option value='Seleccione un turno' selected>Seleccionar</option>
                                        <option value="I">Insumos</option>
                                        <option value="P">Produccion</option>
                                    </select>
                                    <p class="text-left text-danger d-none" id="errorinventario">Debe seleccionar un tipo de inventario</p>
                                </div>
                            </div>
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
                                    <div id="prod">
                                        <label for="producto" id="tex">Seleccione el Producto</label>
                                        <select name="producto" id="producto" class="form-select " style="width: 100%;">
                                            <option value="">Seleccione Insumo</option>
                                            @foreach($categorias as $categoria)
                                            <optgroup label=" {{Str::upper( $categoria->nombre)}}" class="title-select">
                                                @foreach($categoria->productos as $producto)
                                                <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                                @endforeach
                                            </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="prodpp">
                                        <label for="producto_prod" id="tex">Seleccione el Producto</label>
                                        <select name="producto_prod" id="producto_prod" class="form-select " style="width: 100%;">
                                            <option value="">Seleccionar Produccion</option>
                                            @foreach($categorias_produccion as $categoria)
                                            <optgroup label="{{Str::upper( $categoria->nombre)}}">
                                                @foreach($categoria->platos as $producto)
                                                <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                                @endforeach
                                            </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p class="text-left text-danger d-none" id="errorproducto">Debe seleccionar un producto</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock_actual">Stock Actual</label>
                                    <input type="number" name="stock_actual" id="stock_actual" class="form-control" step="any " placeholder="Stock Actual" readonly>
                                    <p class="text-left text-danger d-none" id="errorstock">Debe seleccionar un producto para validar este campo </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad_eliminar">Cantidad a Reciclar</label>
                                    <input type="number" name="cantidad" id="cantidad" class="form-control" placeholder="Cantidad a Eliminar..." step="any ">
                                    <input type="hidden" name="precio" id="precio" class="form-control" step="any ">
                                    <input type="hidden" name="unidad_medida" id="unidad_medida" class="form-control" step="any ">
                                    <p class="text-left text-danger d-none" id="errorcantidad">Debe ingresar una cantidad</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="stock_nuevo">Nuevo Stock</label>
                                    <input type="number" name="stock_nuevo" id="stock_nuevo" class="form-control" placeholder="Stock Nuevo" step="any " readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="observacion">Observacion</label>
                                    <textarea class="form-control" id="observacion" rows="3" placeholder="Observacion..."></textarea>
                                    <p class="text-left text-danger d-none" id="errorobservacion">Debe ingresar la observacion </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button id="agregar_detalle" class="btn btn-primary ">Agregar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="width: 100%;" id="table">
                                    <thead>
                                        <th style="text-align: center;">Producto</th>
                                        <th style="text-align: center;">U. M.</th>
                                        <th style="text-align: center;">Cantidad</th>
                                        <th style="text-align: center;">Costo</th>
                                        <th style="text-align: center;">Sub Total</th>
                                        <th style="text-align: center;">Observacion</th>
                                        <th style="text-align: center;">Opciones</th>
                                    </thead>
                                    <tbody id="tbody">
                                        <?php $subtotal = 0; ?>
                                        @if (session('lista_reciclaje'))
                                        @foreach (session('lista_reciclaje') as $indice => $item)
                                        <tr>
                                            <td style="text-align: center;">{{ $item['producto_nombre'] }}</td>
                                            <td style="text-align: center;">{{ $item['unidad_medida'] }}</td>
                                            <td style="text-align: center;">{{ $item['cantidad'] }} </td>
                                            <td style="text-align: center;">{{ $item['precio'] }}</td>
                                            <td style="text-align: center;">{{ number_format( $item['subtotal'], 4) }}</td>
                                            <td style="text-align: center;">{{ $item['observacion'] }}</td>
                                            <?php $subtotal += $item['subtotal']; ?>
                                            <td style="text-align: center;">
                                                <button class="btn btn-danger" onclick="eliminar({{ $indice }});"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        <tr>
                                            <td colspan="1" style="text-align: center;">TOTAL RECICLAJE </td>
                                            <td colspan="4" style="text-align: center;">Bs.{{ number_format($subtotal,4) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class=" text-center">
                            <button type="button" class="btn btn-primary" id="registrar_reciclaje">Registrar
                                Reciclaje</button>
                            <a href="{{ route('reciclajes.index') }}" class="btn btn-danger"> Cancelar </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>

</section>
@endsection
@section('scripts')

<script type="text/javascript" src="{{ URL::asset('assets/js/reciclajes/create.js') }}"></script>

<script>
    ruta_obtenerDatosProducto = "{{ route('reciclajes.obtenerDatosProducto') }}";
    let ruta_agregarDetalle = "{{ route('reciclajes.agregarDetalle') }}";
    let ruta_eliminardetalle = "{{ route('reciclajes.eliminarDetalle') }}";
    let ruta_registrarReciclaje = "{{ route('reciclajes.registrarReciclaje') }}";
    let ruta_reciclajes_index = "{{ route('reciclajes.index') }}"
</script>
@endsection
@section('page_css')
<style>
    .select2 {
        width: 100%;
    }

    /*     .multiple-task[size] {
        height: auto !important;
        max-height: 156px !important;
    }

    .sample {
        color: #F00;
    } */
</style>
@endsection