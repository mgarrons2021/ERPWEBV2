@extends('layouts.app', ['activePage' => 'proyecciones_ventas', 'titlePage' => 'proyecciones_ventas'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Proyecciones de Ventas </h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha">Fecha<span class="required">*</span></label>
                                    <input type="date" class="form-control  @error('fecha') is-invalid @enderror" name="fecha" value="{{ $fecha_act }}" readonly>
                                    @error('fecha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
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
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary" id="agregar_detalle">Agregar</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles del Pedido</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th style="text-align: center;"> Fecha </th>
                                <th style="text-align: center;"> Turno AM </th>
                                <th style="text-align: center;"> Turno PM </th>
                                <th style="text-align: center;"> Total Dia </th>
                            </thead>
                            <tbody id="cuerpotabla">
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                    <td style="text-align: center;" class="venta_proyeccion_subtotal" name="venta_proyeccion_subtotal" id="venta_proyeccion_subtotal">
                                        </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <td style="text-align: center;">
                                    <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                <td style="text-align: center;">
                                    <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                </td>
                                <td style="text-align: center;">
                                    <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_am" style="text-align:center" name="venta_proyeccion_am" value="venta_proyeccion_am" step="any">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control stock" id="venta_proyeccion_pm" style="text-align:center" name="venta_proyeccion_pm" value="venta_proyeccion_pm" step="any">
                                    </td>
                                </tr>

                                </tr>



                            </tbody>
                            <tfoot>


                                <td colspan="5" style="text-align: center;"> Total Enviado del Pedido</td>

                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class=" text-center">
                            <button type="button" class="btn btn-primary" id="actualizar_pedido">Actualizar Pedido</button>
                            <a href="{{ route('proyecciones_ventas.index') }}" type="button" class="btn btn-danger" id="cancelar">Cancelar </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/js/proyecciones_ventas/create.js') }}"></script>
<script>
    let ruta_pedidos_index = "{{ route('proyecciones_ventas.index') }}";
</script>
@endsection
@section('page_css')
<link href="{{ asset('assets/css/inventarios/edit.css') }}" rel="stylesheet" type="text/css" />
@endsection