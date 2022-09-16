@extends('layouts.app', ['activePage' => 'mano Obra', 'titlePage' => 'Mano Obra'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Reporte Mano Obra Donesco Srl.</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">
                        <a class="btn btn-outline-info" href="{{route('manos_obras.create')}}">Nuevo Registro</a><br><br>
                        <div class="table-responsive">
                            <table class="table table-bordered " id="table">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #fff;text-align:center">ID</th>
                                    <th style="color: #fff;text-align:center">Sucursal</th>
                                    <th style="color: #fff;text-align:center">Fecha</th>
                                    <th style="color: #fff;text-align:center">Ventas</th>
                                    <th style="color: #fff;text-align:center">Total Hrs</th>
                                    <th style="color: #fff;text-align:center">Costo</th>
                                    <th style="color: #fff;text-align:center">%MO</th>
                                    
                                    <th style="color: #fff;text-align:center"></th>
                                </thead>
                                <tbody>
                                    @foreach ($manos_obras as $mano_obra)
                                    <tr>
                                    <td style="text-align:center;">
                                        <a href="{{route('manos_obras.show', $mano_obra->id)}}" value="{{$mano_obra->id}}">{{$mano_obra->id}} </a>
                                    </td>
                                    @php 
                                    $mano_obra_porcentaje = $mano_obra->ventas / $mano_obra->total_costo
                                    @endphp 
                                        
                                        <td style="text-align:center;"> {{$mano_obra->sucursal->nombre}} </td>
                                        <td style="text-align:center;">{{$mano_obra->fecha}}</td>
                                        
                                        <td style="text-align:center;"> {{number_format($mano_obra->ventas) }} Bs</td>
                                        <td style="text-align:center;"> {{number_format($mano_obra->total_horas ) }}  Hrs</td>
                                        <td style="text-align:center;"> {{$mano_obra->total_costo}}  Bs</td>
                                        <td style="text-align:center;"> {{ number_format($mano_obra_porcentaje,2) }} %</td>



                                        
                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>

                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    {{-- <li><a class="dropdown-item " href="{{ route('menus_semanales.edit', $menu_semanal->id) }}">Editar</a></li> --}}
                                                    <li>
                                                        {{-- <form action="{{route('menus_semanales.destroy',$menu_semanal->id)}}" id="formulario-eliminar2" class="formulario-eliminar" method="POST">
                                                            @csrf
                                                            @method('Delete')
                                                            <a class="dropdown-item" href="javascript:;" onclick="document.getElementById('formulario-eliminar2').submit()" id="enlace">Eliminar</a>
                                                        </form> --}}
                                                    </li>
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
    </div>

</section>
@endsection
@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

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
            confirmButtonText: 'Si, Eliminar!',
            cancelButtonText: 'No, Cancelar!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                if (result.isConfirmed) {
                    let id = e.getAttribute('data-id');
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route('menus_semanales.destroy', '') }}/' + id,
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
                                    window.location = "tareas";
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
                orderable: false,
                targets: 3
            },

        ]
    });
</script>



@endsection