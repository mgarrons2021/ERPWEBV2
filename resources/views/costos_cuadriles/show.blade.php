@extends('layouts.app', ['activePage' => 'costos_cuadriles', 'titlePage' => 'Costos_Cuadriles'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Registro Nro: {{ $costo_cuadril->id }} de Costos Cuadriles</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-header">
                        <h4> Totales &nbsp;- &nbsp;{{$fecha_actual}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive"></div>
                        <table class="table table-bordered table-md">
                            <tbody>
                                @php
                                $total_costo_total_lomo=58*$costo_cuadril->total_lomo;
                                $total_uso_lomo=$costo_cuadril->total_lomo-$costo_cuadril->total_recorte;
                                $total_costo_neto=$total_uso_lomo*58;
                                $total_precio_unitario_cuadril=$total_costo_neto/$costo_cuadril->total_unidad_cuadril;
                                @endphp
                                <tr>
                                    <th> Fecha:</th>
                                    <td>
                                        <div class="badge badge-pill badge-info">
                                            {{ $costo_cuadril->fecha }}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th> Total Lomo:</th>
                                    <td> {{ number_format($costo_cuadril->total_lomo,2) }} Kg</td>
                                </tr>
                                <tr>
                                    <th> Costo Total Lomo:</th>
                                    <td> {{ number_format($total_costo_total_lomo,2) }} Bs</td>
                                </tr>
                                <tr>
                                    <th> Uso del Lomo:</th>
                                    <td> {{ number_format($total_uso_lomo,2) }} Kg</td>
                                </tr>
                                <tr>
                                    <th>Costo Neto:</th>
                                    <td> {{ number_format($total_costo_neto,2) }} Bs</td>
                                </tr>
                                <tr>
                                    <th> P.U. Cuadril:</th>
                                    <td> {{ number_format($total_precio_unitario_cuadril,2) }} Bs</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles de los Totales &nbsp;- &nbsp; {{$fecha_actual}} </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="table">
                            <thead>
                                <th style="text-align: center;"> C. Lomo </th>
                                <th style="text-align: center;"> C. Eliminada </th>
                                <th style="text-align: center;"> C. Recortada </th>
                                <th style="text-align: center;"> C. Cuadril </th>
                                <th style="text-align: center;"> Costo Total Lomo </th>
                                <th style="text-align: center;"> Uso del Lomo </th>
                                <th style="text-align: center;"> Costo Neto </th>
                                <th style="text-align: center;"> P. U. Cuadril </th>
                            </thead>
                            <tbody> 
                                @foreach($costo_cuadril->detalles_costos_cuadriles as $detalle)
                                <tr>
                                    <td style="text-align: center;">{{number_format($detalle->cantidad_lomo,2)}} Kg.</td>
                                    <td style="text-align: center;">{{number_format($detalle->cantidad_eliminado,2)}} Kg.</td>
                                    <td style="text-align: center;">{{number_format($detalle->cantidad_recortado,2)}} Kg.</td>
                                    <td style="text-align: center;">{{number_format($detalle->cantidad_cuadril,0)}} Und</td>
                                    @php
                                    $costo_total_lomo=58*$detalle->cantidad_lomo;
                                    $uso_lomo=$detalle->cantidad_lomo-$detalle->cantidad_recortado;
                                    $costo_neto=$uso_lomo*58;
                                    $precio_unitario_cuadril=$costo_neto/$detalle->cantidad_cuadril;
                                    @endphp
                                    <td style="text-align: center;">{{number_format($costo_total_lomo,2) }} Bs</td>
                                    <td style="text-align: center;">{{number_format($uso_lomo,2)}} Kg</td>
                                    <td style="text-align: center;">{{ number_format($costo_neto,2)}} Bs</td>
                                    <td style="text-align: center;">{{ number_format($precio_unitario_cuadril,2) }} Bs</td>

                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>

                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>



        <div class="button-container ">
            <a href="{{ route('costos_cuadriles.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
            
        </div>

        <div>

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


    });
</script>

@endsection