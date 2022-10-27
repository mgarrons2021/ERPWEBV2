@extends('layouts.app', ['activePage' => 'Traspasos', 'titlePage' => 'Traspasos'])

@section('content')

@section('css')
    #container {
        height: 400px;
        min-width: 310px;
    }
@endsection

<section class="section">
    <div class="section-header">
    <h3 class="page__heading">Vista detallada del Traspaso: {{$traspaso->id}} , {{$traspaso->sucursal_principal->nombre}}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <table class="table table-bordered table-striped ">
                        <tbody >
                        
                        <tr>
                            <th>Sucursal Nombre</th>
                                <td><span class="badge badge-primary">{{$traspaso->sucursal_principal->nombre }}</span></td>
                            </tr>

                            <tr>
                                <th>Funcionario</th>
                                <td>{{ $traspaso->user->name }}</td>
                            </tr>

                           
                            <tr>
                                <th>Sucursal Traspasado</th>
                                <td>{{ $traspaso->sucursal_secundaria->nombre }} </td>
                            </tr>
                            
                           
                            <tr>
                                <th>Fecha Traspaso</th>
                                <td>{{$traspaso->fecha}}</td>
                            </tr>
                        </tbody>
                    </table>
                   
                </div>
                <div>

                    <div class="col-lg-12">
                        
                        <div class="card">
                            <div class="card-header">
                                <h4>Detalle del Traspaso</h4>
                            </div>
                            <div class="card-body">
                               
                               
                                <table class="table table-hover" id="table">
                                    <thead class="table-hover table-info">
                                        
                                        <th style="text-align: center;"> Producto </th>
                                        <th style="text-align: center;"> UM </th>
                                        <th style="text-align: center;"> Cantidad </th>
                                        <th style="text-align: center;"> Sub Total </th>
                                        
                                        
                                    </thead>

                                    <tbody id="cuerpo">
                                        @foreach($traspaso->detalles_traspaso as $detalle)
                                        <tr>
                                           
                                            <td style="text-align: center;">{{ $detalle->producto->nombre }}</td>
                                            @if (isset($detalle->producto->unidad_medida_venta))
                                            <td style="text-align: center;">{{$detalle->producto->unidad_medida_venta->nombre}} </td>    
                                            @else
                                            <td style="text-align: center;">Sin UM</td>
                                            @endif
                                            
                                            <td style="text-align: center;">{{$detalle->cantidad}} </td>    
                                            <td style="text-align: center;">{{$detalle->subtotal}} </td>    
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                    
                                    </tfoot>
                                </table>
                            </div>


                        </div>

                        <div class="card">
                            <div id="container"></div>
                        </div>

                        <a class="btn btn-info" href="{{route('traspasos.index')}}" > VOLVER</a>

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