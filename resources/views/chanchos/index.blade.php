@extends('layouts.app', ['activePage' => 'chanchos', 'titlePage' => 'Chanchos'])



@section('content')
@section('css')
@endsection
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="section">
    <div class="section-header">
        <h3 class="page__heading"> Control Chanchos Registrados</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <a class="btn btn-outline-info" href="{{route('chanchos.create')}}">Nuevo Control</a><br><br>
                        <div class="table-responsive">

                            <table class="table table-striped mt-15 " id="table">
                                <thead style="background-color: #6777ef;">
                                    <!---->
                                    <!--<th style="display:none;">ID</th>-->
                                    <th class="text-center" style="color: #fff;">Fecha Corte</th>
                                    <th class="text-center" style="color: #fff;">Personal Encargado</th>
                                    <th class="text-center" style="color: #fff;">Costilla en Kilos</th>
                                    <th class="text-center" style="color: #fff;">Costilla Marinado</th>
                                    <th class="text-center" style="color: #fff;">Costilla Horneado</th>
                                    <th class="text-center" style="color: #fff;">Costilla Cortado</th>

                                    <th class="text-center" style="color: #fff;">Pierna en Kilos</th>
                                    <th class="text-center" style="color: #fff;">Pierna Marinado</th>
                                    <th class="text-center" style="color: #fff;">Pierna Horneado</th>
                                    <th class="text-center" style="color: #fff;">Pierna Cortado</th>

                                    <th class="text-center" style="color: #fff;">Total Chancho Enviado</th>
                                    
                                    <th class="text-center" style="color: #fff;"></th>

                                </thead>
                                <tbody>
                                    @foreach ($chanchos as $chancho)
                                    <tr>
                                      {{--   <td  class="text-center">
                                            <a href="{{route('chanchos.show', $chancho->id)}}">{{$chancho->id}} </a>
                                        </td> --}}
                                        <td  class="text-center">{{$chancho->fecha}}</td>
                                        <td  class="text-center">{{$chancho->usuario}}</td>
                                        <td  class="text-center">{{$chancho->costilla_kilos}}</td>
                                        <td  class="text-center">{{$chancho->costilla_marinado}}</td>
                                        <td  class="text-center">{{$chancho->costilla_horneado}}</td>
                                        <td  class="text-center">{{$chancho->costilla_cortado}}</td>

                                        <td  class="text-center">{{$chancho->pierna_kilos}}</td>
                                        <td  class="text-center">{{$chancho->pierna_marinado}}</td>
                                        <td  class="text-center">{{$chancho->pierna_horneado}}</td>
                                        <td  class="text-center">{{$chancho->pierna_cortada}}</td>
                                        <td  class="text-center">{{$chancho->chancho_enviado}}</td>
                                       

                                        

                                        
                                        <td  class="text-center">
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item" href="{{ route('chanchos.edit', $chancho->id) }}">Editar</a></li>
                                                    <li><a href="#" class="dropdown-item" data-id="{{ $chancho->id }}" onclick="deleteItem(this)">Eliminar</a></li>
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
@if (session('registrado') == 'ok')
<script>
    iziToast.success({
        title: 'SUCCESS',
        message: "Registro agregado exitosamente",
        position: 'topRight',
    });
</script>
@endif

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
                        url: '{{ route('chanchos.destroy', '') }}/' + id,
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
                                    window.location = "productos";
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
    let
        $('.formulario-eliminar2').submit(function(e) {
            console.log()
            e.preventDefault();
            Swal.fire({
                title: 'Estas Seguro(a)?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, Eliminarlo!'
            }).then((result) => {
                if (result.value) {
                    this.submit();
                }
            })
        });
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
            targets: 6
        }]
    });
</script>


@endsection
@endsection
@section('css')

.tablecolor {
background-color: #212121;
}

@endsection