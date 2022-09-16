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
                          
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cantidad_lomo">Cantidad Lomo <span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('cantidad_lomo') is-invalid @enderror" id="cantidad_lomo" name="cantidad_lomo" step="any" placeholder="0,00">
                                    @error('precio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cantidad_cuadril">Cantidad Cuadriles <span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('cantidad_cuadril') is-invalid @enderror" id="cantidad_cuadril" name="cantidad_cuadril" step="any" placeholder="0,00">
                                    @error('cantidad_cuadril')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cantidad_eliminado">Cantidad Eliminado<span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('precio') is-invalid @enderror" id="cantidad_eliminado" name="cantidad_eliminado" step="any" placeholder="0,00">
                                    @error('cantidad_eliminado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cantidad_recortado">Cantidad Recortado<span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('precio') is-invalid @enderror" id="cantidad_recortado" name="cantidad_recortado" step="any" placeholder="0,00">
                                    @error('cantidad_recortado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-outline-success" id="agregar_plato">Agregar</button>
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
                        <th style="text-align: center;">Lomo</th>
                        <th style="text-align: center;">Eliminado</th>
                        <th style="text-align: center;">Recortado</th>
                        <th style="text-align: center;">Cuadril</th>
                

                        
                        <th style="text-align: center;">Opciones</th>
                    </thead>
                    <tbody id="tbody">
                        @if (session('platos_sucursales'))
                        @foreach (session('platos_sucursales') as $indice => $value)
                        <tr>
                           <td style="text-align: center;" >{{$value['categoria_plato']}} </td>  
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
    sucursal.addEventListener("change", () => {
        sucursal.disabled = "readonly";
    });
</script>

@endsection