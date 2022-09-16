@extends('layouts.app', ['activePage' => 'compras', 'titlePage' => 'Compras'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nueva Compra</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" id="usuario_rol" value="{{$user->roles[0]->name}}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_actual">Fecha Actual</label>
                                    <input type="date" class="form-control" name="fecha_actual" value="{{ $fecha_actual }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sucursal">Sucursal</label>
                                    <select name="sucursal" id="sucursal" class="form-select">
                                        @foreach($sucursales as $sucursal)
                                        <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo_comprobante">Tipo de Comprobante</label>
                                    <select name="tipo_comprobante" id="tipo_comprobante" class="form-select">
                                        <option value="S">Sin Comprobante</option>
                                        <option value="F">Factura</option>
                                        <option value="R">Recibo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row" id="div_nro_factura" name="div_nro_factura">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nro_factura">Nro de Factura</label>
                                        <input type="text" name="nro_factura" id="nro_factura" class="form-control" value="" placeholder="Nro de Factura...">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nro_autorizacion">Nro de Autorizacion</label>
                                        <input type="text" name="nro_autorizacion" id="nro_autorizacion" class="form-control" value="" placeholder="Nro de Autorizacion...">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cod_control">Codigo Control</label>
                                        <input type="text" name="cod_control" id="cod_control" class="form-control" value="" placeholder="Codigo Control...">
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="div_nro_recibo" name="div_nro_recibo">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nro_recibo">Nro de Recibo</label>
                                        <input type="text" name="nro_recibo" id="nro_recibo" class="form-control" value="" placeholder="Nro de Recibo...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="proveedor">Proveedor<span class="required">*</span></label>
                                <select name="proveedor" id="proveedor" class="form-select">
                                    <option value="sinproveedor"> Seleccionar Proveedor</option>
                                    @foreach ($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}
                                    </option>
                                    @endforeach
                                </select>
                                <p class="text-left text-danger d-none" id="errorproducto">Debe seleccionar un proveedor</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="producto">Producto<span class="required">*</span></label>
                                <select name="producto" id="producto" class="form-select">
                                </select>
                                <p class="text-left text-danger d-none" id="errorproducto">Debe seleccionar un producto</p>
                            </div>
                        </div>
                        <input type="hidden" id="nombre_productos" name="nombre_productos" class="form-control" value="">
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <label for="cantidad">Cantidad*</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control" value="" placeholder="Cantidad...">
                            <p class="text-left text-danger d-none" id="errorproducto">Debe ingresar la cantidad</p>
                        </div>
                        <div class="col-md-3">
                            <label for="precio">Precio</label>
                            <input type="number" id="precio" name="precio" class="form-control" value="" placeholder="Bs" readonly>
                            <p class="text-left text-danger d-none" id="errorproducto">Debe ingresar el precio</p>
                        </div>
                        <div class="col-md-4">
                            <label for="subtotal">Subtotal</label>
                            <input type="number" id="subtotal" name="subtotal" class="form-control" value="" placeholder="Bs" readonly>
                        </div>
                        <div class="col-md-2 pt-4">
                            <button id="agregar_detalle" class="btn btn-primary">Agregar Producto</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md" style="width: 100%;" id="table">
                            <thead>
                                <th style="text-align: center;">Producto</th>
                                <th style="text-align: center;">Costo Unitario</th>
                                <th style="text-align: center;">Cantidad</th>
                                <th style="text-align: center;">Sub Total</th>
                                <th style="text-align: center;">Opciones</th>
                            </thead>
                            <tbody id="tbody">
                                <?php $subtotal = 0; ?>
                                @if (session('lista_compra'))
                                @foreach (session('lista_compra') as $indice => $item)
                                <tr>
                                    <td style="text-align: center;">
                                        {{ $item['producto_nombre']['nombre'] }}
                                    </td>
                                    <td style="text-align: center;">{{ number_format($item['precio'],4) }}</td>
                                    <td style="text-align: center;">{{ $item['cantidad'] }} </td>
                                    <td style="text-align: center;">{{ number_format($item['subtotal'],4) }}</td>
                                    <?php $subtotal += $item['subtotal']; ?>
                                    <td style="text-align: center;">
                                        <button class="btn btn-danger" onclick="eliminar({{ $indice }});"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                <tr>
                                    <td colspan="1" style="text-align: center;">TOTAL A PAGAR </td>
                                    <td colspan="4" style="text-align: center;">Bs.{{ number_format($subtotal,4) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class=" text-center">
                        <button type="button" class="btn btn-primary" id="registrar_compra">Registrar
                            Compra</button>
                        <button type="button" class="btn btn-danger" id="cancelar">Cancelar </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal hide fade in" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingrese los datos</h5>
                <button type="button" class="close" id="cerrar_modal1" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="banco" class="col-form-label">Banco</label>
                            <input type="text" class="form-control" id="banco" name="banco" placeholder="Banco...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nro_cuenta" class="col-form-label">Nro de Cuenta</label>
                            <input type="number" class="form-control" id="nro_cuenta" name="nro_cuenta" placeholder="Nro de Cuenta...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nro_cheque" class="col-form-label">Nro de Cheque</label>
                            <input type="number" class="form-control" id="nro_cheque" name="nro_chenque" placeholder="Nro de Cheque...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="registrar_compra2">Registrar Compra</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

<script type="text/javascript" src="{{ URL::asset('assets/js/compras/create.js') }}"> </script>
<script>
    let ruta_obtenerproductos = "{{ route('compras.obtenerproductos') }}";
    let ruta_obtenerprecios = "{{ route('compras.obtenerprecios') }}";
    let ruta_guardardetalle = "{{ route('compras.guardarDetalle') }}";
    let ruta_eliminardetalle = "{{ route('compras.eliminarDetalle') }}";
    let ruta_registrarCompra = "{{ route('compras.registrarCompra') }}";
    let ruta_compras_index = "{{ route('compras.index') }}";
</script>

@endsection