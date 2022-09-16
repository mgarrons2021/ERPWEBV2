@extends('layouts.app', ['activePage' => 'reporte_seguimiento', 'titlePage' => 'Reportes'])

@section('content')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
@endsection

<section class="section">

    <div class="section-header">
        <h1 class="text-center">Reporte de Seguimiento de Actividades </h1>
    </div>
    <form action="{{ route('personales.reporteSeguimientoActividades') }}" method="POST">
    <div class="card-body">
      
      <div class="col-lg-12">
        <div class="row justify-content-center">
            <h5 class="text-light">Filtrado de fechas :</h5>
            
              @csrf 
              <div class="col-lg-6">
                  <div class="form-group">
                      <label for="desde" class="text-light" >Desde</label>
                      <input type="date" name="desde" class="form-control" id="desde" required>
                  </div>                  
              </div>
              <div class="col-lg-6">
                  <div class="form-group">
                      <label for="hasta" class="text-light">Hasta</label>                  
                      <input type="date"  name="hasta" class="form-control" id="hasta" required>                  
                  </div>
              </div>   
                
        </div>    
        <div class="col-lg-6">
              <button type="sumbit" class="btn btn-info" id="filtrar">Filtrar</button>
        </div>
      </div> 
     
    </div>
       
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="table-responsive "> 
                            <table  id="table" class="table table-striped">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #fff;" class="text-center">C I</th>
                                    <th style="color: #fff;" class="text-center">Nombre y Apellido</th>                                    
                                    <th style="color: #fff;" class="text-center">Estado del Personal</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td class="text-center">
                                            {{ $usuario->ci }} 
                                        </td>

                                        <td class="text-center">{{ $usuario->name }} {{ $usuario->apellido }}</td>

                                        
                                        @if ($usuario->estado == 1)
                                        <td class="text-center">
                                            <div class="badge badge-success">Activo</div>
                                        </td>
                                        @endif
                                        @if ($usuario->estado == 0)
                                        <td class="text-center">
                                            <div class="badge badge-danger">Inactivo</div>
                                        </td>
                                        @endif
                                        <td class="text-center">                                            
                                                <input type="radio" class="form-check-input" name="idusuario" value="{{$usuario->id}}" required/>                                            
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

    </form>   

    <div class="col-lg-12">
        
    </div>

</section>
@endsection
@section('scripts')

<script>    
    let ruta_actividades = "{{ route('personales.reporteSeguimientoActividades') }}";
</script>

<script type="text/javascript" src="{{ URL::asset('assets/js/reportes/index.js') }}"></script>

<script>
$('#table').DataTable({

language: {
    sProcessing: "Procesando...",
    sLengthMenu: "Mostrar _PERSONAL_ registros",
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
columnDefs: [
    {
        orderable: false,
        targets: 2
    }
]
});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
@endsection







