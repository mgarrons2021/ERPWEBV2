@extends('layouts.app', ['activePage' => 'productos_proveedores', 'titlePage' => 'Productos_Proveedores'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Asignar Precios a Productos </h3>
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
                                <div class="form-group">
                                    <label for="proveedor">Selecciona el Proveedor<span class="required">*</span></label>
                                    <div class="selectric-hide-select">
                                        <select name="proveedor" id="proveedor" class="form-control selectric">
                                            @foreach ($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="producto">Seleccione el Producto<span class="required">*</span></label>
                                    <div class="selectric-hide-select">
                                        <select name="producto" class="form-control selectric" id="producto">
                                            @foreach ($productos as $producto)
                                            <option value="{{ $producto->id }}">{{ $producto->nombre }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="precio">Precio<span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('precio') is-invalid @enderror" id="precio" name="precio" step="any">
                                    @error('precio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary" id="agregar_detalle">Asignar Precio</button>
                        </div>
                    </div>
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
                        <th style="text-align: center;">Precio</th>
                        <th style="text-align: center;">Opciones</th>
                    </thead>
                    <tbody id="tbody">
                        @if (session('productos_proveedores'))
                        @foreach (session('productos_proveedores') as $indice => $item)
                        <tr>
                            <td style="text-align: center;">
                                {{ $item['producto_nombre']['nombre'] }}
                            </td>
                            <td style="text-align: center;"> {{ is_null($item['precio'] ) ? 0 : $item['precio'] }} </td>
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
                <button type="button" class="btn btn-primary" id="registrar_precios">Registrar
                    Precios </button>
                <button type="button" class="btn btn-danger" id="cancelar">Cancelar </button>
            </div>
        </div>
    </div>

</section>
@endsection
@section('scripts')

<script>
    $(document).ready(function() {
        $('#producto').select2({
            width: 'resolve',
        
        });
    });
</script>
<script type="text/javascript" src="{{ URL::asset('assets/js/productos_proveedores/create.js') }}"> </script>
<script>
    let ruta_guardardetalle = "{{ route('productos_proveedores.guardarDetalle') }}";
    let ruta_eliminardetalle = "{{ route('productos_proveedores.eliminarDetalle') }}";
    let ruta_registrar_precios = "{{ route('productos_proveedores.registrarPrecios') }}";
    let ruta_productos_proveedores_index = "{{ route('productos_proveedores.index') }}";
</script>

<script>
    let proveedor = document.getElementById("proveedor");

    proveedor.addEventListener("change", () => {
        proveedor.disabled = "readonly";
    });
</script>

@endsection