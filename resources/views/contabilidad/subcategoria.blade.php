@extends('layouts.app', ['activePage' => 'proyecciones_ventas', 'titlePage' => 'proyecciones_ventas'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Agreagar Sub Categoria</h3>
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
                                <a id="btn-add" class="btn btn-info btn-twitter"> Agreagar </a>
                            </div>
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
                        <th style="text-align: center;">id</th>
                        <th style="text-align: center;">Nombre Sub Categoira</th>
                    </thead>
                    <tbody id="tbody">
                        @if ($subcategorias != null)
                        @foreach ($subcategorias as $subcategoria)
                        <tr>
                            <td style="text-align: center;">{{$subcategoria->id}}</td>
                            <td style="text-align: center;">{{$subcategoria->sub_categoria}}</td>
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
                <h4 class="modal-title" id="linkEditorModalLabel">Agregar Venta Real</h4>
            </div>
            <div class="modal-body">
                <form id="modalFormData" action="{{ route('subcategoria.createSubCategoria') }}  " method="POST" name="modalFormData" class="form-horizontal" novalidate="">
                    @csrf
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Nombre Sub Categoria</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="subcategoria" name="subcategoria" placeholder="" value="">
                        </div>
                    </div>
                    <div class="col-md-4" style="margin: 0 auto;">
                        <input class="form-control btn btn-primary" value="agregar" type="submit" id="agregar" name="agregar">
                    </div>
                </form>
            </div>
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
        }, ]
    });
</script>

@endsection