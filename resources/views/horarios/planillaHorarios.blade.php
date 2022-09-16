@extends('layouts.app', ['activePage' => 'horarios', 'titlePage' => 'Horarios'])

@section('content')
@section('css')
@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Planilla de Horarios</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4 style="text-align: center;font-size:large">Seleccione la Sucursal</h4>
                </div>
                <div class="card-body">
                    <select name="" id="_sucursal" class="form-select">
                        @foreach ($sucursales as $sucursal)
                            <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 style="text-align: center;font-size:large" id="sucursal_nombre">Nombre de Sucursal </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <h5 style="text-align: center;font-size:large">Turno Mañana</h5>
                        <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Cargo</th>
                                    <th>Horario</th>
                                    <th>Lunes</th>
                                    <th>Martes</th>
                                    <th>Miercoles</th>
                                    <th>Jueves</th>
                                    <th>Viernes</th>
                                    <th>Sabado</th>
                                    <th>Domingo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($cargos_sucursales))
                                    @foreach ($cargos_sucursales as $cargo_sucursal)
                                        <tr>
                                            <td>
                                                {{ $cargo_sucursal->nombre_cargo }}
                                            </td>
                                            <td>
                                                <select name="usuario" id="">
                                                    @foreach ($turnos as $turno)
                                                        @if ($turno->turno == 'AM')
                                                            <option value="">{{ $turno->hora_inicio }} a
                                                                {{ $turno->hora_fin }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="usuario" id="_funcionarios_lunes">
                                                  {{--   @foreach ($cargo_sucursal->users as $user)
                                                        <option value="">{{ $user->name }}</option>
                                                    @endforeach --}}
                                                </select>
                                            </td>
                                            <td>
                                                <select name="usuario" id="">
                                                    @foreach ($cargo_sucursal->users as $user)
                                                        <option value="">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="usuario" id="">
                                                    @foreach ($cargo_sucursal->users as $user)
                                                        <option value="">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="usuario" id="">
                                                    @foreach ($cargo_sucursal->users as $user)
                                                        <option value="">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="usuario" id="">
                                                    @foreach ($cargo_sucursal->users as $user)
                                                        <option value="">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="usuario" id="">
                                                    @foreach ($cargo_sucursal->users as $user)
                                                        <option value="">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="usuario" id="">
                                                    @foreach ($cargo_sucursal->users as $user)
                                                        <option value="">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>

                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <br>
                        <h5 style="text-align: center;font-size:large">Turno Tarde</h5>
                        <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Cargo</th>
                                    <th>Horario</th>
                                    <th>Lunes</th>
                                    <th>Martes</th>
                                    <th>Miercoles</th>
                                    <th>Jueves</th>
                                    <th>Viernes</th>
                                    <th>Sabado</th>
                                    <th>Domingo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($cargos_sucursales))
                                    @foreach ($cargos_sucursales as $cargo_sucursal)
                                        <tr>
                                            <td>
                                                {{ $cargo_sucursal->nombre_cargo }}
                                            </td>
                                            <td>
                                                <select name="usuario" id="">
                                                    @foreach ($turnos as $turno)
                                                        @if ($turno->turno == 'PM')
                                                            <option value="">{{ $turno->hora_inicio }} a
                                                                {{ $turno->hora_fin }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>

                                            </td>
                                            <td>
                                                <select name="usuario" id="">
                                                    @foreach ($cargo_sucursal->users as $user)
                                                        <option value="">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="usuario" id="">
                                                    @foreach ($cargo_sucursal->users as $user)
                                                        <option value="">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="usuario" id="">
                                                    @foreach ($cargo_sucursal->users as $user)
                                                        <option value="">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="usuario" id="">
                                                    @foreach ($cargo_sucursal->users as $user)
                                                        <option value="">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="usuario" id="">
                                                    @foreach ($cargo_sucursal->users as $user)
                                                        <option value="">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="usuario" id="">
                                                    @foreach ($cargo_sucursal->users as $user)
                                                        <option value="">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="usuario" id="">
                                                    @foreach ($cargo_sucursal->users as $user)
                                                        <option value="">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>

                                        </tr>
                                    @endforeach
                                @endif
                                {{-- @if (isset($cargos_sucursales))
                                    <tr>
                                        @foreach ($cargos_sucursales as $cargo_sucursal)
                                            @foreach ($cargo_sucursal->users as $user)
                                                <td>
                                                    {{ $user->name }}
                                                </td>
                                            @endforeach
                                        @endforeach
                                    </tr>
                                @endif --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" style="overflow-x: hidden">
                        <form action="{{-- {{ route('horarios.cargarHorarios') }} --}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                                        <input type="date" id="fechaini" class="input-sm form-control"
                                            name="fecha_inicial" value="" />
                                        <span class="input-group-addon">A</span>
                                        <input type="date" id="fechamax" class="input-sm form-control"
                                            name="fecha_final" value="" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control btn btn-primary" type="submit" value="Generar Planilla"
                                        id="filtrar" name="filtrar">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

@if (session('eliminar') == 'ok')
    <script>
        Swal.fire(
            'Eliminado!',
            'Tu registro ha sido eliminado.',
            'success'
        )
    </script>
@endif

<script>
    $('.formulario-eliminar').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Estas Seguro(a)?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Eliminarlo!'
        }).then((result) => {
            if (result.value) {
                /*  Swal.fire(
                     'Deleted!',
                     'Your file has been deleted.',
                     'success'
                 ) */
                console.log(this);
                this.submit();
            }
        })
    });
</script>
@section('page_js')
    <script>
        const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        document.getElementById('_sucursal').addEventListener('change', (e) => {
            fetch('{{route("horarios.obtenerFuncionarios")}}', {
                method: 'POST',
                body: JSON.stringify({
                    texto: e.target.value
                }),
                headers: {
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": csrfToken
                }
            }).then(response => {
                return response.json()
            }).then(data => {
                var opciones = "";

                //Lunes
                for (let i in data.lista) {
                    opciones += '<option value="' + data.lista[i].id + '">' + data.lista[i].name +
                        '</option>';
                }
                document.getElementById("_funcionarios_lunes").innerHTML = opciones;
                document.getElementById("sucursal_nombre").innerHTML = data.nombre_sucursal;
            }).catch(error => console.error(error));
        })
    </script>
    <script>
        $('#table').DataTable({
            language: {
                sProcessing: "Procesando...",
                sLengthMenu: "Mostrar _MENU_ registros",
                sZeroRecords: "No se encontraron resultados",
                sEmptyTable: "Ningun dato disponible en esta tabla",
                sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
                sInfoPostFix: "",
                sSearch: "Buscar:",
                sUrl: "",
                sInfoThousands: ",",
                sLoadingRecords: "Cargando...",
                oPaginate: {
                    sFirst: "Primero",
                    sLast: "Ãšltimo",
                    sNext: "Siguiente",
                    sPrevious: "Anterior"
                },
                oAria: {
                    sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                    sSortDescending: ": Activar para ordenar la columna de manera descendente"
                }
            },
            columnDefs: [{
                    orderable: false,
                    targets: 6
                },
                {
                    orderable: false,
                    targets: 7
                }
            ]
        });
    </script>
@endsection
@endsection
@section('css')
.tablecolor {
background-color: #212121;
}
@endsection
