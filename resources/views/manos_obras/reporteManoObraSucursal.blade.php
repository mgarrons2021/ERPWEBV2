@extends('layouts.app', ['activePage' => 'productos_proveedores', 'titlePage' => 'Productos_Proveedores'])

@section('content')


<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Reporte Mano Obra Fecha: {{$fecha}}</h3>
    </div>
    <div class="section-body">
        <div class="row">
         
                <div class="card">
                    <div class="card-header">
                        <h4>Seleccione la Fecha a Visualizar</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x: hidden">
                            <form action="{{route('pedidos_producciones.reporteProduccionEnviada')}}" method="GET">

                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="input-daterange input-group" id="datepicker">
                                            <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                                            <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" />
                                            <span class="input-group-addon">A</span>
                                            <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="" />
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
                    <div class="card-header">
                        <h4>Reporte Mano Obra Por Sucursal: Donesco SRL </h4>
                    </div>
                    <div class="card-body">

                        <table class="table table-hover" id="table">
                            <thead class="table-hover table-info">

                                <th style="text-align: center;"> ID </th>
                                <th style="text-align: center;"> Nombre </th>
                                <th style="text-align: center;"> Estado </th>
                                <th style="text-align: center;"> Ver M-O </th>


                            </thead>

                            <tbody>
                            
                                @foreach($sucursales as $sucursal)
                                @if($sucursal->estado == 1)
                                <tr>
                                   
                                    <td style="text-align: center;">{{$sucursal->id}}</td>
                                    <td style="text-align: center;">{{$sucursal->nombre}} </td>
                                    @if($sucursal->estado == 1)
                                    <td style="text-align: center;"><span class="badge badge-success"> Sucursal Activa</span> </td>
                                    @endif
                                    

                                    <td style="text-align: center;"><a href="{{ route('manos_obras.detalle_mo_sucursal',[$sucursal->id])}}" class="btn btn-info btn-sm" target="_blank"> <i class="fa fa-eye"></i> </a></td>

                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                              
                                
                            </tfoot>

                        </table>
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

<script>
    $('#table1').DataTable({
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