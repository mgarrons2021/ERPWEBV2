@extends('layouts.app', ['activePage' => 'contabilidad', 'titlePage' => 'Contabilidad'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Reporte de Compras y Pagos Por Proveedor</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Seleccione las Fechas</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x: hidden">
                            <form action="{{ route('contabilidad.filtrarComprasyPagos') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="input-daterange input-group" id="datepicker">
                                            <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                                            <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" />
                                            <span class="input-group-addon">A</span>
                                            <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control btn btn-primary" type="submit" value="Filtrar Compras y Pagos" id="filtrar" name="filtrar">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content: center;">
                        @php
                        $fecha_inicial_parseada = strtoupper( \Carbon\Carbon::parse($fecha_inicial)->locale('es')->isoFormat(' D MMMM'));
                        $fecha_final_parseada = strtoupper(\Carbon\Carbon::parse($fecha_final)->locale('es')->isoFormat(' D MMMM'));
                        @endphp
                        <h4> COMPRAS Y PAGOS DEL {{$fecha_inicial_parseada}} HASTA EL {{$fecha_final_parseada}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="table">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;" class="table-primary">PROVEEDORES</th>
                                        <th style="text-align: center;" class="table-primary">COMPRAS</th>
                                        <th style="text-align: center;" class="table-primary">PAGOS</th>
                                        <th style="text-align: center;" class="table-primary">DEUDAS</th>
                                        <th style="text-align: center;" class="table-primary">DETALLES</th>
                                    </tr>
                                </thead>
                                @php $totalPagos=0; $totalCompras=0; $totalPorPagar=0; @endphp
                                @foreach ($collection as $item )
                                @php
                                $MayusculasProveedor= strtoupper($item['nombre']);
                                $totalCompras+=$item['totalCompra'];
                                $totalPagos+=$item['totalPagado'];
                                $totalPorPagar+=$item['totalCompra']-$item['totalPagado'];
                                @endphp
                                <tr>
                                    <th style="text-align: center;" class="table-success">{{$MayusculasProveedor}}</th>
                                    @if ($item['totalCompra']!=null)
                                    <td style="text-align: center;">{{number_format($item['totalCompra'],3)}} Bs</td>
                                    @else
                                    <td style="text-align: center;">0.000 Bs</td>
                                    @endif

                                    @if ($item['totalPagado']!=null)
                                    <td style="text-align: center;">{{number_format($item['totalPagado'],3)}} Bs</td>
                                    @else
                                    <td style="text-align: center;">0.000 Bs</td>
                                    @endif


                                    <td style="text-align: center;">{{ number_format($item['totalCompra']-$item['totalPagado'],3) }} Bs</td>
                                    <td style="text-align: center;"><a href="{{ route('contabilidad.detalleComprasyPagos',[$item['id'],$fecha_inicial,$fecha_final])}}" class="btn btn-info btn-sm" target="_blank"> <i class="fa fa-eye"></i> </a></td>
                                </tr>
                                @endforeach
                                <tfoot> 
                                    <th style="text-align: center;" class="table-info">TOTALES</th>
                                    <th style="text-align: center;" class="table-danger">{{ number_format($totalCompras,3) }} Bs</th>
                                    <th style="text-align: center;" class="table-danger">{{ number_format($totalPagos,3)}} Bs</th>
                                    <th style="text-align: center;" class="table-danger">{{ number_format($totalPorPagar,3) }} Bs</th>
                                    <th style="text-align: center;" class="table-danger"></th>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
@if (session('registrado') == 'ok')
<script>
    iziToast.success({
        title: 'SUCCESS',
        message: "Registro agregado exitosamente",
        position: 'topRight',
    });
</script>
@endif



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
        columnDefs: [

        ]
    });
</script>
@endsection
@endsection