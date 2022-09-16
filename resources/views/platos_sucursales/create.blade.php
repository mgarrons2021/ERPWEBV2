@extends('layouts.app', ['activePage' => 'Precio Sucursales', 'titlePage' => 'Precio Sucursales'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading"> Asignar Platos a Sucursales </h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="row">
                          
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="categoria">Categoria<span class="required">*</span></label>
                                    <div class="selectric-hide-select">
                                        <select name="categoria_plato_id" id="categoria_plato" class="form-control selectric">
                                            @foreach ($categorias_platos as $categoria_plato)
                                            <option value="{{ $categoria_plato->id }}">{{ $categoria_plato->nombre }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="plato">Seleccione el Plato<span class="required">*</span></label>
                                    <div class="selectric-hide-select">
                                        <select name="plato_id" class="form-control selectric" id="plato">
                                            @foreach ($platos as $plato)
                                            @if($plato->estado == 1)
                                            <option value="{{ $plato->id }}">{{ $plato->nombre }}</option>
                                            @endif
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="producto">Seleccione la Sucursal<span class="required">*</span></label>
                                    <div class="selectric-hide-select">
                                        <select name="sucursal_id" class="form-control selectric" id="sucursal">
                                            @foreach ($sucursales as $sucursal)
                                            <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="precio">Precio<span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('precio') is-invalid @enderror" id="precio" name="precio" step="any" placeholder="0,00">
                                    @error('precio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="precio_delivery">Precio Delivery<span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('precio') is-invalid @enderror" id="precio_delivery" name="precio_delivery" step="any" placeholder="0,00">
                                    @error('precio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-outline-success" id="agregar_plato">Asignar Plato</button>
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
                        <th style="text-align: center;">Categoria</th>
                        <th style="text-align: center;">Plato</th>
                        <th style="text-align: center;">Precio</th>
                        <th style="text-align: center;">Precio Delivery</th>
                        <th style="text-align: center;">Sucursal</th>

                        
                        <th style="text-align: center;">Opciones</th>
                    </thead>
                    <tbody id="tbody">
                        @if (session('platos_sucursales'))
                        @foreach (session('platos_sucursales') as $indice => $value)
                        <tr>
                           <td style="text-align: center;" >{{$value['categoria_plato_nombre']}} </td>  
                            <td style="text-align: center;"> {{ $value['plato_nombre'] }}</td>
                            <td style="text-align: center;">{{ $value['precio'] }}</td>
                            @if ($value['precio_delivery']!= null)
                            <td style="text-align: center;">{{ $value['precio_delivery'] }}</td>
                            @else
                            <td style="text-align: center;">00,00</td>
                            @endif
                            <td style="text-align: center;">{{ $value['sucursal'] }}</td>
                            <td style="text-align: center;">
                                <button class="btn btn-danger" onclick="eliminar({{ $indice }});"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                        @endif

                    </tbody>
                </table>
            </div>

        </div>
        <div class="card-footer">
            <div class=" text-center">
                <button type="button" class="btn btn-outline-info" id="guardar_plato">Registrar Platos </button>
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


<script type="text/javascript" src="{{ URL::asset('assets/js/platos_sucursales/create.js') }}"> </script>
<script>
    let ruta_obtener_plato = "{{route('platos_sucursales.obtenerPlato')}}";
    let ruta_agregar_plato = "{{ route('platos_sucursales.enviarPlato') }}";
    let ruta_eliminar_plato = "{{ route('platos_sucursales.eliminarPlato') }}";
    let ruta_guardar_plato = "{{ route('platos_sucursales.guardarPlato') }}";
    let ruta_platos_sucursales_index = "{{ route('platos_sucursales.index') }}";
</script>

<script>
    /* sucursal.addEventListener("change", () => {
        sucursal.disabled = "readonly";
    }); */
</script>

@endsection