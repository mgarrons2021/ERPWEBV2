@extends('layouts.app', ['activePage' => 'traspasos', 'titlePage' => 'Traspasos'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Traspaso Nro: {{ $traspasos->id }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-header">
                        <h4>Datos del Traspaso</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tbody>
                                    <tr>
                                        <th>Fecha de Traspaso:</th>
                                        <td>{{ $traspasos->fecha }}</td>
                                    </tr>
                                    <tr>
                                        <th> Total Traspaso:</th>
                                        <td>{{ $traspasos->total }}</td>
                                    </tr>
                                    <tr>
                                        <th> Estado:</th>
                                        <td>{{ $traspasos->estado  }}</td>
                                    </tr>  
                                    <tr>
                                        <th> Usuario:</th>
                                        <td>{{ $traspasos->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th> Inventario Principal:</th>
                                        <td>{{ $traspasos->inventario_principal_id }}</td>
                                    </tr>
                                    <tr>
                                        <th> Inventario Secundario:</th>
                                        <td>{{ $traspasos->inventario_secundario_id  }}</td>
                                    </tr>  
                                    <tr>
                                        <th>Sucursal Principal:</th>
                                        <td>{{ $traspasos->sucursal_principal_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sucursal Secundario:</th>
                                        <td>{{ $traspasos->sucursal_secundaria_id }}</td>
                                    </tr>                                                                   
                                </tbody>
                            </table>
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
                                    <select name="producto" id="producto" class="form-select select22" style="width: 100%;">
                                        <option value="">Seleccionar Producto</option>
                                        @foreach($categorias as $categoria)
                                        <optgroup label="{{Str::upper( $categoria->nombre)}}" class="title-select">
                                            @foreach($categoria->productos as $producto)
                                            <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                            @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>
                                    <p class="text-left text-danger d-none" id="errorproducto">Debe seleccionar un producto</p>
                                </div>
                            </div>

                            <input type="hidden" id="stock_actual">
                            <input type="hidden" id="precio">
                            <input type="hidden" id="unidad_medida">
                            <input type="hidden" id="stock_nuevo">

                            <input type="hidden" name="unidad_medida_venta_id" id="unidad_medida_venta_id" class="form-control" placeholder="U.M." readonly>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock">Stock </label>
                                    <input type="number" name="stock" id="cantidad" class="form-control" placeholder="Ingrese el stock del producto..." step="any ">
                                    <p class="text-left text-danger d-none" id="errorstock">Debe ingresar el stock</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button id="agregar_traspaso" class="btn btn-primary ">Agregar </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles del Traspaso</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered " id="table">
                                <thead style="background-color: #6777ef;">
                                    <th style="text-align: center;"> Editar </th>
                                    <th style="text-align: center;"> Eliminar </th>
                                    <th style="color: #fff;text-align:center">ID Producto</th>
                                    <th style="color: #fff;text-align:center">Nombre</th> 
                                    <th style="color: #fff;text-align:center">Cantidad</th>
                                    <th style="color: #fff;text-align:center">Precio</th>
                                    <th style="color: #fff;text-align:center">Subtotal</th>
                                                                                                    
                                </thead>
                                <tbody id="cuerpo_tabla">
                                <input type="hidden" name="traspaso_id" id="traspaso_id" value="{{$traspasos->id}}">
                                    @foreach ($traspasos->detalles_traspaso as $traspaso)
                                    <tr>
                                        <td style="text-align:center ;">
                                            <!-- Rounded switch -->
                                            <label class="switch">
                                                <input type="checkbox" class="checkbox-editar" value="{{$traspaso->id}}">
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td style="text-align:center ;">
                                            <label class="switch">
                                                <input type="checkbox" class="checkbox-eliminar" value="{{$traspaso->id}}">
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td style="text-align:center;">{{$traspaso->producto->id}} </td>     
                                        <td style="text-align:center;">{{$traspaso->producto->nombre}}</td>                                    
                                        <td style="text-align:center;">
                                            <input type="number" class="form-control stock" id="traspaso-{{$traspaso->id}}" style="text-align:center" value="{{ number_format( $traspaso->cantidad,2)}}" step="any" readonly>
                                        </td>   
                                        <td style="text-align:center;" class="precio" id="precio-{{$traspaso->id}}">      
                                             {{ ($traspaso->subtotal / $traspaso->cantidad ) }}                                             
                                        </td>       
                                        <td style="text-align:center;" class="td_subtotal" id="subtotal-{{$traspaso->id}}">{{ number_format( $traspaso->subtotal,2)}} </td>   
                                                     
                                    </tr>
                                    @endforeach 
                                </tbody>
                                <tfoot>
                                    <td colspan="6" style="text-align: center;"> Total Traspaso</td>
                                    <td colspan="1" style="text-align: center;" id="total_traspaso">{{ number_format($traspasos->total,2) }}</td>
                                </tfoot>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class=" text-center">
                            <button type="button" class="btn btn-primary" id="actualizar_traspasos">Actualizar
                               Traspaso</button>
                            <a href="{{ route('traspasos.index') }}" type="button" class="btn btn-danger" id="cancelar">Cancelar </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('assets/js/traspasos/edit.js') }}"></script>

<script>
    let ruta_actualizarTraspaso =
        "{{ route('traspasos.actualizarTraspaso') }}";
    let ruta_traspaso_index= "{{ route('traspasos.index') }}";
    let ruta_obtener_precio="{{ route('inventarios.obtenerPrecios') }}";
    let ruta_producto_categoria="{{ route('inventarios.obtenerProductosxId') }}";
    let ruta_obtenerDatosProducto = "{{ route('traspasos.obtenerDatosProducto') }}";
</script>
@endsection
@section('page_css')
<link href="{{ asset('assets/css/inventarios/edit.css') }}" rel="stylesheet" type="text/css" />
@endsection

