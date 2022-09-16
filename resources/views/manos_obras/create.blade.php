@extends('layouts.app', ['activePage' => 'Pedidos Producion', 'titlePage' => 'Pedidos Produccion'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading"> Registro Mano Obra, Sucursal: {{$user->sucursals[0]->nombre}} </h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="background-color: #6777ef;">
                        
                        <h4 style="text-align:right;color:white;">Fecha: {{$fecha_actual}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                          
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_pedido">Fecha Entrega*</label>
                                    <input type="date" name="fecha" id="fecha" class="form-control">
                                    <p class="text-left text-danger d-none" id="errorfecha">Debe ingresar una fecha </p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="cantidad_solicitada">Ventas Dia*</label>
                                <input type="number" name="ventas" id="ventas" class="form-control" value="">
                                <p class="text-left text-danger d-none" id="errorcantidad">Debe de ingresar una cantidad</p>
                            </div>


                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="plato">Funcionarios<span class="required">*</span></label>
                                    <div class="selectric-hide-select">
                                        <select name="user_id" class="form-control selectric" id="usuario">
                                            <option value="x">Seleccione los funcionarios </option>
                                            @foreach($users as $user)
                                            
                                            <option value="{{$user->id}}">{{$user->name}} {{$user->apellido}} </option>
                                            
                                            @endforeach

                                        </select>
                                        <p class="text-left text-danger d-none" id="errorproducto">Debe seleccionar un usuario</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="cantidad_solicitada">Horas Trabajadas*</label>
                                <input type="number" name="cantidad_horas" id="cantidad_horas" class="form-control" value="">
                                <p class="text-left text-danger d-none" id="errorcantidad">Debe de ingresar cantidad Horas</p>
                            </div>

                            <input type="hidden" id="user_name" name="user_name" class="form-control" value="">
                            
                            <input type="hidden" id="subtotal_horas" name="subtotal_horas" class="form-control" value="" placeholder="Hrs" readonly>
                            <input type="hidden" id="subtotal_costo" name="subtotal_costo" class="form-control" value="" placeholder="Bs" readonly>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-outline-success" id="agregar_funcionario">Agregar</button>
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

                        
                        <th style="text-align: center;">Funcionario</th>
                        <th style="text-align: center;">Cantidad Horas</th>
                        
                        <th style="text-align: center;">Opciones</th>
                    </thead>
                    <tbody id="tbody">
                        @php
                        $total_horas =0;
                        $total_costo =0;
                        @endphp
                        @if (session('manos_obras_sucursales'))
                        @foreach (session('manos_obras_sucursales') as $indice => $value)
                        <tr>
                            <td style="text-align: center;">{{$value['user_name']}} </td>
                            <td style="text-align: center;"> {{ $value['cantidad_horas'] }}</td>
                            

                            
                            @php
                            $total_horas += $value['cantidad_horas'];
                            $total_costo += $value['subtotal_costo'];
                            @endphp
                            <td style="text-align: center;">
                                <button class="btn btn-danger" onclick="eliminar({{ $indice }});"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                        <tr>
                            <td colspan="6" style="text-align: center;" class="table-info">Total Horas: {{ number_format($total_horas,3) }} Hrs</td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="card-footer">
            <div class=" text-center">
                <button type="button" class="btn btn-outline-info" id="registrar_mano_obra"> Registrar MO </button>
                <button type="button" class="btn btn-outline-danger" id="cancelar">Cancelar </button>
            </div>
        </div>
    </div>
    
</section>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ URL::asset('assets/js/manos_obras/create.js') }}"> </script>
<script>
    let ruta_agregar_funcionario = "{{ route('manos_obras.agregarFuncionario') }}";
    let ruta_guardar_mano_obra = "{{ route('manos_obras.store') }}";
    let ruta_eliminar_funcionario = "{{route('manos_obras.eliminarFuncionario') }}"; 
    let ruta_manos_obras = "{{ route('manos_obras.index') }}";
    



</script>

<script>
    $(document).ready(function() {
        $('#usuario').select2({
            width: 'resolve',

        });
    });
</script>

@endsection