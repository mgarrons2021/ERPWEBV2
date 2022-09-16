{{-- Form para Asignar garante a User --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingrese los datos del Garante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('garantes.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{$user->id}}">

                    <div class="form-group">
                        <label for="nombre" class="col-form-label">Nombre Garante *</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Garante Nombre">
                    </div>

                    <div class="form-group">
                        <label for="apellido" class="col-form-label">Apellido Garante *</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Garante Apellido">
                    </div>
                    <div class="form-group">
                        <label for="apellido" class="col-form-label">Celular *</label>
                        <input type="text" class="form-control" id="apellido" name="celular" placeholder="Garante Apellido">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput1" class="form-label">Foto domicilio *</label>
                        <input type="file" id="seleccionArchivos" class="form-control @error('descripcion') is-invalid @enderror" name="foto">

                    </div>

                    <div class="form-group">
                        <label for="direccion" class="col-form-label">Direccion *</label>
                        <textarea class="form-control" id="direccion" name="direccion" placeholder="Ubicacion"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="ocupacion" class="col-form-label">Ocupacion *</label>
                        <textarea class="form-control" id="ocupacion" name="ocupacion" placeholder="Profesion"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="letra_cambio">Letra de Cambio *</label>
                        <div class="selectric-hide-select">
                            <select name="letra_cambio" class="form-control selectric">

                                <option>SI</option>
                                <option>No</option>


                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Asignar</a>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal garante-->
<div class="modal fade " id="modalGarante" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h6 class="modal-title"> <i class="		fas fa-arrow-alt-circle-down icon" aria-hidden="true"></i> Detalles del garante: </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        @if(isset($user->garante))
                        <tr>
                            <th scope="row">Nombre Completo:</th>
                            <td> {{$user->garante->nombre}} {{$user->garante->apellido}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Celular:</th>
                            @if (isset($user->garante->celular))
                            <td> {{$user->garante->celular}} </td>
                            @else
                            <td class="alerta "> Sin telefono </td>
                            @endif

                        </tr>
                        <tr>
                            <th scope="row">Domicilio:</th>
                            <td> {{$user->garante->direccion}}</td>
                        </tr>
                        <tr>
                            @if(isset($user->garante->foto))
                            <th scope="row">Croquis de domicilio:</th>
                            <td>
                                <a href="{{url($user->garante->foto)}}" target="_blank" class="zoom">
                                    <img src="{{url($user->garante->foto)}}" alt="" id="imagen">
                                </a>
                            </td>
                            @else
                                <th scope="row">Croquis de domicilio:</th>
                                @if($user->garante->foto===null || $user->garante->foto==='')
                                    <td>Sin foto</td>
                                @else
                                    <td>
                                        <a href="{{url($user->garante->foto)}}" target="_blank" class="zoom">
                                            <img src="{{url($user->garante->foto)}}" alt="" id="imagen">
                                        </a>
                                    </td>
                                @endif
                            @endif
                        </tr>

                        <tr>
                            <th scope="row">Ocupación:</th>
                            @if (isset($user->garante->ocupacion))
                            <td> {{$user->garante->ocupacion}}</td>
                            @else
                            <td> Sin Ocupacion </td>
                            @endif
                        </tr>
                        <tr>
                            <th scope="row">Letra de Cambio:</th>
                            <td> {{$user->garante->letra_cambio}}</td>
                        </tr>
                        @endif

                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Contratos -->
<div class="modal fade " id="modal_contratos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLongTitle"> Contratos del funcionario: {{ $user->name }} {{ $user->apellido}} </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <thead class="thead">
                        <tr>
                            <th scope="col" style="text-align: center;">Tipo contrato</th>
                            <th scope="col" style="text-align: center;">Fecha Inicio</th>
                            <th scope="col" style="text-align: center;">Fecha Fin</th>
                            <th scope="col" style="text-align: center;">Turno</th>
                            <th scope="col" style="text-align: center;">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                        @foreach ($user->detalleContratos as $detallecontrato)
                        <tr>
                            <td class="text-center  table-light">
                                {{$detallecontrato->contrato->tipo_contrato}}

                            </td>
                            <td class="text-center">
                                @php $fecha_formateada_inicio = date('d-m-Y', strtotime($detallecontrato->fecha_inicio_contrato)); @endphp
                                {{$fecha_formateada_inicio}}
                            </td>
                            <td class="text-center">
                                @php $fecha_formateada_fin = date('d-m-Y', strtotime($detallecontrato->fecha_fin_contrato)); @endphp
                                {{$fecha_formateada_fin}}
                            </td>
                            <td class="text-center">
                                {{ $detallecontrato->disponibilidad }}
                            </td>
                            <td class="text-center">
                                <form action="{{ route('personales_contratos.eliminar',$detallecontrato->id)}}" id="formulario-eliminar2" class="formulario-eliminar" method="POST">
                                    <a class="btn btn-warning btn-sm  " href="{{ route('personales_contratos.edit',$detallecontrato->id)}}"><i class='fas fa-edit'></i></a>
                                    @csrf
                                    @method('Delete')
                                    <button class="btn btn-danger btn-sm " href="" type="submit"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar </button>
            </div>
        </div>
    </div>
</div>






<!-- Modal Bonos -->
<div class="modal fade " id="modal_bonos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLongTitle"> Bonos asignados al funcionario: {{ $user->name }} {{ $user->apellido}} </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <thead class="thead">
                        <tr>
                            <th scope="col" style="text-align: center;">Fecha</th>
                            <th scope="col" style="text-align: center;">Monto</th>
                            <th scope="col" style="text-align: center;">Motivo</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                        @foreach ($user->bonos as $bono)
                        <tr>
                            <td class="text-center table-light">
                                @php $fecha_formateada_bono = date('d-m-Y', strtotime( $bono->fecha )); @endphp
                                {{$fecha_formateada_bono}}
                            </td>
                            <td class="text-center">{{ $bono->monto }}</td>
                            <td class="text-center">{{ $bono->motivo }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sanciones -->
<div class="modal fade " id="modal_sanciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLongTitle"> Sanciones asignadas al funcionario: {{ $user->name }} {{ $user->apellido}} </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <thead class="thead">
                        <tr>
                            <th scope="col" style="text-align: center;">Fecha</th>
                            <th scope="col" style="text-align: center;">Tipo sanción</th>
                            <th scope="col" style="text-align: center;">Descripcion</th>
                            <th scope="col" style="text-align: center;">Otorgado por</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                        @foreach ($user->sanciones as $sancion)
                        <tr>
                            <td class="text-center table-light">
                                <a href="{{ route('sanciones.show', $sancion->id) }}" value="{{ $sancion->id }}" class="dato" target="_blank">
                                    @php $fecha_formateada_inicio = date('d-m-Y', strtotime( $sancion->fecha)); @endphp
                                    {{$fecha_formateada_inicio}} </a>
                            </td>
                            <td class="text-center">{{ $sancion->categoriaSancion->nombre }}
                            </td>
                            <td class="text-center">{{ $sancion->descripcion }}</td>
                            <td class="text-center"> {{$sancion->detalleSancion->user->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Descuentos -->
<div class="modal fade " id="modal_descuentos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLongTitle"> Descuentos asignados al funcionario: {{ $user->name }} {{ $user->apellido}} </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <thead class="thead">
                        <tr>
                            <th scope="col" style="text-align: center;">Fecha</th>
                            <th scope="col" style="text-align: center;">Monto</th>
                            <th scope="col" style="text-align: center;">Motivo</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                        @foreach ($user->descuentos as $descuento)
                        <tr>
                            <td class="text-center table-light">
                                <a href="{{ route('descuentos.show', $descuento->id) }}" value="{{ $user->id }}" class="dato" target="_blank">
                                    @php $descuento_fecha = date('d-m-Y', strtotime($descuento->fecha)); @endphp
                                    {{$descuento_fecha}} </a>
                            </td>
                            <td class="text-center">{{ $descuento->monto }}</td>
                            <td class="text-center">{{ $descuento->motivo }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Vacaciones -->
<div class="modal fade " id="modal_vacaciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLongTitle"> Vacaciones asignadas al funcionario: {{ $user->name }} {{ $user->apellido}} </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <thead class="thead">
                        <tr>
                            <th scope="col" style="text-align: center;">Fecha Inicio</th>
                            <th scope="col" style="text-align: center;">Fecha Fin</th>
                            <th scope="col" style="text-align: center;">Otorgado por </th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                        @foreach ($user->vacaciones as $vacacion)
                        <tr>
                            <td class="text-center table-light">
                                <a href="{{ route('vacaciones.show', $vacacion->id) }}" value="{{ $user->id }}" class="dato" target="_blank">

                                    @php $fecha_formateada_inicio = date('d-m-Y', strtotime($vacacion->fecha_inicio)); @endphp
                                    {{$fecha_formateada_inicio}} </a>
                            </td>
                            @php $fecha_formateada_fin = date('d-m-Y', strtotime($vacacion->fecha_fin)); @endphp
                            <td class="text-center"> {{$fecha_formateada_fin}} </a></td>
                            <td class="text-center">{{ $vacacion->detalleVacacion->user->name}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar </button>
            </div>
        </div>
    </div>
</div>


<style>
    .icon {
        color: #4CAF50;
    }

    #imagen {
        width: 100px;
        height: 100px;
        border-radius: 5px;
        transition: 0.3s;
    }
</style>