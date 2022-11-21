@extends('layouts.app', ['activePage' => 'contabilidad', 'titlePage' => 'Reportes'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        {{-- @php
        $fecha_inicial_parseada = strtoupper( \Carbon\Carbon::parse($fecha_marcado_inicial)->locale('es')->isoFormat(' D MMMM'));
        $fecha_final_parseada = strtoupper( \Carbon\Carbon::parse($fecha_marcado_final)->locale('es')->isoFormat(' D MMMM, YYYY'));
        @endphp --}}
        <h3 class="page__heading">Reporte de Gastos</h3>
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
                            <form action="{{route('contabilidad.filtrarDatos')}}" method="POST">
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
                                    <div class="col-md-6" style="margin-top: 10px ;">
                                        <input class="form-control btn btn-primary" type="submit" value="Filtrar" id="filtrar" name="filtrar">
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card">
                @if ($request != null)
                <div class="card-header">
                    <h4>{{$request->fecha_inicial}} | A | {{$request->fecha_final}}</h4>
                </div>
                @endif

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered " id="table">
                            <thead style="background-color: #6777ef;">

                                <th style="color: #fff;text-align:center">Codigo</th>
                                <th style="color: #fff;;text-align:center">Cuentas</th>
                                <th style="color: #fff;;text-align:center">Totales</th>
                                <th style="color: #fff;;text-align:center">Categoria</th>
                                <th style="color: #fff;text-align:center">Ver</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align:center"><strong>6-1100</strong></td>
                                    <td style="text-align:center"><strong>Gastos De Administracion</strong></td>
                                    <td style="text-align:center"></td>
                                    <td style="text-align:center"></td>
                                    <td style="text-align:center"></td>
                                </tr>
                                @if ($request != null)
                                @foreach ($listOne as $valor)
                                <tr>

                                    <td style="text-align:center">{{$valor->codigo}}</td>
                                    <td style="text-align:center">{{$valor->nombre}}</td>
                                    <td style="text-align:center">{{$valor->suma_egreso}}</td>
                                    <td style="text-align:center">{{$valor->subcategoria}}</td>
                                    <td style="text-align:center">
                                        <form action="{{route('contabilidad.detalle')}}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="input-daterange input-group" id="datepicker">
                                                        <input hidden type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="{{$request->fecha_inicial}}" />
                                                        <input hidden type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="{{$request->fecha_final}}" />
                                                        <input hidden type="text" id="categoria" class="input-sm form-control" name="categoria" value="{{ $valor->id }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <button class="btn btn-primary" type="submit">ver detalle</button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                <tr>
                                    <td style="text-align:center"><strong>6-1200</strong></td>
                                    <td style="text-align:center"><strong>Gastos De Comercializacion</strong></td>
                                    <td style="text-align:center"></td>
                                    <td style="text-align:center"></td>
                                    <td style="text-align:center"></td>
                                </tr>
                                @if ($request != null)
                                @foreach ($listTwo as $valor)
                                <tr>

                                    <td style="text-align:center">{{$valor->codigo}}</td>
                                    <td style="text-align:center">{{$valor->nombre}}</td>
                                    <td style="text-align:center">{{$valor->suma_egreso}}</td>
                                    <td style="text-align:center">{{$valor->subcategoria}}</td>
                                    <td style="text-align:center">
                                        <form action="{{route('contabilidad.detalle')}}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="input-daterange input-group" id="datepicker">
                                                        <input hidden type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="{{$request->fecha_inicial}}" />
                                                        <input hidden type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="{{$request->fecha_final}}" />
                                                        <input hidden type="text" id="categoria" class="input-sm form-control" name="categoria" value="{{ $valor->id }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <button class="btn btn-primary" type="submit">ver detalle</button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <td style="text-align:center" colspan="2" class="table-warning">TOTAL EGRESO </td>
                                <td style="text-align:center" class="table-primary">Bs{{ number_format($total_egresoFactura,2,',','.') }}</td>
                                <td></td>
                                <td></td>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ URL::asset('assets/js/gastos_administrativos/reportes/reportegastos.js') }}"></script>

<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.bootstrap4.min.js"></script>

<script type="text/javascript" src="//cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

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