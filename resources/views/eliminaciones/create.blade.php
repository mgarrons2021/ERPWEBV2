@extends('layouts.app', ['activePage' => 'eliminaciones', 'titlePage' => 'Eliminaciones'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nueva Eliminacion</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="background-color: #6777ef;">
                        <h4 style="color:white;">Eliminacion: Nro {{$last_eliminacion}}. &nbsp;</h4>
                        <h4 style="text-align:right;color:white;">Fecha: {{$fecha_actual}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estado">¿ Eliminacion ?</label>
                                    <select name="estado" id="estado" class="form-select">
                                        <option value="" id="option_eliminacion">Selecionar...</option>
                                        <option value="Con Eliminacion">Con Eliminacion</option>
                                        <option value="Sin Eliminacion">Sin Eliminacion</option>
                                    </select>
                                    <p class="text-left text-danger d-none" id="erroreliminacion">Debe seleccionar una opcion de eliminacion</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="turno">Seleccione el Turno</label>
                                    <select name="turno" id="turno" class="form-select">
                                        <option value="" id="option_turno">Selecionar...</option>
                                        <option value="1">AM</option>
                                        <option value="2">PM</option>
                                    </select>
                                    <p class="text-left text-danger d-none" id="errorturno">Debe seleccionar un Turno</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="categoria_producto">Categoria Productos</label>
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
                                    <label for="producto">Seleccione el Producto</label>
                                    <div id="prod">
                                        <select name="producto" id="producto" class="form-select" style="width: 100%;">
                                            <option value="sin_seleccionar" id="sin_seleccionar">Seleccionar Producto</option>
                                            @foreach($categorias as $categoria)
                                            <optgroup label="{{Str::upper( $categoria->nombre)}}">
                                                @foreach($categoria->productos as $producto)
                                                <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                                @endforeach
                                            </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="proddd">
                                        <select name="producto_prod" id="producto_prod" class="form-select" style="width: 100%;">
                                            <option value="sin_seleccionar" id="sin_seleccionar">Seleccionar Producto</option>
                             
                                                @foreach($platos as $producto)
                                                <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                                @endforeach
            
                                        </select>
                                    </div>
                                    <p class="text-left text-danger d-none" id="errorproducto">Debe seleccionar un producto</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="observacion">Observacion</label>
                                    <input type="text" class="form-control" id="observacion" placeholder="Observacion...">
                                    <p class="text-left text-danger d-none" id="errorobservacion">Debe rellenar el campo observacion</p>
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
                                    <input type="hidden" name="unidad_medida" id="unidad_medida" class="form-control" step="any ">
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
                                    <button id="agregar" class="btn btn-primary ">Agregar</button>
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
                                        <th style="text-align: center;">Insumo</th>
                                        <th style="text-align: center;">U. M.</th>
                                        <th style="text-align: center;">Cantidad Eliminada</th>
                                        <th style="text-align: center;">Costo</th>
                                        <th style="text-align: center;">Sub Total</th>
                                        <th style="text-align: center;">Observacion</th>
                                        <th style="text-align: center;">Opciones</th>
                                    </thead>
                                    <tbody id="tbody">
                                        <?php $subtotal = 0; ?>
                                        @if (session('lista_eliminacion'))
                                        @foreach (session('lista_eliminacion') as $indice => $item)
                                        <tr>
                                            <td style="text-align: center;">{{ $item['producto_nombre'] }}</td>
                                            <td style="text-align: center;">{{ $item['unidad_medida'] }}</td>
                                            <td style="text-align: center;">{{ $item['cantidad'] }} </td>
                                            <td style="text-align: center;">{{ $item['precio'] }}</td>
                                            <td style="text-align: center;">{{ $item['subtotal'] }}</td>
                                            <td style="text-align: center;">{{ $item['observacion'] }}</td>
                                            <?php $subtotal += $item['subtotal']; ?>
                                            <td style="text-align: center;">
                                                <button class="btn btn-danger" onclick="eliminar({{ $indice }});"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        <tr>
                                            <td colspan="1" style="text-align: center;">TOTAL ELIMINACION </td>
                                            <td colspan="4" style="text-align: center;">Bs.{{ number_format($subtotal,4) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class=" text-center">
                            <button type="button" class="btn btn-primary" id="registrar_eliminacion">Registrar Eliminacion</button>
                            <a class="btn btn-danger" id="cancelar" href="{{route('eliminaciones.index')}}">Cancelar </a>
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
<script type="text/javascript" src="{{ URL::asset('assets/js/eliminaciones/create.js') }}"> </script>
<script>
    let ruta_obtenerDatosProducto = "{{ route('eliminaciones.obtenerDatosProducto') }}";
    let ruta_agregarDetalle = "{{ route('eliminaciones.agregarDetalle') }}";
    let ruta_eliminardetalle = "{{ route('eliminaciones.eliminarDetalle') }}";
    let ruta_registrarEliminacion = "{{ route('eliminaciones.registrarEliminacion') }}";
    let ruta_eliminaciones_index = "{{ route('eliminaciones.index') }}";
</script>
<script>

</script>
@endsection


@section('page_js')
<script>
    $('#table').DataTable({
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningun dato disponible en esta tabla",
            sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "Buscar:",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Ãšltimo",
                sNext: "Siguiente",
                sPrevious: "Anterior"
            },
            oAria: {
                sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                sSortDescending: ": Activar para ordenar la columna de manera descendente"
            }
        },
    });
</script>

@endsection

@section('page_css')
<style>
    .select2 {
        width: 100%;
    }
</style>
@endsection