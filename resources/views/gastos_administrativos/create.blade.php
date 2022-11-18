@extends('layouts.app', ['activePage' => 'inventarios', 'titlePage' => 'Inventarios'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nuevo Registro</h3>
    </div>
    <div class="section-body">
        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Datos para Detalle de Gastos Admin &nbsp;- &nbsp; Fecha: {{$fecha_actual}} </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="egreso">Egreso</label>
                                    <input type="number" name="egreso" id="egreso" class="form-control" placeholder="Bs." step="any">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo_egreso">Tipo de Egreso</label>
                                    <select name="tipo_egreso" id="tipo_egreso" class="form-select">
                                        @foreach($categorias_gastos_administrativos as $categoria)
                                        <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="glosa">Glosa</label>
                                    <input type="text" name="glosa" id="glosa" class="form-control" placeholder="Glosa...">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo_comprobante">Tipo de Comprobante</label>
                                    <select name="tipo_comprobante" id="tipo_comprobante" class="form-select">
                                        <option value="F">Factura</option>
                                        <option value="R">Recibo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nro">Nro de Comprobante</label>
                                    <input type="text" id="nro" name="nro" class="form-control" placeholder="Nro...">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h6 class="card-title">Sucursal</h6>
                                <select class="form-select" aria-label="Default select example" name="sucursal_id" id="sucursal">
                                    @foreach($sucursales as $sucursal)
                                    <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <button id="agregar_detalle" class="btn btn-primary ">Agregar Detalle</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalle Gastos &nbsp;- &nbsp; Fecha: {{$fecha_actual}} </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="width: 100%;" id="table">
                                    <thead>
                                        <th style="text-align: center;">Sucursal</th>
                                        <th style="text-align: center;">Nro de Comprobante</th>
                                        <th style="text-align: center;">Tipo de Egreso</th>
                                        <th style="text-align: center;">Glosa</th>
                                        <th style="text-align: center;">Egreso</th>
                                        <th style="text-align: center;">Opciones</th>
                                    </thead>
                                    <tbody id="tbody">
                                        <?php $total_egreso = 0; ?>
                                        @if (session('lista_egreso'))
                                        @foreach (session('lista_egreso') as $indice => $item)
                                        <tr>
                                            <td style="text-align: center;">{{ $item['sucursal']['nombre']}}</td>
                                            <td style="text-align: center;">{{ $item['nro'] }}</td>
                                            <td style="text-align: center;">{{ $item['tipo_egreso_nombre'] }}</td>
                                            <td style="text-align: center;">{{ $item['glosa'] }}</td>
                                            <td style="text-align: center;">{{ $item['egreso'] }} </td>
                                            <?php $total_egreso += $item['egreso']; ?>
                                            <td style="text-align: center;">
                                                <button class="btn btn-danger" onclick="eliminar({{ $indice }});"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        <tr>
                                            <td colspan="2" style="text-align: center;">TOTAL Gastos Admin. </td>
                                            <td colspan="1" style="text-align: center;">Bs.{{ number_format($total_egreso,4) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class=" text-center">
                            <button type="button" class="btn btn-primary" id="registrar_Gasto">Registrar Gasto</button>
                            <button type="button" class="btn btn-danger" id="cancelar">Cancelar </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</section>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ URL::asset('assets/js/gastos_administrativos/create.js') }}"> </script>

<script>
    let ruta_registrarGasto = "{{ route('gastos_administrativos.registrarGasto') }}";
    let ruta_agregarDetalle = "{{ route('gastos_administrativos.agregarDetalle') }}";
    let ruta_eliminarDetalle = "{{ route('gastos_administrativos.eliminarDetalle') }}";
    let ruta_gastosadmin_index = "{{ route('gastos_administrativos.index') }}";
</script>

@endsection