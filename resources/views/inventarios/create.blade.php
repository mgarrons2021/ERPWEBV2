@extends('layouts.app', ['activePage' => 'inventarios', 'titlePage' => 'Inventarios'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nuevo Inventario</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="background-color: #6777ef;">
                        <h4 style="color:white;">Inventario: Nro {{$last_inventario}}. &nbsp;</h4>
                        <h4 style="text-align:right;color:white;">Fecha: {{$fecha_actual}}</h4>
                        <input type="hidden" id="idrol" value="{{\Illuminate\Support\Facades\Auth::user()->roles[0]->id}}">
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo_inventario">Seleccione el Tipo de Inventario</label>
                                    <select name="tipo_inventario" id="tipo_inventario" class="form-select">
                                        <option value='Seleccione un turno' selected>Seleccionar</option>
                                        <option value="D">Diario</option>
                                        <option value="S">Semanal</option>
                                    </select>
                                    <p class="text-left text-danger d-none" id="errorinventario">Debe seleccionar un tipo de inventario</p>
                                </div>
                            </div>

                            @role('Encargado')
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="turno">Seleccione el Turno</label>
                                    <select name="turno" id="turno" class="form-select">
                                        @foreach($turnos as $turno)
                                        <option value="{{$turno->id}}">{{$turno->turno}}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-left text-danger d-none" id="errorturno">Debe seleccionar un turno</p>
                                </div>
                            </div>
                            @endrole
                        </div>
                    </div>
                </div>
            </div>

            <!-- COPIAR -->

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="producto" id="tex">Seleccione el Producto</label>
                                    <select name="producto" id="producto" class="form-select select22" style="width: 100%;visibility:hidden">
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

                            <input type="hidden" name="unidad_medida_compra_id" id="unidad_medida_compra_id" class="form-control" placeholder="U.M." readonly>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock">Stock Actual</label>
                                    <input type="number" name="stock" id="stock" class="form-control" placeholder="Ingrese el stock del producto..." step="any ">
                                    <p class="text-left text-danger d-none" id="errorstock">Debe ingresar el stock</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button id="agregar_insumo" class="btn btn-primary">Agregar Insumo</button>
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
                                        <th style="text-align: center;">Stock</th>
                                        <th style="text-align: center;">Costo</th>
                                        <th style="text-align: center;">Sub Total</th>
                                        <th style="text-align: center;">Opciones</th>
                                    </thead>
                                    <tbody id="tbody">
                                        <?php $subtotal = 0; ?>
                                        @if (session('lista_inventario'))
                                        @foreach (session('lista_inventario') as $indice => $item)
                                        <tr>
                                            <td style="text-align: center;">
                                                {{ $item['producto_nombre'] }}
                                            </td>
                                            <td style="text-align: center;">{{ $item['unidad_medida_nombre'] }}</td>
                                            <td style="text-align: center;">{{ $item['stock'] }} </td>
                                            <td style="text-align: center;">{{ $item['costo'] }}</td>
                                            <td style="text-align: center;">{{ $item['subtotal'] }}</td>
                                            <?php $subtotal += $item['subtotal']; ?>
                                            <td style="text-align: center;">
                                                <button class="btn btn-danger" onclick="eliminar({{ $indice }});"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        <tr>
                                            <td colspan="1" style="text-align: center;">TOTAL INVENTARIO </td>
                                            <td colspan="4" style="text-align: center;">Bs.{{ number_format($subtotal,4) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class=" text-center">
                            <button type="button" class="btn btn-primary" id="registrar_inventario">Registrar
                                Inventario</button>
                            <a type="button" class="btn btn-danger" id="cancelar" href="{{ route('inventarios.index') }}">Cancelar </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>

</section>
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

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('assets/js/inventarios/create.js') }}"> </script>

<script>
    let ruta_obtenerinsumos = "{{ route('inventarios.obtenerInsumos') }}";
    let ruta_guardarDetalleInventario = "{{ route('inventarios.guardarDetalleInventario') }}";
    let ruta_eliminardetalle = "{{ route('inventarios.eliminarDetalle') }}";
    let ruta_registrarInventario = "{{ route('inventarios.registrarInventario') }}";
    let ruta_obtenerUM = "{{ route('inventarios.obtenerUM') }}";
    let ruta_inventarios_index = "{{ route('inventarios.index') }}";
</script>
<script>



</script>

@endsection