@extends('layouts.app', ['activePage' => 'Precio Sucursales', 'titlePage' => 'Precio Sucursales'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading"> Menu Semanal de la Empresa Donesco Srl. </h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="background-color: #1C3558;">
                        
                        <h4 style="text-align:right;color:white;">Fecha: {{$fecha_actual}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha">Fecha </label>
                                    <input type="date" name="fecha" id="fecha" class="form-control" value="{{$fecha_actual}}" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="dia">Dia Semana*</label>
                        
                                <select name="dia" id="dia" class="form-control selectric" >
                                    <option value="LUNES">Lunes</option>
                                    <option value="MARTES">Martes</option>
                                    <option value="MIERCOLES">Miercoles</option>
                                    <option value="JUEVES">Jueves</option>
                                    <option value="VIERNES">Viernes</option>
                                    <option value="SABADO">Sabado</option>
                                    <option value="DOMINGO">Domingo</option>
                                 </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="plato">Seleccione el Plato a Añadir<span class="required">*</span></label>
                                    <div class="selectric-hide-select">
                                        <select name="plato_id" class="form-control selectric" id="plato">
                                            <option value="">Seleccione el Plato </option>
                                            @foreach($platos as $plato)
                                                @if ($plato->estado == 1)
                                                <option value="{{$plato->id}}">{{$plato->nombre}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                         
                            <input type="hidden" id="plato_nombre" name="plato_nombre" class="form-control" value="">
                            <input type="hidden" id="categoria_plato" name="categoria_plato" class="form-control" value="">
                        
                            <div class="col-md-6">
                                <button type="button" class="btn btn-outline-success" id="agregar_plato">Agregar Plato</button>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" style="width: 100%;" id="table">
                    <thead class="table-info">

                        
                        <th style="text-align: center;">Dia de la Semana</th>
                        <th style="text-align: center;">Plato</th>
                        <th style="text-align: center;">Categoria</th>
                        <th style="text-align: center;">Opciones</th>
                    </thead>
                    <tbody id="tbody">
                        @php
                        $total =0;
                        @endphp

                        @if (session('menus_semanales'))

                            @php
                                //dd( session('menus_semanales') );
                            @endphp

                            @foreach (session('menus_semanales') as $indice => $value)
                            <tr>  
                                <td style="text-align: center;"> {{ $value['dia'] }}</td>
                                <td style="text-align: center;">{{ $value['plato_nombre'] }} </td>
                                <td style="text-align: center;"> {{ isset($value['categoria_plato'])?$value['categoria_plato'] : 'NINGUNO' }}</td>
                                <td style="text-align: center;">
                                    <button class="btn btn-danger" onclick="eliminar({{ $indice }});"><i class="fas fa-trash"></i></button>
                                </td>
                                
                            </tr>
                            @endforeach

                        @endif
                       {{--  <tr>
                            <td colspan="6" style="text-align: center;" class="table-danger">Total: {{ number_format($total,3) }} Bs</td>
                        </tr> --}}

                    </tbody>
                </table>
            </div>

        </div>
        <div class="card-footer">
            <div class=" text-center">
                <button type="button" class="btn btn-outline-info" id="guardar_menu"> Registrar Menu </button>
                <button type="button" class="btn btn-outline-danger" id="cancelar">Cancelar </button>
            </div>
        </div>
    </div>

</section>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#plato').select2({
            width: 'resolve',

        });
    });
</script>


<script type="text/javascript" src="{{ URL::asset('assets/js/menus_semanales/create.js') }}"> </script>
<script>
    let ruta_agregar_plato = "{{ route('menus_semanales.agregarPlato') }}";
    let ruta_eliminar_plato = "{{ route('menus_semanales.eliminarPlato') }}";
    let ruta_guardar_menu = "{{ route('menus_semanales.store') }}";
    
    let ruta_menu_index = "{{ route('menus_semanales.index') }}";
    
</script>

{{-- <script>
    sucursal.addEventListener("change", () => {
        sucursal.disabled = "readonly";
    });
</script> --}}

@endsection