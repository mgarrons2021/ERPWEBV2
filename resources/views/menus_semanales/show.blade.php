@extends('layouts.app', ['activePage' => 'pedidos', 'titlePage' => 'Pedido'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Menu Semanal del dia: {{ $menu_semanal->dia}}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Listado de Platos del Menu: {{$menu_semanal->dia}}</h4>
                        
                </div>
                
            </div>


        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Detalles del Menu</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="table">
                        <thead class="table-hover table-success">
                            
                            <th  style="text-align: center;"> Plato </th>
                            
                            <th style="text-align: center;"> Precio </th>
                            <th style="text-align: center;"> Estado </th>

                            

                        </thead>
                        <tbody>
                            @foreach($menu_semanal->detalle_menus_semanales as $detalle)
                            <tr>

                                <td style="text-align: center;">{{$detalle->plato->nombre}}</td>

                           
                                @if (isset($detalle->plato->platos_sucursales[0]->precio))
                                <td style="text-align: center;">{{$detalle->plato->platos_sucursales[0]->precio}}</td>
                                @else
                                <td style="text-align: center;"><span class="badge badge-warning">Sin Precio Asignado </span></td>
                                @endif
                               
                                @if ($detalle->plato->estado == 1)

                                <td style="text-align: center;"> <span class="badge badge-success">Activo</span></td>
                                @else
                                <td style="text-align: center;"><span class="badge badge-danger">  De baja </span></td>
                                @endif
                              
                             
                     

                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                           {{--  <td colspan="4" style="text-align: center;"> Total pedido</td>
                            <td colspan="1" style="text-align: center;"> {{$pedido->total_solicitado}} Bs. </td> --}}
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="button-container ">
            <a href="{{ route('menus_semanales.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>

        </div>

    </div>





    <div>

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
        columnDefs: [{
                orderable: false,
                targets: 3
            },
        ]
    });
</script>
@endsection