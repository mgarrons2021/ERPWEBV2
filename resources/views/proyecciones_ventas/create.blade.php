@extends('layouts.app', ['activePage' => 'proyecciones_ventas', 'titlePage' => 'proyecciones_ventas'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Agreagar Proyeccion</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="button-container col-md-1">
                                <a  id="btn-add" class="btn btn-info btn-twitter"> Agreagar </a>
                            </div>
                            <div class="button-container col-md-1">
                                <a href="{{ route('proyecciones_ventas.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
                            </div>
                            <input type="hidden" id="um" name="um" class="form-control" value="">
                            <input type="hidden" id="producto_nombre" name="producto_nombre" class="form-control" value="">
                            <input type="hidden" id="precio" name="precio" class="form-control" value="" placeholder="Bs" readonly>
                            <input type="hidden" id="subtotal_solicitado" name="subtotal_solicitado" class="form-control" value="" placeholder="Bs" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" style="width: 100%;" id="table">
                    <thead class="table-info">
                        <th style="text-align: center;">Fecha</th>
                        <th style="text-align: center;">Proyeccion AM</th>
                        <th style="text-align: center;">Proyeccion PM</th>
                        <th style="text-align: center;">Total Dia</th>
                    </thead>
                    <tbody id="tbody">
                        @if ($detalleProyeccionesVentas != null)
                        @foreach ($detalleProyeccionesVentas as $detalle)
                        <tr>
                            <td style="text-align: center;">{{$detalle->fecha_proyeccion}}</td>
                            <td style="text-align: center;">{{$detalle->venta_proyeccion_am}}</td>
                            <td style="text-align: center;">{{$detalle->venta_proyeccion_pm}}</td>
                            <td style="text-align: center;">{{$detalle->venta_proyeccion_subtotal}}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            {{-- <td colspan="6" style="text-align: center;" class="table-info" id="total_pedido">Total: {{ number_format($total,3) }} Bs</td> --}}
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="card-footer">

        </div>
    </div>
</section>
<div class="modal fade" id="linkEditorModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="linkEditorModalLabel">Agregar Proyeccion</h4>
            </div>
            <div class="modal-body">
                <form id="modalFormData" action="{{ route('proyecciones_ventas.agregarNuevaProyeccion') }}  " method="POST" name="modalFormData" class="form-horizontal" novalidate="">
                    @csrf
                    <div hidden class="form-group">
                        <div class="col-sm-10">
                            <input type="text" id="id" class="input-sm form-control" name="id" value="{{$id}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputLink" class="col-sm-2 control-label">Fecha</label>
                        <div class="col-sm-10">
                            <input type="date" id="fecha" class="input-sm form-control" name="fecha" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputLink" class="col-sm-2 control-label">Proyeccion AM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="am" name="proyeccion_am" placeholder="Enter URL" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Proyeccion PM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pm" name="proyeccion_pm" placeholder="Enter Link Description" value="">
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-md-4" style="margin: 0 auto;">
                            <input class="form-control btn btn-primary" value="agregar" type="submit" id="agregar" name="agregar">
                        </div>
                        {{-- <a href="{{ route('reportes.ventas_por_sucursalId') }}">Consultar</a> --}}
                    </div>
                </form>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes
                </button>
                <input type="hidden" id="link_id" name="link_id" value="0">
            </div> --}}
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
    jQuery(document).ready(function($) {
        ////----- Open the modal to CREATE a link -----////
        jQuery('#btn-add').click(function() {
            jQuery('#btn-save').val("add");
            jQuery('#modalFormData').trigger("reset");
            jQuery('#linkEditorModal').modal('show');
        });
    })
</script>
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
        columnDefs: [{
                orderable: false,
                targets: 3
            },
        ]
    });
</script>

@endsection