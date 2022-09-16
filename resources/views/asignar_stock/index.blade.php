@extends('layouts.app', ['activePage' => 'asignar_stock', 'titlePage' => 'asignar_stock'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Asignar Stock</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                    <a class="btn btn-primary" href="{{route('asignar_stock.create')}}">Asignar Stock </a><br><br>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table">
                                <thead style="background-color: #6777ef;">   
                                    <th style="color: #fff; text-align: center;">ID</th>
                                    <th style="color: #fff; text-align: center;">Fecha Asignación</th>
                                    <th style="color: #fff; text-align: center;"> Sucursal</th>
                                    <th style="color: #fff; text-align: center;"></th>
                                </thead>
                                <tbody>
                                    @foreach ($asignar_stockes as $asignar_stock)
                                
                                    <tr>
                                        
                                        <td style="text-align: center;">
                                            <a href="{{route('asignar_stock.show', $asignar_stock->id)}}" value="{{$asignar_stock->id}}">{{$asignar_stock->id}} </a>                                         
                                        </td>
                                        <td style="text-align: center;">{{$asignar_stock->fecha}}</td>
                                        <td style="text-align: center;">{{$asignar_stock->sucursal->nombre}}</td>
                                        
                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                @role('Super Admin')
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item " href="{{ route('asignar_stock.edit', $asignar_stock->id) }}">Editar</a></li>
                                                    <li>
                                                        <form action="{{route('asignar_stock.index',$asignar_stock->id)}}" id="formulario-eliminar2" class="formulario-eliminar" method="POST">
                                                            @csrf
                                                            @method('Delete')
                                                            <a class="dropdown-item" href="javascript:;" onclick="document.getElementById('formulario-eliminar2').submit()" id="enlace">Eliminar</a>
                                                        </form>
                                                    </li>
                                                </ul>
                                                @endrole
                                            </div>
                                        </td>
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
        columnDefs: [{
                orderable: false,
                targets: 3
            },
        ]
    });
</script>
@endsection
@endsection

