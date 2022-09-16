@extends('layouts.app', ['activePage' => 'cortes', 'titlePage' => 'Cortes'])

@section('content')
@section('css')
@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Cortes Registrados</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                      <h4>Seleccione la Fecha a Visualizar</h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive" style="overflow-x: hidden">
                        <form action="{{route('costos_cuadriles.filtrarCortes')}}" method="POST">
                          @csrf
                          <div class="row">
                            <div class="col-md-12">
          
                              <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                                <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" />
                                <span class="input-group-addon">A</span>
                                <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="" />
                              </div>
                            </div>
                 
                          </div>
                          <div class="card-footer">
                            <div class="col-md-4" style="margin: 0 auto;">
                              <input class="form-control btn btn-primary" type="submit" value="Filtrar" id="filtrar" name="filtrar">
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                    
                  </div>
                <div class="card">
                    <div class="card-body">

                        <a class="btn btn-outline-dark" href="{{route('costos_cuadriles.create')}}">Nuevo Corte</a><br><br>
                        <div class="table-responsive">

                            <table class="table table-bordered mt-15 " id="table">
                                <thead class="bg-info">
                                    <th class="text-center" style="color: #424242;">ID</th>
                                    <th class="text-center" style="color: #424242;">Funcionario</th>
                                    <th class="text-center" style="color: #424242;">Fecha</th>
                                    <th class="text-center" style="color: #424242;">Lomos Kilos</th>
                                    <th class="text-center" style="color: #424242;">Lomos Producidos</th>
                                    <th class="text-center" style="color: #424242;">Total Eliminado</th>
                                    <th class="text-center" style="color: #424242;">% Eliminado</th>
                                    <th class="text-center" style="color: #424242;">Total Recorte</th>
                                    <th class="text-center" style="color: #424242;">% Recortado</th>
                                    <th class="text-center" style="color: #424242;">Total Cuadriles</th>
                                    <th class="text-center" style="color: #424242;">Precio Unitario Cuadril</th>
                                    <th class="text-center" style="color: #424242;">% Rend. L/C</th>

                                </thead>
                                <tbody>
                                    @foreach ($costos_cuadriles as $costo_cuadril)
                                    <tr>
                                        @php
                                        $precio_lomo = 58;
                                        $peso_lomo = 0.250;
                                        $peso_promedio = $costo_cuadril->total_lomo/$peso_lomo;

                                        $porcentaje_rendimiento = ($costo_cuadril->total_unidad_cuadril/ $peso_promedio)*100;

                                        $costo_total_bruto = $costo_cuadril->total_lomo * $precio_lomo;
                                        $uso_lomo = $costo_cuadril->total_lomo - $costo_cuadril->total_recorte;
                                        $costo_neto = $uso_lomo * $precio_lomo;
                                        $precio_unitario = $costo_neto/ $costo_cuadril->total_unidad_cuadril;

                                        $porcentaje_eliminacion = ($costo_cuadril->total_eliminacion/$costo_cuadril->total_lomo)*100;
                                        $porcentaje_recortado = ($costo_cuadril->total_recorte/ $costo_cuadril->total_lomo)*100
                                        @endphp

                                        <td class="text-center">
                                            <a href="{{ route('costos_cuadriles.show', $costo_cuadril->id) }}" value=""> {{$costo_cuadril->id}} </a>
                                        </td>
                                        @if($costo_cuadril->nombre_usuario)
                                        <td class="text-center">{{$costo_cuadril->nombre_usuario}}</td>
                                        @else
                                        <td class="text-center">Sin Registro</td>

                                        @endif
                                        <td class="text-center">{{$costo_cuadril->fecha}}</td>
                                        <td class="text-center">{{number_format($costo_cuadril->peso_inicial,2) }} Kg</td>
                                        @if ($costo_cuadril->total_lomo)
                                        <td class="text-center">{{number_format($costo_cuadril->total_lomo,2) }} Kg</td>
                                        @else
                                        <td class="text-center">Sin registro</td>
                                        @endif
                                        <td class="text-center">{{$costo_cuadril->total_eliminacion}} Kg</td>
                                        <td class="text-center">{{number_format($porcentaje_eliminacion,2) }} %</td>
                                        <td class="text-center">{{$costo_cuadril->total_recorte}} Kg.</td>
                                        <td class="text-center">{{number_format($porcentaje_recortado,2) }} %</td>
                                        <td class="text-center">{{ number_format($costo_cuadril->total_unidad_cuadril,0) }} Und</td>

                                        <td class="text-center"> {{number_format($precio_unitario,2) }} Bs</td>
                                        <td class="text-center"> {{number_format($porcentaje_rendimiento,2) }} %</td>

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
            targets: 7
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