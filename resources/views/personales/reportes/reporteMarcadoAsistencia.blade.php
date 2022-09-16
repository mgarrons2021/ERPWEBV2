 @extends('layouts.app', ['activePage' => 'horarios', 'titlePage' => 'horarios'])

@section('content')

@section('css')

@endsection

<section class="section">
  <div class="section-header">
    @php
    $fecha_inicial_parseada = strtoupper( \Carbon\Carbon::parse($fecha_marcado_inicial)->locale('es')->isoFormat(' D MMMM'));
    $fecha_final_parseada = strtoupper( \Carbon\Carbon::parse($fecha_marcado_final)->locale('es')->isoFormat(' D MMMM, YYYY'));
    @endphp
    <h3 class="page__heading">Reporte Marcado Asistencia </h3>

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
              <form action="{{route('personales.filtrarMarcadoAsistencia')}}" method="POST">
                @csrf
                <div class="row">
                  <div class="col-md-8">

                    <div class="input-daterange input-group" id="datepicker">
                      <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                      <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" />
                      <span class="input-group-addon">A</span>
                      <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="" />
                    </div>
                  </div>
                  <div class="col-md-4">
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
          <h4> FECHA DE: {{$fecha_inicial_parseada}} A: {{$fecha_final_parseada}}</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered " id="table">
              <thead style="background-color: #6777ef;">
                <th style="color: #fff;text-align:center">Funcionario</th>
                <th style="color: #fff;;text-align:center">Turno</th>
                <th style="color: #fff;;text-align:center">Sucursal</th>
                <th style="color: #fff;;text-align:center">Horario Entrada</th>
                <th style="color: #fff;;text-align:center">Horario Salida</th>
                @role('Super Admin')
                <th style="color: #fff;;text-align:center">Horas Trabajadas</th>
                <th style="color: #fff;;text-align:center">Total a Pagar</th>
                @endrole
              </thead>
              <tbody>
                @php
                $total = 0;
                @endphp
                @foreach ($registros as $registro)
                @if ($registro->turno == '0')
                <tr>
                  <td style="text-align:center">{{$registro->user->name}}</td>
                  @if(isset($registro->user->turnos[0]->turno))
                  <td style="text-align:center;">{{$registro->user->turnos[0]->turno}}</td>
                  @else
                  <td style="text-align:center;">S/Turno</td>
                  @endif
                  <td style="text-align:center">{{$registro->user->sucursals[0]->nombre}}</td>
                  <td style="text-align:center">{{$registro->hora_entrada}}</td>
                  <td style="text-align:center">{{$registro->hora_salida}}</td>

                  @php
                  $total_pagar= 0;
                  $costo_hora =8.84;
                  $hora_entrada = new DateTime($registro->hora_entrada);
                  $hora_salida = new DateTime($registro->hora_salida);
                  $horas_trabajadas = date_diff($hora_entrada,$hora_salida)->format('%H hrs %i min %s seg');
                  $formateado = date_diff($hora_entrada,$hora_salida)->format('%H:%i:%s');
                  list($hora, $min, $seg) = explode(":", $formateado);
                  $resultado_horas = $hora + $min / 60 + $seg / 3600;
                  $total_pagar = $resultado_horas * $costo_hora;
                  @endphp
                  @role('Super Admin')

                  @if ($registro->hora_salida == "00:00:00")
                  <td style="text-align:center">00 hrs 00 min 00 seg</td>
                  <td style="text-align:center" class="table-primary">0.00 Bs</td>
                  @else
                  <td style="text-align:center">{{$horas_trabajadas}}</td>
                  <td style="text-align:center" class="table-primary">{{number_format($total_pagar,2)}} Bs</td>
                  @php
                  $total+=$total_pagar;
                  @endphp
                  @endif
                  @endrole
                </tr>
                @endif
                @if ($registro->turno == '1')
                <tr>
                  <td style="text-align:center">{{$registro->user->name}}</td>
                  @if(isset($registro->user->turnos[1]->turno))
                  <td style="text-align:center;">{{$registro->user->turnos[1]->turno}}</td>
                  @else
                  <td style="text-align:center;">S/Turno</td>
                  @endif
                  <td style="text-align:center">{{$registro->user->sucursals[0]->nombre}}</td>
                  <td style="text-align:center">{{$registro->hora_entrada}}</td>
                  <td style="text-align:center">{{$registro->hora_salida}}</td>

                  @php
                  $hora_entrada = new DateTime($registro->hora_entrada);
                  $hora_salida = new DateTime($registro->hora_salida);
                  $horas_trabajadas = date_diff($hora_entrada,$hora_salida)->format('%H hrs %i min %s seg');

                  $formateado = date_diff($hora_entrada,$hora_salida)->format('%H:%i:%s');
                  list($hora, $min, $seg) = explode(":", $formateado);
                  $resultado_horas = $hora + $min / 60 + $seg / 3600;
                  $total_pagar = $resultado_horas * $costo_hora;

                  @endphp
                  @role('Super Admin')

                  @if ($registro->hora_salida == "00:00:00")
                  <td style="text-align:center">00 hrs 00 min 00 seg</td>
                  <td style="text-align:center" class="table-primary">0.00 Bs</td>
                  @else
                  <td style="text-align:center">{{$horas_trabajadas}}</td>
                  <td style="text-align:center" class="table-primary">{{number_format($total_pagar,2)}} Bs</td>
                  @endrole
                  @php
                  $total+=$total_pagar;
                  @endphp
                  @endif
                </tr>
                @endif
                @endforeach
              </tbody>
              @role('Super Admin')
              <tfoot>
                <td style="text-align: center;" colspan="6" class="table-warning">Total a Pagar de {{$fecha_inicial_parseada}}</td>
                <td style="text-align: center" class="table-primary">{{ number_format($total,2) }} Bs</td>
              </tfoot>
              @endrole
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

<script type="text/javascript" src="//cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
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
      dom: 'Bftipr',
      buttons: [{
          //Botón para Excel
          extend: 'excel',
          footer: false,
          title: 'Marcado Asistencia',
          filename: 'Marcado Asistencia',

          //Aquí es donde generas el botón personalizado
          text: '<button class="btn btn-success">Exportar a Excel <i class="fas fa-file-excel"></i></button>'
        },
        //Botón para PDF
        {
          extend: 'pdf',
          footer: false,
          title: 'Marcado Asistencia',
          filename: 'Marcado Asistencia',
          text: '<button class="btn btn-danger">Exportar a PDF <i class="far fa-file-pdf"></i></button>'
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