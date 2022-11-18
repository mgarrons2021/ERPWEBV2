@extends('layouts.app', ['activePage' => 'proyecciones_ventas', 'titlePage' => 'proyecciones_ventas'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Detalle Gasto</h3>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" style="width: 100%;" id="table">
                    <thead class="table-info">
                        <th style="text-align: center;">Id</th>
                        <th style="text-align: center;">Fecha</th>
                        <th style="text-align: center;">Egreso</th>
                        <th style="text-align: center;">Glosa</th>
                        <th style="text-align: center;">Tipo Comprobante</th>
                        <th style="text-align: center;">Nro Comprobante</th>
                    </thead>
                    <tbody id="tbody">
                        @foreach ($detalleGastosAdm as $detalle)
                        <tr>
                            <td style="text-align: center;">{{$detalle->id}}</td>
                            <td style="text-align: center;">{{$detalle->fecha}}</td>
                            <td style="text-align: center;">{{$detalle->egreso}}</td>
                            <td style="text-align: center;">{{$detalle->glosa}}</td>
                            <td style="text-align: center;">{{$detalle->tipo_comprobante}}</td>
                            <td style="text-align: center;">{{$detalle->nro_comprobante}}</td>
                        </tr>
                        @endforeach

                        {{-- @if ($subcategorias != null)
                        @foreach ($subcategorias as $subcategoria)
                        <tr>
                            <td style="text-align: center;">{{$subcategoria->id}}</td>
                            <td style="text-align: center;">{{$subcategoria->sub_categoria}}</td>
                        </tr>
                        @endforeach
                        @endif --}}
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
@endsection
@section('scripts')
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