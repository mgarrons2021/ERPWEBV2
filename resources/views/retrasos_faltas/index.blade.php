@extends('layouts.app', ['activePage' => 'compras', 'titlePage' => 'Compras'])
@section('content')
@section('css')
@endsection
<meta name="csrf-token" content="{{ csrf_token() }}" />
<section class="section" >
    <div class="section-header">
        <h3 class="page__heading"> Registro de Retrasos y Faltas </h3>
    </div>
    <div class="section-body">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-primary" href="{{route('retrasosFaltas.create')}}">Nuevo Registro</a>
                    
                    <br><br>
             
                    <div class="table-responsive">
                        <table class="table table-striped mt-15 " id="table" style="width:100%">
                            <thead class="theadt">
                                <tr>
                                    <th style="color: #fff;" class="text-center"> # </th>
                                    <th style="color: #fff;" class="text-center">Funcionario</th>
                                    <th style="color: #fff;" class="text-center">Fecha</th>
                                    <th style="color: #fff;" class="text-center"> Hora</th>
                                    <th style="color: #fff;" class="text-center"> Tipo registro</th>
                                    <th style="color: #fff;" class="text-center">Descripcion</th>
                                    <th style="color: #fff;" class="text-center">Sucursal</th>
                                    <th style="color: #fff;" class="text-center">Justificativo</th>
                                    @role('Super Admin')
                                    <th style="color: #fff;" class="text-center">Estado registro</th>
                                    @endrole
                                    <th style="color: #fff;" class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $contador = 0; @endphp
                                @foreach ($retrasos_faltas_total as $retraso_falta)
                                @php $contador++;@endphp
                                <tr>
                                    <td class="text-center"> {{$contador}}</td>
                                    <td class="text-center">
                                        <a href="{{route('retrasosFaltas.show',$retraso_falta->id)}}">{{ $retraso_falta->user->name}} </a>
                                    </td>
                                    @php $fecha_formateada = date('d-m-Y', strtotime($retraso_falta->fecha)); @endphp
                                    <td class="text-center">{{$fecha_formateada}} </td>
                
                                    @if(isset($retraso_falta->hora))
                                    <td class="text-center">{{$retraso_falta->hora}} </td>
                                    @else
                                    <td class="text-center"> No aplica </td>
                                    @endif
                                    
                                    @if($retraso_falta->tipo_registro === 0)
                                    <td class="text-center"> Retraso </td>
                                    @else
                                    <td class="text-center"> Falta </td>
                                    @endif
                                    <td class="text-center">{{$retraso_falta->descripcion}} </td>
                                    <td class="text-center">
                                        {{$retraso_falta->sucursal->nombre }}
                                    </td>
                                    @if($retraso_falta->justificativo === 1)
                                    <td class="text-center">
                                        <div class="badge badge-pill badge-success "> Si</div>
                                    </td>
                                    @else
                                    <td class="text-center">
                                        <div class="badge badge-pill badge-danger "> No</div>
                                    </td>
                                    @endif
                                    @role('Super Admin')
                                        @if($retraso_falta->estado == 1)
                                            <td class="text-center"> <div class="badge badge-pill badge-warning "> Activo </div> </td>
                                        @else
                                            <td class="text-center"> <div class="badge badge-pill badge-warning "> Eliminado </div></td>
                                        @endif
                                    @endrole
                                   

                                    <td class="text-center">
                                        <div class="dropdown" style="position: absolute;">
                                            <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a href="#" class="dropdown-item"
                                                                data-id="{{ $retraso_falta->id }}"
                                                                onclick="deleteItem(this)">Eliminar</a></li>
                                            </ul>
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
<script></script>
</section>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<Script>
     
</Script>
<script type="application/javascript">
        function deleteItem(e) {
            let id = e.getAttribute('data-id');
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger',
                },
                buttonsStyling: true
            });
            swalWithBootstrapButtons.fire({
                title: 'Esta seguro de que desea eliminar este registro?',
                text: "Este cambio no se puede revertir!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, Eliminar!',
                cancelButtonText: 'No, Cancelar!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    if (result.isConfirmed) {
                        let id = e.getAttribute('data-id');
                        $.ajax({
                            type: 'DELETE',
                            url: '{{ route('retrasosFaltas.destroy', '') }}/' + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                if (data.success) {
                                    swalWithBootstrapButtons.fire(
                                        'Eliminado!',
                                        'El registro ha sido eliminado.',
                                        "success",
                                    ).then(function() {
                                        window.location = "retrasosFaltas";
                                    });
                                }
                            }
                        });

                    }
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelado',
                        'No se registro la eliminación',
                        'error'
                    );
                }
            });

        }
</script>

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
                searchable: false,
                orderable: false,
                targets: 0
                
            },
            {
                orderable: false,
                targets: 6
            },
            {
                orderable: false,
                targets: 7
            }
        ]
    });
</script>
@endsection
@section('page_css')
<style>
    .table {
        width: 100%;
    }
    .theadt{
        background: #6777EF;
    }
</style>
@endsection