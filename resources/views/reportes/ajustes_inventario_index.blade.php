@extends('layouts.app', ['activePage' => 'ventas_por_sucursal', 'titlePage' => 'Ventas_por_Sucursal'])

@section('content')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">

@endsection

<section class="section">

    <div class="section-header">
        <h1 class="text-center">Reporte Ajuste de Inventario</h1>
    </div>
    <div class="card-body">
        <div class="table-responsive" style="overflow-x: hidden">
            <form action="{{ route('reportes.ajuste_inventario') }}" method="POST" class="form-horizontal">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-daterange input-group" id="datepicker">
                            <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                            <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" />
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="input-daterange input-group" id="datepicker">
                            <span class="input-group-addon "><strong>A:</strong> </span>
                            <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" id="sucursal" name="sucursal" aria-label="Default select example">
                            <option selected>Sucursal</option>
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
                                <tr>
                                    <td style="color: white">ID</td>
                                    <td style="color: white">Fecha</td>
                                    <td style="color: white">Sucursal</td>
                                    <td style="color: white">Total</td>
                                </tr>

                            </thead>
                            <tbody id="tbody">
                                @foreach($inventariosAM as $inv)
                                <tr>
                                   
                                    <td><a href="{{route('reportes.show',[$inv->id,$inv->fecha,$inv->sucursal_id])}}">{{$inv->id}}</a></td>
                                    <td>{{$inv->fecha}} </td>
                                    <td>{{$inv->sucursal->nombre}} </td>
                                    <td>{{$inv->total}} </td>
                                
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