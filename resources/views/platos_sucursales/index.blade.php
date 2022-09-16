@extends('layouts.app', ['activePage' => 'plato_sucursal', 'titlePage' => 'Plato Sucursal'])

@section('content')
@section('css')
@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Platos Asignados</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="card">
                <div class="card-header">
                  <h4>Seleccione la Sucursal a Filtrar</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive" style="overflow-x: hidden">
                    <form action="{{route('platos_sucursales.filtrarPlatos')}}" method="POST">
                      @csrf
                      <div class="row">
                
                        <div class="col-md-8">
                          <div class="input-group">
                            <span class="input-group-addon "><strong>Sucursal::</strong> </span>
                            <select name="sucursal_id" id="sucursal_id" class="form-control selectric">
                              @foreach($sucursales as $sucursal)
                              <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                              @endforeach
                              <option value="0">Todas las Sucursales</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4" style="margin: 0 auto;">
                          <input  class="form-control btn btn-secondary" type="submit" value="Filtrar" id="filtrar" name="filtrar">
                        </div>
                    </div>
                    <div class="card-footer">
                      </div>
                    </form>
                  </div>
                </div>
                
              </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        
                        <a class="btn btn-outline-dark" href="{{route('platos_sucursales.create')}}">Asignar Plato!</a><br><br>
                        <div class="table-responsive">

                            <table class="table table-bordered mt-15 " id="table">
                                <thead class="bg-info">
                                    <!---->
                                
                                    <th class="text-center" style="color: #424242;">Categoria Plato</th>
                                    <th class="text-center" style="color: #424242;">Plato</th>
                                    <th class="text-center" style="color: #424242;">Sucursal Asignado</th>
                                    <th class="text-center" style="color: #424242;">Precio</th>
                                    <th class="text-center" style="color: #424242;">Precio Delivery</th>
                                          
                                    <th style="color: #fff;"></th>
  
                                </thead>
                                <tbody>
                                    @foreach ($platos_sucursales as $plato_sucursal)
                                    <tr>  
                                    
                                        <td class="text-center" >{{$plato_sucursal->categoria_plato->nombre}}</td>
                                        <td class="text-center">{{$plato_sucursal->plato->nombre}}</td>
                                        <td class="text-center">{{$plato_sucursal->sucursal->nombre}}</td>
                                        <td class="text-center">{{$plato_sucursal->precio}} Bs.</td>
                                        <td class="text-center" >{{$plato_sucursal->precio_delivery}} Bs</td>
                                        
                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li>
                                                        <a class="dropdown-item " href="{{ route('platos_sucursales.edit', $plato_sucursal->id) }}">Editar Plato</a>
                                                    </li>
                                                    
                                                    <li>
                                                        <form action="{{route('platos_sucursales.destroy',$plato_sucursal->id)}}" id="formulario-eliminar2" class="formulario-eliminar" method="POST">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

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
                targets: 5
            },
            
        ]
    });
</script>
@endsection
@endsection
@section('css')

    .tablecolor {
        background-color: #212121;
    }

@endsection