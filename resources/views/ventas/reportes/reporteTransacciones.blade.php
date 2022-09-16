@extends('layouts.app', ['activePage' => 'formulario', 'titlePage' => 'Formulario'])

@section('content')
@section('css')
@endsection

<section class="section">

    <div class="section-header">
        <h3 class="page__heading">Reporte de Transacciones Por Hora </h3>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x: hidden">
                            <form action="{{route('autorizacion.reporteTransacciones')}}" method="GET">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-daterange input-group" id="datepicker">
                                            <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                                            <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicio" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-daterange input-group" id="datepicker">
                                            <span class="input-group-addon "><strong>A:</strong> </span>
                                            <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_fin" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon "><strong>Sucursal::</strong> </span>
                                            <select name="sucursal_id" id="sucursal_id" class="form-control selectric">
                                                @foreach($sucursales as $sucursal)
                                                <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                                                @endforeach
                                                <option value="0">Todas las Sucursales</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <div class="col-md-4" style="margin: 0 auto;">
                                        <input class="form-control btn btn-primary" type="submit" value="Filtrar" id="filtrar" name="filtrar">
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
                       <h4>{{$sucursal_nombre}} - Turno AM</h4> 
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table  class="table table-bordered  table-striped " id="table">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #fff;text-align: center;">Turno AM</th>
                                    @foreach($fechas as $fecha)
                                    <th style="color: #fff;text-align: center;">{{$fecha}}</th>
                                    @endforeach 
                                    <th style="color: #fff;text-align: center;">Total x Horas</th>

                                </thead>
                                <tbody>
                                        @php
                                        $sw=false;
                                        @endphp
                                        @foreach($collectionTransacciones_AM as $item)
                                        <tr>
                                            <td style="text-align: center;">{{$item['rango_horas']}}</td>
                                            @foreach($fechas as $fecha)
                                                @foreach($item['transacciones_x_fecha'] as $transaccion)
                                                    @if($fecha == $transaccion['fecha_venta'])
                                                        @php
                                                        $sw=true;
                                                        @endphp
                                                        <td style="text-align: center;">{{$transaccion['TotalTransacciones']}}</td>
                                                    @endif
                                                @endforeach
                                                @if($sw==false)
                                                <td style="text-align: center;">0</td>
                                                @endif
                                                @php
                                                $sw=false;
                                                @endphp
                                            @endforeach
                                            <td style="text-align: center;" class="table-info ">{{ $item['transacciones_x_fecha'][sizeof($item['transacciones_x_fecha'])-1]['TotalTransacciones']}}</td> 
                                           
                                            
                                        </tr>
                                        @endforeach
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                <div class="card-header" style="justify-content: center;">
                       <h4>{{$sucursal_nombre}} - Turno PM</h4> 
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table  class="table table-bordered table-striped " id="table2">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #fff;text-align: center;">Turno PM</th>
                                    @foreach($fechas as $fecha)
                                    <th style="color: #fff;text-align: center;">{{$fecha}}</th>
                                    @endforeach
                                    <th style="color: #fff;text-align: center;">Total x Horas</th>
                                </thead>
                                <tbody>
                                        @php
                                        $sw=false;
                                        @endphp
                                        @foreach($collectionTransacciones_PM as $item)
                                        <tr>
                                            <td style="text-align: center;">{{$item['rango_horas']}}</td>
                                            @foreach($fechas as $fecha)
                                                @foreach($item['transacciones_x_fecha'] as $transaccion)
                                                    @if($fecha == $transaccion['fecha_venta'])
                                                        @php
                                                        $sw=true;
                                                        @endphp
                                                        <td style="text-align: center;">{{$transaccion['TotalTransacciones']}}</td>
                                                    @endif
                                                @endforeach
                                                @if($sw==false)
                                                <td style="text-align: center;">0</td>
                                                @endif
                                                @php
                                                $sw=false;
                                                @endphp
                                            @endforeach 
                                            <td style="text-align: center;" class="table-info ">{{ $item['transacciones_x_fecha'][sizeof($item['transacciones_x_fecha'])-1]['TotalTransacciones']}}</td> 
    

                                        </tr>
                                        @endforeach
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('scripts')
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.bootstrap4.min.js"></script>

<script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

@endsection

@section('page_js')

<script>
    $(document).ready(function() {
        $('#table').DataTable({
            language: {
                sProcessing: "Procesando...",
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
    })
    $(document).ready(function() {
        $('#table2').DataTable({
            language: {
                sProcessing: "Procesando...",
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
    })
</script>

@endsection

@section('css')
.titulo{
font-size: 50px;
background-color: red;
}

@endsection
@section('page_css')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.3.1/css/buttons.bootstrap4.min.css" />
@endsection