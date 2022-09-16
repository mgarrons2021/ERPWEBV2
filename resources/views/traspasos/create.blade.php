@extends('layouts.app', ['activePage' => 'traspasos', 'titlePage' => 'Traspasos'] )

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nuevo Traspaso</h3>
    </div>
    <div class="section-body">
        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="background-color: #6777ef;">
                        <h4 style="color:white;">Traspaso: Nro {{$last_traspaso}}. &nbsp;</h4>
                        <h4 style="text-align:right;color:white;">Fecha: {{$fecha_actual}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sucursal">Traspaso a la Sucursal</label>
                                    <select name="sucursal" id="sucursal" class="form-select">
                                        <option value="sin_sucursal">Seleccion la Sucursal</option>
                                        @foreach($sucursales as $sucursal)
                                        <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-left text-danger d-none" id="errorsucursal">Debe seleccionar una sucursal</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="producto">Seleccione el Producto</label>
                                    <select name="producto" id="producto" class="form-select" style="width: 100%;" required>
                                        <option value="sin_seleccionar" id="sin_seleccionar">Seleccione el Producto</option>
                                        @foreach($categorias as $categoria)
                                        <optgroup label="{{Str::upper( $categoria->nombre)}}">
                                            @foreach($categoria->productos as $producto)
                                            <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                            @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>
                                    <p class="text-left text-danger d-none" id="errorproducto">Debe seleccionar un producto</p>
                                    <input type="hidden" id="stock_actual">
                                    <input type="hidden" id="precio">
                                    <input type="hidden" id="unidad_medida">
                                    <input type="hidden" id="stock_nuevo">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cantidad_traspaso">Cantidad a Traspasar</label>
                                    <input type="text" class="form-control" id="cantidad_traspaso" placeholder="Cantidad a Traspasar..." required>
                                    <p class="text-left text-danger d-none" id='errorcantidad'>Debe ingresar una cantidad distinto de cero </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button id="agregar" class="btn btn-primary ">Agregar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="width: 100%;" id="table">
                                    <thead>
                                        <th style="text-align: center;">Producto</th>
                                        <th style="text-align: center;">U. M.</th>
                                        <th style="text-align: center;">Cantidad a Traspasar</th>
                                        <th style="text-align: center;">Costo</th>
                                        <th style="text-align: center;">Sub Total</th>
                                        <th style="text-align: center;">Opciones</th>
                                    </thead>
                                    <tbody id="tbody">
                                        <?php $subtotal = 0; ?>
                                        @if (session('lista_traspaso'))
                                        @foreach (session('lista_traspaso') as $indice => $item)
                                        <tr>
                                            <td style="text-align: center;">{{ $item['producto_nombre'] }}</td>
                                            <td style="text-align: center;">{{ $item['unidad_medida'] }}</td>
                                            <td style="text-align: center;">{{ $item['cantidad'] }} </td>
                                            <td style="text-align: center;">{{ $item['precio'] }}</td>
                                            <td style="text-align: center;">{{ $item['subtotal'] }}</td>
                                            <?php $subtotal += $item['subtotal']; ?>
                                            <td style="text-align: center;">
                                                <button class="btn btn-danger" onclick="eliminar( {{ $indice }} );"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        <tr>
                                            <td colspan="4" style="text-align: center;">TOTAL TRASPASO </td>
                                            <td colspan="1" style="text-align: center;">Bs.{{ number_format($subtotal,4) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class=" text-center">
                            <button type="button" class="btn btn-primary" id="registrar_traspaso">Registrar
                                Traspaso</button>
                            <a type="button" href="{{ route('traspasos.index') }}"  class="btn btn-danger" id="cancelar">Cancelar </a>
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
<script type="text/javascript" src="{{ URL::asset('assets/js/traspasos/create.js') }}"> </script>

<script>
    let ruta_obtenerDatosProducto = "{{ route('traspasos.obtenerDatosProducto') }}";
    let ruta_agregarDetalle = "{{ route('traspasos.agregarDetalle') }}";
    let ruta_eliminardetalle = "{{ route('traspasos.eliminarDetalle') }}";
    let ruta_registrarTraspaso = "{{ route('traspasos.registrarTraspaso') }}";
    let ruta_traspasos_index = "{{ route('traspasos.index') }}";
</script>
<script>

</script>
@endsection
@section('page_css')
<style>
    .select2 {
        width: 100%;
    }
</style>
@endsection