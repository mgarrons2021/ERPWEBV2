@extends('layouts.app', ['activePage' => 'sucursales', 'titlePage' => 'sucursales'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Sucursales</h3>

    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">
                        <a class="btn btn-outline-info" href="{{route('sucursales.create')}}">Nueva Sucursal</a><br><br>
                        <div class="table-responsive">
                            <table class="table table-striped mt-15" id="table">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #fff;">Nombre</th>
                                    <th style="color: #fff;">Direccion</th>
                                    <!--<th style="color: #fff;">Correo</th>-->
                                    <th style="color: #fff;">Numero Fiscal</th>
                                    <th style="color: #fff;">Estado</th>
                                    <th style="color: #fff;"></th>


                                    <!-- <th style="color: #fff;">Acciones</th> -->
                                </thead>
                                <tbody>
                                    @foreach ($sucursales as $sucursal)
                                    <tr>
                                        <td>
                                            <!--<p class="titulo"> dasd</p>-->
                                            <a href="{{route('sucursales.show', $sucursal->id)}}" value="{{$sucursal->nombre}}">{{$sucursal->nombre}} </a>
                                        </td>
                                        <td>{{$sucursal->direccion}}</td>
                                        <!--<td>{{$sucursal->correo}}</td>-->
                                        <td>{{$sucursal->nro_fiscal}}</td>

                                        <td>
                                            @if($sucursal->estado==1)
                                            <div class="badge badge-pill badge-success">Activo</div>
                                            @endif
                                            @if($sucursal->estado==0)
                                            <div class="badge badge-pill badge-danger">Inactivo</div>
                                            @endif
                                        </td>
                                        <!--<td>
 
                                        </div>

                                            <form action="{{route('sucursales.destroy',$sucursal->id)}}" id="formulario-eliminar" class="formulario-eliminar" method="POST">
                                                @csrf
                                                @method('Delete')
                                                <button type="submit" class="btn btn-danger  mr-3" id="">Borrar</button>

                                                <a href="{{route('sucursales.show', $sucursal->id)}}" class="btn btn-info">Mostrar </a>
                                            </form>
                                        </td>-->
                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item " href="{{ route('sucursales.edit', $sucursal->id) }}">Editar</a></li>
                                                    <li>
                                                        <form action="{{route('sucursales.destroy',$sucursal->id)}}" id="formulario-eliminar2" class="formulario-eliminar" method="POST">
                                                            @csrf
                                                            @method('Delete')
                                                            <a class="dropdown-item" href="javascript:;" onclick="document.getElementById('formulario-eliminar2').submit()" id="enlace">Eliminar</a>
                                                        </form>
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
@if(session('eliminar')=='ok')
<script>
    Swal.fire(
        'Eliminado!',
        'Tu registro ha sido eliminado.',
        'success'
    )
</script>
@endif
<script>
    $('.formulario-eliminar').submit(function(e) {
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
                /*  Swal.fire(
                     'Deleted!',
                     'Your file has been deleted.',
                     'success'
                 ) */
                console.log(this);
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

@section('css')
.titulo{
font-size: 50px;
background-color: red;

}
@endsection