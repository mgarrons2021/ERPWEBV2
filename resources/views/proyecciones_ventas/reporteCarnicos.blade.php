@extends('layouts.app', ['activePage' => 'zumos', 'titlePage' => 'Zumos'])

@section('content')

@section('css')

@endsection

<section class="section">
  <div class="section-header">
    <h3 class="page__heading">Reporte Carnicos</h3>
  </div>
  <div class="section-body">
    <div class="row">
      <div class="col-lg-12">
        <div class="card"></div>
        <div class="card-header">
          <h4>Seleccione la Fecha a Filtrar</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive" style="overflow-x: hidden">
            <form action="{{ route('asignar_stock.filtrarReporteCarnes')}}" method="POST">
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
        <h4> {{$fecha_actual}} - SOLICITUD DE CARNES: </h4>
      </div>

      @php
      $idZumos = array();
      $arrayTotales_stocks=array();
      $arrayTotales_cantidad=array();
      @endphp

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered " id="table">
            <thead style="background-color: #6777ef;">
              <th style="color: #fff;text-align:center">Sucursal</th>
              <th style="color: #fff;text-align:center">Hora Inventario </th>
              @foreach($collection as $carne)
                @if( in_array($carne->producto_id, $idZumos)!= true )
                  @php
                    array_push($idZumos, $carne->producto_id);
                    array_push($arrayTotales_stocks,[0]);
                    array_push($arrayTotales_cantidad,[0]);
                  @endphp
                  <th style="color: #fff;text-align:center">{{$carne->producto_nombre}}</th>
                @endif
              @endforeach
            </thead>
            <tbody>
              @foreach ($inventarios as $inventario)
              <tr>
                @php
                $hora= new DateTime($inventario->hora_solicitud);
                $hora_solicitud =$hora->format('H:i:s');
                $auxfila = false;
                @endphp
                <td style="text-align:center;">{{$inventario->nombre}}</td>
                <td style="text-align:center;">{{$hora_solicitud}}</td>
                @for( $i = 0; $i < count($idZumos) ; $i++ )
                  @php
                  $cantidad_subtotal=0;
                  $stock_ideal=0;
                  @endphp
                  @foreach($collection as $collect) 
                    @if($inventario->sucursal_id == $collect->sucursal_id && $idZumos[$i]==$collect->producto_id && $inventario->hora_solicitud==$collect->hora_solicitud)
                      @php
                      $auxfila = true;
                      $cantidad_subtotal += $collect->cantidad;
                      $stock_ideal= $collect->stock;
                      @endphp
                    @endif
                  @endforeach
                  @if($auxfila===false)
                    <td style="text-align:center ;"> 0 </td>
                  @else
                    @php
                    $total=$cantidad_subtotal - $stock_ideal;
                    @endphp
                    @if($cantidad_subtotal > $stock_ideal && $total >= 0)
                      <td style="text-align:center;">{{ number_format($cantidad_subtotal)}} /{{number_format($stock_ideal)}}= {{$total}}</td>
                      @php
                        $arrayTotales_stocks[$i][0]+=$stock_ideal;
                        $arrayTotales_cantidad[$i][0]+=$cantidad_subtotal;
                      @endphp
                    @else
                      <td style="text-align:center;">{{ number_format($cantidad_subtotal)}} /{{number_format($stock_ideal)}}= 0</td>
                    @endif
                  @endif
                  @php 
                    $auxfila = false; 
                  @endphp
                @endfor
              </tr>
              @endforeach
              <td class="table-success" style="text-align:center ;">TOTAL:</td>
              <td class="table-success" style="text-align:center ;"></td>
              @for($j =0; $j< count($arrayTotales_cantidad);$j++) 
                <td class="table-success" style="text-align:center ;">
                  @if($arrayTotales_cantidad[$j][0]>$arrayTotales_stocks[$j][0])
                  {{$arrayTotales_cantidad[$j][0]}} / {{$arrayTotales_stocks[$j][0]}} = {{$arrayTotales_cantidad[$j][0]-$arrayTotales_stocks[$j][0]}}
                  @else
                  {{$arrayTotales_cantidad[$j][0]}} / {{$arrayTotales_stocks[$j][0]}} = 0
                  @endif
                </td>
              @endfor
            </tbody>
            <tfoot>
             
            </tfoot>
          </table>
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