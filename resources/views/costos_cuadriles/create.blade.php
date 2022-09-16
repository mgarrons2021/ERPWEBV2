 @extends('layouts.app', ['activePage' => 'costos_cuadriles', 'titlePage' => 'Costo Cuadril'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Registro Cortado Cuadriles</h3>
    </div>
    <div class="section-body">
        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre_usuario"> Nombre Usuario <span class="required">*</span></label>
                                <input type="text" class="form-control  @error('nombre_usuario') is-invalid @enderror" id="nombre_usuario" name="nombre_usuario" step="any" >
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="peso_inicial"> Peso Inicial <span class="required">*</span></label>
                                <input type="number" class="form-control  @error('peso_inicial') is-invalid @enderror" id="peso_inicial" name="peso_inicial" step="any" placeholder="0,00">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for=""> Inv Actual <span class="required">*</span></label>
                                <input type="number" class="form-control  @error('peso_inicial') is-invalid @enderror" id="" name="" step="any" readonly placeholder="0,00">
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                 <div class="card">
                    <div class="card-header">
                        <h4>Registro de Cortado de Cuadriles &nbsp;- &nbsp; Fecha: {{$fecha_actual}} </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad_lomo">Cantidad Lomo <span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('cantidad_lomo') is-invalid @enderror" id="cantidad_lomo" name="cantidad_lomo" step="any" placeholder="0,00">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad_cuadril">Cantidad Cuadriles <span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('cantidad_cuadril') is-invalid @enderror" id="cantidad_cuadril" name="cantidad_cuadril" step="any"  placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad_ideal_cuadril">Cantidad Ideal de Cuadriles</label>
                                    <div class="input-group " >
                                        <div class="input-group-prepend ">
                                            <div class="input-group-text">
                                                <i class="fas fa-check-circle" ></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control " id="cantidad_ideal_cuadril" name="cantidad_ideal_cuadril" style="background-color: #659553;color:white" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad_eliminado">Cantidad Eliminado <span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('cantidad_eliminado') is-invalid @enderror" id="cantidad_eliminado" name="cantidad_eliminado" step="any" placeholder="0,00">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad_recortado">Cantidad Recortado <span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('cantidad_recortado') is-invalid @enderror" id="cantidad_recortado" name="cantidad_recortado" step="any" placeholder="0,00">
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <button id="agregar_detalle" class="btn btn-primary ">Agregar </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalle del Cortado {{-- &nbsp;- &nbsp; Fecha: {{$fecha_actual}} --}} </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="width: 100%;" id="table">
                                    <thead class="table-info">
                                        <th style="text-align: center;">Lomo</th>
                                        <th style="text-align: center;">Eliminacion</th>
                                        <th style="text-align: center;">Recortado</th>
                                        <th style="text-align: center;">Cuadril</th>
                                        <th style="text-align: center;">Opciones</th>
                                    </thead>
                                    <tbody id="tbody">
                                        <?php
                                        $total_cantidad_lomo = 0;
                                        $total_cantidad_eliminado = 0;
                                        $total_cantidad_recorte = 0;
                                        $total_cantidad_cuadril = 0;
                                        ?>
                                        @if (session('lista_costo_cuadril'))
                                        @foreach (session('lista_costo_cuadril') as $indice => $item)
                                        <tr>
                                            <td style="text-align: center;">{{ $item['cantidad_lomo'] }} Kg</td>
                                            <td style="text-align: center;">{{ $item['cantidad_eliminado'] }} Kg</td>
                                            <td style="text-align: center;">{{ $item['cantidad_recorte'] }} Kg</td>
                                            <td style="text-align: center;">{{ $item['cantidad_cuadril'] }} Und</td>
                                            <?php
                                            $total_cantidad_lomo += $item['cantidad_lomo'];
                                            $total_cantidad_eliminado += $item['cantidad_eliminado'];
                                            $total_cantidad_recorte += $item['cantidad_recorte'];
                                            $total_cantidad_cuadril += $item['cantidad_cuadril'];
                                            ?>
                                            <td style="text-align: center;">
                                                <button class="btn btn-danger" onclick="eliminar({{ $indice }});"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        <tr>
                                            <td colspan="1" style="text-align: center;" class="table-danger">{{ number_format($total_cantidad_lomo,3) }} Kg</td>
                                            <td colspan="1" style="text-align: center;" class="table-danger">{{ number_format($total_cantidad_eliminado,3) }} Kg</td>
                                            <td colspan="1" style="text-align: center;" class="table-danger">{{ number_format($total_cantidad_recorte,3) }} Kg</td>
                                            <td colspan="1" style="text-align: center;" class="table-danger">{{ number_format($total_cantidad_cuadril,3) }} Und</td>
                                            <td colspan="1" style="text-align: center;" class="table-danger"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class=" text-center">
                            <button type="button" class="btn btn-primary" id="registrar_corte_cuadril">Registrar Cortes</button>
                            <button type="button" class="btn btn-danger" id="cancelar">Cancelar </button>
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
<script type="text/javascript" src="{{ URL::asset('assets/js/costos_cuadriles/create.js') }}"> </script>
<script>
    let ruta_registrarCostoCuadril = "{{ route('costos_cuadriles.store') }}";
    let ruta_agregarDetalle = "{{ route('costos_cuadriles.agregarDetalle') }}";
    let ruta_eliminardetalle = "{{ route('costos_cuadriles.eliminarDetalle') }}";
    let ruta_costoscuadriles_index = "{{ route('costos_cuadriles.index') }}";
</script>

@endsection