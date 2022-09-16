@extends('layouts.app', ['activePage' => 'pedidos', 'titlePage' => 'Pedido'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Stock Ideal de la Sucursal: {{ $asignar_stock->Sucursal->nombre }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalle del Stock</h4>
                      
                </div>
                <div class="card-body">
                    <div class="table-responsive"></div>
                    <table class="table table-bordered table-md">
                        <tbody>
                            <tr>
                                <th>Fecha Asignacion:</th>
                                <td>{{ $asignar_stock->fecha }}</td>
                            </tr>
                            <tr>
                                <th>Sucursal:</th>
                                <td>{{ $asignar_stock->sucursal->nombre }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Informacion detallada:</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover" id="table">
                            <thead class="table-hover table-info">
                                <th style="text-align: center;"> Producto </th>
                                
                                <th style="text-align: center;"> Cantidad </th>
                                <th style="text-align: center;"> Precio </th>
                                
                           
                            </thead>
                            <tbody>
                                @foreach($asignar_stock->detalle_asignar_stock as $detalle)
                                <tr>
                                    <td style="text-align: center;">{{$detalle->producto->nombre}}</td>
                                    <td style="text-align: center;">{{$detalle->cantidad}}</td>
                                    <td style="text-align: center;">{{$detalle->producto->productos_proveedores[0]->precio}} Bs</td>                                    
                                </tr>
                                @endforeach
                            </tbody>
                   
                        </table>
                    </div>
                </div>
            </div>

        </div>
   
        <div class="button-container ">
            <a href="{{ route('asignar_stock.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>

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
    });
</script>
@endsection