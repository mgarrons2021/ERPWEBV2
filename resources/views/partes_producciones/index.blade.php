@extends('layouts.app', ['activePage' => 'parte_produccion', 'titlePage' => 'parte_produccion'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Parte de Produccion Donesco Srl</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
            @role('Super Admin|Encargado')
                <div class="card-body">
                    <div class="table-responsive" style="overflow-x: hidden">
                        <form action="{{route('partes_producciones.filtrarpartes_producciones')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                <label for="datepicker">Seleccione las Fechas</label>
                                    <div class=" input-group" id="datepicker">
                                        <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                                        <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" />
                                        <span class="input-group-addon">A</span>
                                        <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="" />
                                        <input class="form-control btn btn-primary float-left" type="submit" value="Filtrar Parte de Produccion" id="filtrar" name="filtrar">
                                    </div>
                                </div>
                            </div>
                           
                        </form>
                    </div>
                </div>
                @endrole

                <div class="card">
                    <div class="card-body">
                    <a class="btn btn-primary" href="{{route('partes_producciones.create')}}">Nuevo Parte Produccion </a><br><br>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table">
                                <thead style="background-color: #6777ef;">   
                                    <th style="color: #fff; text-align: center;">ID</th>
                                    <th style="color: #fff; text-align: center;">Fecha</th>
                                    <th style="color: #fff; text-align: center;">Funcionario</th>
                                    <th style="color: #fff; text-align: center;">Sucursal Funcionario</th>
                                    <th style="color: #fff; text-align: center;">Total Parte Produccion</th>
                                    <th style="color: #fff; text-align: center;"></th>
                                </thead>
                                <tbody>
                                    @foreach ($partes_producciones as $parte_produccion)
                                    
                                
                                    <tr>
                                        
                                        <td style="text-align: center;">
                                            <a href="{{route('partes_producciones.show', $parte_produccion->id)}}" value="{{$parte_produccion->id}}">{{$parte_produccion->id}} </a>                                         
                                        </td>
                                        
                                        <td style="text-align: center;">{{$parte_produccion->created_at->format('d-m-Y')}}</td>
                                        <td style="text-align: center;">{{$parte_produccion->user->name}}</td>
                                        <td style="text-align: center;">{{$parte_produccion->sucursal_usuario->nombre}}</td>
                                        <td style="text-align: center;">{{$parte_produccion->total}} Bs</td>
                                        
                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                @role('Super Admin')
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item " href="{{ route('partes_producciones.edit', $parte_produccion->id) }}">Editar</a></li>
                                                    <li><a href="#" class="dropdown-item" data-id="{{ $parte_produccion->id }}" onclick="deleteItem(this)">Eliminar</a></li>
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

<script>
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    let ruta_eliminar_parte_produccion = "{{ route('partes_producciones.destroy','') }}";
    let ruta_index_parte_produccion = "{{ route('partes_producciones.index') }}";
    
</script>

<script>
    /*ELIMINAR UN PEDIDO*/
    function deleteItem(e) {
        let id = e.getAttribute("data-id");
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger",
            },
            buttonsStyling: true,
        });
        swalWithBootstrapButtons
            .fire({
                title: "Esta seguro de que desea eliminar este registro?",
                text: "Este cambio no se puede revertir!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Eliminar!",
                cancelButtonText: "No, Cancelar!",
                reverseButtons: true,
            })
            .then((result) => {
                if (result.value) {
                    if (result.isConfirmed) {
                        let id = e.getAttribute("data-id");
                        $.ajax({
                            type: "DELETE",
                            url: ruta_eliminar_parte_produccion + "/" + id,
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    "content"
                                ),
                            },
                            success: function(data) {
                                if (data.success) {
                                    swalWithBootstrapButtons
                                        .fire(
                                            "Eliminado!",
                                            "El registro ha sido eliminado.",
                                            "success"
                                        )
                                        .then(function() {
                                            window.location = ruta_parte_producciones;
                                        });
                                }
                            },
                        });
                    }
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                        "Cancelado",
                        "No se registro la eliminación",
                        "error"
                    );
                }
            });
    }
</script>



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
                targets: 5
            },
        ]
    });
</script>
@endsection
@endsection

