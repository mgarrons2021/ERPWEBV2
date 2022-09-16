@extends('layouts.app', ['activePage' => 'pedidos', 'titlePage' => 'Pedido'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Mano Obra Donesco Srl.</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Mano Obra</h4>
                        {{-- <div class="col-xl-10 text-right">
                            <a href="{{ route('pedidos.download-pdf', $pedido->id) }}" class="btn btn-danger btn-sm">Exportar a PDF</a>
                    </div> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive"></div>
                    <table class="table table-bordered table-md">
                        <tbody>
                           

                            <tr>
                                <th>Fecha Registro:</th>
                                <td>{{$mano_obra->fecha }}</td>
                            </tr>
                           


                            <tr>
                                <th> Sucursal:</th>
                                <td>{{$mano_obra->sucursal->nombre}} Bs</td>
                            </tr>

                            <tr>
                                <th> Turno:</th>
                                @if(isset($mano_obra->user->turnos[0]->turno))
                                <td>{{$mano_obra->user->turnos[0]->turno}} </td>
                                @else
                                <td>Sin Turno</td>
                                @endif
                            </tr>
                            <tr>
                                <th> Total Ventas:</th>
                                <td>{{ $mano_obra->ventas }}</td>
                            </tr>
                        
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Mano Obra Detalle</h4>
                </div>
                <div class="card-body">
                    <table class="table table-hover" id="table">
                        <thead class="table-hover table-info">
                            <th style="text-align: center;"> Usuario </th>
                            
                            <th style="text-align: center;"> Horas Trabajadas </th>
                            <th style="text-align: center;"> Costo Horas </th>
                            
                 
                        </thead>
                        <tbody>
                            @foreach($mano_obra->detalle_manos_obras as $detalle)
                            <tr>

                                <td style="text-align: center;">{{$detalle->user->name}}</td>
                                <td style="text-align: center;">{{$detalle->cantidad_horas}} Hrs</td>
                                <td style="text-align: center;">{{$detalle->subtotal_costo}}</td>
                                
                                
                                
                                
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td colspan="1" style="text-align: center;">Total Horas Trabajadas</td>
                            <td colspan="1" style="text-align: center;"> {{$mano_obra->total_horas}} Hrs. </td>
                           
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="button-container ">
            <a href="{{ route('pedidos.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>

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