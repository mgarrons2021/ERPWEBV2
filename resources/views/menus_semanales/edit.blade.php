@extends('layouts.app', ['activePage' => 'inventarios', 'titlePage' => 'Inventarios'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Menu dia: {{ $menu_semanal->dia }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">

            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" id="menu_id" value="{{$menu_semanal->id}}">
                        <input type="hidden" id="dia" value="{{$menu_semanal->dia}}">
                        <div class="row">

                            <div class="col-md-6">
                                <h4>Agrega un nuevo Plato al Menu</h4>
                                <div class="form-group">
                                    <label for="plato"></label>
                                    <select name="plato" id="plato" class="form-select select22" style="width: 100%;">
                                        <option value="">Seleccionar Plato</option>
                                        @foreach($platos as $plato)
                                        <option value="{{$plato->id}}">{{$plato->nombre}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            {{-- <input type="hidden" name="unidad_medida_venta_id" id="unidad_medida_venta_id" class="form-control" placeholder="U.M." readonly> --}}

                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button id="agregar_plato" class="btn btn-outline-success ">Agregar nuevo Plato</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles del Menu</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered ">
                                <thead class="table-info">
                                    <th style="text-align: center;"> Eliminar </th>
                                    <th style="text-align: center;">Plato </th>
                                    
                                    <th style="text-align: center;"> Precio </th>
                                    <th style="text-align: center;"> Estado </th>
                                </thead>
                                <tbody id="cuerpoTabla">
                                    {{-- <input type="hidden" name="inventario_id" id="inventario_id" value="{{$inventario->id}}"> --}}
                                    @foreach($menu_semanal->detalle_menus_semanales as $index => $detalle )
                                    <tr>

                                        <td style="text-align:center ;">
                                            <label class="switch">
                                                <input type="checkbox" class="checkbox-eliminar" value="{{$detalle->id}}">
                                                <span class="slider round"></span>
                                            </label>
                                        </td>

                                        <td style="text-align: center;">{{$detalle->plato->nombre}}</td>
                                    
                                        @if (isset($detalle->plato->platos_sucursales[0]->precio))
                                        <td style="text-align: center;">{{$detalle->plato->platos_sucursales[0]->precio}} Bs.</td>
                                        @else
                                        <td style="text-align: center;"><span class="badge badge-warning"> Sin Precio Asignado </span></td>
                                        @endif

                                        @if($detalle->plato->estado == 1)
                                        <td style="text-align: center;"><span class="badge badge-success"> Ofertado </span></td>
                                        @else
                                        <td style="text-align: center;"><span class="badge badge-danger"> De Baja </span></td>
                                        @endif

                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class=" text-center">
                            <button type="button" class="btn btn-primary" id="actualizar_menu">Actualizar Menu</button>
                            <a href="{{ route('inventarios.index') }}" type="button" class="btn btn-danger" id="cancelar">Cancelar </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('assets/js/menus_semanales/edit.js') }}"></script>

<script>
    let ruta_obtenerDatosPlatos = "{{ route('menus_semanales.obtenerDatosPlatos')}}";
    let ruta_agregar_plato = "{{ route('menus_semanales.agregarPlato')}}"
    let ruta_actualizarMenu = "{{ route('menus_semanales.actualizarMenu') }}";
    let ruta_menus_index = "{{ route('menus_semanales.index') }}";
</script>
@endsection
@section('page_css')
<link href="{{ asset('assets/css/inventarios/edit.css') }}" rel="stylesheet" type="text/css" />
@endsection