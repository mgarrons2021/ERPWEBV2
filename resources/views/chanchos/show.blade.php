@extends('layouts.app', ['activePage' => 'chancho', 'titlePage' => 'Chancho'])

@section('content')

@section('css')
    #container {
        height: 400px;
        min-width: 310px;
    }
@endsection

<section class="section">
    <div class="section-header">
    <h3 class="page__heading">Vista detallada de Corte: Chancho: {{ $chancho->id }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <table class="table table-bordered table-striped ">
                        <tbody >
                        
                        @php 
                        $fecha_formateada = \Carbon\Carbon::parse($chancho->fecha)->format('m-d-Y');

                        @endphp
                        
                        <tr>
                            <th>Proveedor Nombre</th>
                                <td><span class="badge badge-primary">{{$producto_proveedor->proveedor->nombre }}</span></td>
                            </tr>

                            <tr>
                                <th>Producto Nombre</th>
                                <td>{{ $producto_proveedor->producto->nombre }}</td>
                            </tr>

                           
                            <tr>
                                <th>Precio Producto</th>
                                <td>{{ $producto_proveedor->precio }} Bs</td>
                            </tr>
                            
                           
                            <tr>
                                <th>Fecha Asignado</th>
                                <td>{{$fecha_formateada}}</td>
                            </tr>
                        </tbody>
                    </table>
                   
                </div>
                <div>

                    <div class="col-lg-12">
                        
                        <div class="card">
                            <div class="card-header">
                                <h4>Historial del Producto</h4>
                            </div>
                            <div class="card-body">
                                @php
                                    $json = json_encode($historial_productos);
                                @endphp
                                <input type="hidden" name="historial" id="historial" value="{{ $json }}">
                                <table class="table table-hover" id="table">
                                    <thead class="table-hover table-info">
                                        
                                        <th style="text-align: center;"> Fecha Cambio </th>
                                        <th style="text-align: center;"> Precio </th>
                                        
                                        
                                    </thead>

                                    <tbody id="cuerpo">
                                        @foreach($historial_productos as $historial)
                                        <tr>
                                             @php 
                                                $fecha_formateada = \Carbon\Carbon::parse($historial->fecha_compra)->format('m-d-Y');
                                             @endphp
                                            <td style="text-align: center;">{{  $fecha_formateada }}</td>
                                            <td style="text-align: center;">{{$historial->precio_compra}} Bs</td>    
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

                        <a class="btn btn-info" href="{{route('chanchos.index')}}" > VOLVER</a>

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