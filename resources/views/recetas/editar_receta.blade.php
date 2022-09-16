@extends('layouts.app', ['activePage' => 'inventarios', 'titlePage' => 'Inventarios'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Edición de la receta del plato: {{$platos->nombre}} </h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-header">
                        <h4>Datos Generales del Plato</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tbody>
                                    <tr>
                                        <th class="text-center">Plato: </th>
                                        <td class="text-center table-light"> {{$platos->nombre}}</td>

                                    </tr>
                                    <tr>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles de la receta</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive"></div>
                        <table class="table table-striped" style="width: 100%;">
                            <thead>
                                <th style="text-align: center;"> Editar </th>
                                <th style="text-align: center;"> Eliminar </th>
                                <th style="text-align: center;"> Producto </th>
                                <th style="text-align: center;"> Precio </th>
                                <th style="text-align: center;"> U. M. </th>
                                <th style="text-align: center;"> Cantidad </th>
                                <th style="text-align: center;"> Subtotal </th>
                            </thead>
                            <tbody>
                                <input type="hidden" id="plato_id" value="{{$platos->id}}">
                                <input type="hidden" id="total_plato" value="{{$platos->total}}">
                                @foreach($recetas as $receta )
                                <tr>
                                    <td style="text-align:center ;">
                                        <!-- Rounded switch -->
                                        <label class="switch">
                                            <input type="checkbox" class="checkbox-editar" value="{{$receta->id}}">
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td style="text-align:center ;">
                                        <label class="switch">
                                            <input type="checkbox" class="checkbox-eliminar" value="{{$receta->id}}">
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td style="text-align: center;"> {{$receta->productoProveedor->producto->nombre}}</td>
                                    <td style="text-align: center;" class="precio" id="precio-{{$receta->id}}"> {{$receta->productoProveedor->precio}} </td>
                                    <td style="text-align: center;" class="unidad_medida_compra" id="">
                                        @if(isset($receta->productoProveedor->producto->unidad_medida_compra->nombre ))
                                        {{$receta->productoProveedor->producto->unidad_medida_compra->nombre}}
                                        @else
                                        Sin UM
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control cantidad" id="cantidad" style="text-align:center" value="{{ number_format ($receta->cantidad, 4)}}" step="any" readonly>
                                    </td>
                                    @php $subtotal = 0;
                                    $subtotal = ($receta->productoProveedor->precio * $receta->cantidad );
                                    @endphp
                                    <td style="text-align: center;" class="td_subtotal" id="subtotal-{{$receta->id}}"> {{number_format($subtotal, 3)}}</td>
                                </tr>
                                @endforeach
                            <tfoot>
                                <td colspan="6" style="text-align: center;"> Total Plato: </td>
                                <td colspan="1" style="text-align: center;" id="total_plato2">{{ number_format($platos->costo_plato,3)}}</td>
                            </tfoot>
                            </tbody>
                            
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class=" text-center">
                        <button type="button" class="btn btn-primary" id="actualizar_receta">Actualizar
                            Receta</button>
                        <a href="{{ route('platos.index') }}" type="button" class="btn btn-danger" id="cancelar">Cancelar </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('assets/js/recetas/edit.js') }}"></script>
<script>
    let ruta_actualizarReceta = "{{ route('recetas.actualizarReceta') }}";
    let ruta_platos = "{{ route('platos.index') }}";
</script>
@endsection
@section('page_css')
<link href="{{ asset('assets/css/recetas/edit.css') }}" rel="stylesheet" type="text/css" />
@endsection