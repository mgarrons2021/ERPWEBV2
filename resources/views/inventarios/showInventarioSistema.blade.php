@extends('layouts.app', ['activePage' => 'inventarios', 'titlePage' => 'Inventarios'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Inventario Nro: {{ is_null($inventario)?'':$inventario->id }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-header">
                        <h4>Datos del Inventario</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tbody>
                                    <tr>
                                        <th>Fecha de inventario:</th>
                                        <td>{{ is_null($inventario)?'':$inventario->fecha }}</td>
                                    </tr>
                                    <tr>
                                        <th> Usuario:</th>
                                        <td>{{is_null($inventario)?'':$inventario->user->name}}</td>
                                    </tr>
                                    <tr>
                                        <th> Sucursal:</th>
                                        <td>{{is_null($inventario)?'': $inventario->sucursal->nombre  }}</td>
                                    </tr>
                                    <tr>
                                        <th> Tipo de Inventario:</th>
                                        @if( is_null($inventario)==false )
                                        @if ($inventario->tipo_inventario=="D")
                                        <td> <span class="badge badge-info"> Diario </span></td>
                                        @endif
                                        @if ($inventario->tipo_inventario=="S")
                                        <td><span class="badge badge-info">Semanal </span></td>
                                        @endif
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
                    <div class="card-header">
                        <h4>Detalles del Inventario</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="table">
                            <thead>
                                <th style="text-align: center;"> Insumo </th>
                                <th style="text-align: center;"> UM </th>
                                <th style="text-align: center;"> Stock </th>
                                <th style="text-align: center;"> Costo </th>
                                <th style="text-align: center;"> Subtotal </th>
                            </thead>
                            <tbody>
                                @if( is_null($inventario)==false )
                                @foreach($inventario->detalle_inventarios as $detalle)
                                <tr>
                                    @if(isset($detalle->producto->nombre))
                                    <td style="text-align: center;">{{$detalle->producto->nombre}}</td>
                                    <td style="text-align: center;">{{$detalle->producto->unidad_medida_compra->nombre}}</td>
                                    @endif
                                    @if(isset($detalle->plato->nombre))
                                    <td style="text-align: center;">{{$detalle->plato->nombre}}</td>
                                    <td style="text-align: center;">{{$detalle->plato->unidad_medida_compra->nombre}}</td>
                                    @endif
                                    <td style="text-align: center;"> {{$detalle->stock}}</td>
                                    <td style="text-align: center;"> {{ number_format($detalle->precio,2) }} Bs. </td>
                                    <td style="text-align: center;"> {{ number_format($detalle->subtotal,2) }} Bs. </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <td colspan="4" style="text-align: center;"> Total Inventario</td>
                                <td colspan="1" style="text-align: center;"> {{ is_null($inventario)?0:number_format($inventario->total,2) }} Bs. </td>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="button-container ">
            <a href="{{ route('inventarios.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
            <a href="" class="btn btn-info btn-twitter"> Editar </a>
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