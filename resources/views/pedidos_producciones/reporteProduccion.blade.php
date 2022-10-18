@extends('layouts.app', ['activePage' => 'zumos', 'titlePage' => 'Zumos'])

@section('content')

@section('css')

@endsection


<section class="section">
  <div class="section-header">

    <h3 class="page__heading">Reporte Solicitud de Produccion a CDP </h3>

  </div>
  <div class="section-body">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4>Seleccione la Fecha a Filtrar</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive" style="overflow-x: hidden">
              <form action="{{ route('pedidos_producciones.filtrarReporte')}}" method="POST">
                @csrf
                <div class="row">
                  <div class="col-md-12">
                    <div class="input-daterange input-group" id="datepicker">
                      <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                      <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" />
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
      </div>
      <div class="card">
        <div class="card-header" style="justify-content:center ;">
          <h4> SOLICITUD DE PRODUCCION: {{-- {{$fecha_pedido[0]->fecha_pedido}} --}} </h4>
        </div>

        @php
        $idZumos = array();
        $arrayTotales=array();
        @endphp
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered " id="table">
              <thead style="background-color: #6777ef;">
                <th style="color: #fff;text-align:center">Sucursal</th>
                <th style="color: #fff;text-align:center">Fecha Pedido </th>
                <th style="color: #fff;text-align:center">Hora de Solicitud</th>
                @foreach ($pedidos_producciones as $pedido_produccion)
                  @foreach ($pedido_produccion->detalle_pedido_produccion as $detalle)
                    @if( in_array($detalle->plato->id, $idZumos)!= true )
                      @php
                      array_push($idZumos, $detalle->plato->id);        
                      array_push($arrayTotales,[0,'']);
                      @endphp
                    <th style="color: #fff;text-align:center ;"> {{$detalle->plato->nombre}} </th>
                    @endif
                  @endforeach
                @endforeach
              </thead>

              <tbody>
                @foreach ($pedidos_producciones as $pedido_produccion)
                <tr>                  
                    @php
                    $hora= new DateTime($pedido_produccion->created_at);
                    $hora_solicitud =$hora->format('H:i:s');
                    $auxfila = false;
                    @endphp
                  <td style="text-align:center ;">{{$pedido_produccion->nombre}}</td>
                  <td style="text-align:center ;"> {{  $pedido_produccion->fecha }} </td>
                  <td style="text-align:center ;">{{$hora_solicitud}}</td>
                    @for( $i = 0; $i < count($idZumos) ; $i++ ) 
                        @foreach ($detalles as $detalle)
                            @if( $detalle->pedido_produccion_id == $pedido_produccion->id &&  $idZumos[$i] == $detalle->plato_id  )                                
                                    @php
                                      $auxfila = true;
                                      $arrayTotales[$i][0]+=$detalle->cantidad_solicitada;                                    
                                    @endphp                                               
                                    <td style="text-align:center ;">
                                        {{ $detalle->cantidad_solicitada }}                      
                                    </td>                                
                                @break 
                            @endif  
                        @endforeach
                      @if($auxfila==false)
                      <td style="text-align:center ;"> 0 </td>
                      @endif
                      @php $auxfila = false; @endphp
                    @endfor
                </tr>
                @endforeach
                

                <td class="table-success" style="text-align:center ;">TOTAL:</td>
                <td></td>
                <td class="table-success" style="text-align:center ;">10:05</td>

                @for($j =0; $j< count($arrayTotales);$j++) <td class="table-success" style="text-align:center ;">
                    {{$arrayTotales[$j][0]}} {{$arrayTotales[$j][1]}}</td>                
                @endfor

              </tbody>

            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
@section('scripts')

<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.bootstrap4.min.js"></script>

<script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>



@section('page_js')
<script>
  $(document).ready(function() {
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
      dom: 'Bfrtip',
      buttons: [{
          //Botón para Excel
          extend: 'excel',
          footer: false,
          title: 'Solicitud de Zumos y Salsas',
          filename: 'Solicitud de Zumos y Salsas',

          //Aquí es donde generas el botón personalizado
          text: '<button class="btn btn-success">Exportar a Excel <i class="fas fa-file-excel"></i></button>'
        },
        //Botón para PDF
        {
          extend: 'pdf',
          footer: false,
          title: 'Solicitud de Zumos y Salsas',
          filename: 'Solicitud de Zumos y Salsas',
          text: '<button class="btn btn-danger">Exportar a PDF <i class="far fa-file-pdf"></i></button>'
        },
        {
          extend: 'print',
          text: '<button class="btn btn-dark">Imprimir <i class="fas fa-print"></i></button>',
          exportOptions: {
            modifier: {
              page: '1'
            }
          }
        },
      ]
    });
  })
</script>

@endsection
@endsection

@section('css')
.titulo{
font-size: 50px;
background-color: red;

}
@endsection
@section('page_css')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.3.1/css/buttons.bootstrap4.min.css" />
@endsection