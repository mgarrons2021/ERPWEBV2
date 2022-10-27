@extends('layouts.app', ['activePage' => 'ventas_por_sucursal', 'titlePage' => 'Ventas_por_Sucursal'])

@section('content')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">

@endsection

<section class="section">

    <div class="section-header">
        <h1 class="text-center">Reporte de Ventas por Sucursal</h1>
    </div>
    <div class="card-body">
        <div class="table-responsive" style="overflow-x: hidden">
            <form action="{{ route('reportes.costo_totales') }}" method="POST" class="form-horizontal">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-daterange input-group" id="datepicker">
                            <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                            <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" />
                        </div>
                    </div>
                    <div class="col-md-3">

                        <div class="input-daterange input-group" id="datepicker">
                            <span class="input-group-addon "><strong>A:</strong> </span>
                            <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control"  id="turno" name="turno" aria-label="Default select example">
                            <option selected>Turno</option>
                            <option value="true" >Mañana</option>
                            <option value= "false" >Tarde</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="sucursal" name="sucursal" aria-label="Default select example">
                            <option selected>Sucursales</option>
                            @foreach($sucursales as $sucursal)
                            <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                            @endforeach
                        </select>
                    </div>


                </div>
                <div class="card-footer">
                    <div class="col-md-4" style="margin: 0 auto;">
                        <input class="form-control btn btn-primary" value="Filtrar" type="submit" id="filtrar" name="filtrar">
                    </div>
                    {{-- <a href="{{ route('reportes.ventas_por_sucursalId') }}">Consultar</a> --}}
                </div>

            </form>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card"></div>
                <div class="card-body">

                    <div class="table-responsive ">
                        <table id="dtable" class="table">
                            <thead style="background-color: #6777ef;">
                                <tr id="thead">
                                    <td style="color: white">Fecha</td>
                                    <td style="color: white">Ventas</td>
                                    <td style="color: white">Produccion Enviada</td>
                                    <td style="color: white">% Produccion E.</td>
                                    <td style="color: white">Parte Produccion</td>
                                    <td style="color: white">% Parte P.</td>
                                    <td style="color: white">Compras de Insumo</td>
                                    <td style="color: white">% Compras I.</td>
                                    <td style="color: white">Eliminaciones</td>
                                    <td style="color: white">% Eliminaciones</td>
                                    <td style="color: white">Comida Personal</td>
                                    <td style="color: white">% Comida P.</td>
                                    <td style="color: white">Total Uso</td>
                                    <td style="color: white">Total Uso PP</td>
                                    <td style="color: white">%Total Uso</td>
                                    <td style="color: white">%Total Uso PP</td>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @foreach($costoTotal as $costo)
                                <tr>
                                    <td>{{$costo->fecha}} </td>
                                    <td>{{$costo->ventas}} </td>
                                    <td>{{$costo->produccion_enviada}} </td>
                                    <td>{{$costo->porcentaje_produccion_enviada}}%</td>
                                    <td>{{$costo->parte_de_produccion}}</td>
                                    <td>{{$costo->porcentaje_parte_de_prudcuccion}}%</td>
                                    <td>{{$costo->compras_de_insumos}} </td>
                                    <td>{{$costo->porcentaje_compras_de_insumo}}%</td>
                                    <td>{{$costo->eliminaciones}} </td>
                                    <td>{{$costo->porcentaje_eliminaciones}}%</td>
                                    <td>{{$costo->comida_personal}} </td>
                                    <td>{{$costo->porcentaje_comida_personal}}%</td>
                                    <td>{{$costo->total_uso}} </td>
                                    <td>{{$costo->total_uso_pp}} </td>
                                    <td>{{$costo->porcentaje_total_uso}}%</td>
                                    <td>{{$costo->porcentaje_total_uso_pp}}%</td>
                                </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                            <tr>
                                {{-- <td>Totales</td> --}}
                                @foreach($sumaTotal as $suma)
                                <td>{{$suma}}</td>
                                @endforeach
                            </tr>
                            
                            </tfoot>
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

@section('page_js')
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.bootstrap4.min.js"></script>

<script type="text/javascript" src="//cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
{{-- <script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.js"></script> --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

@endsection

@endsection