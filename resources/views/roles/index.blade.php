@extends('layouts.app', ['activePage' => 'roles', 'titlePage' => 'Roles'])

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Roles</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Roles Activos en el Sistema</h3>
                          
                                <a class="btn btn-info" href="{{route('roles.create')}}">Agregar nuevo Rol</a>
                           

                            <table class="table table-striped mt-2" id="table">
                                <thead style="background-color: #6777ef;">

                                    <th style="color: #fff;">ID</th>
                                    <th style="color: #fff;">Rol</th>
                                    <th style="color: #fff;">Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td >{{$role->id}}</td>
                                            <td >{{$role->name}}</td>

                                            <td>
                                           
                                                <a class="btn btn-warning" href="{{route('roles.edit',$role->id)}}">Editar</a>
                                       
                                             
                                                {!! Form::open(['method'=>'DELETE', 'route'=>['roles.destroy', $role->id],'style'=>'display:inline' ]) !!}
                                                {!! Form::submit('Borrar', ['class'=> 'btn btn-danger']) !!}
                                                {!! Form::close() !!}
                                      
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
    </section>
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
                {
                    orderable: false,
                    targets: 4
                }
            ]
        });
    </script>
@endsection

@endsection

