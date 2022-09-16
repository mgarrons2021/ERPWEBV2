@extends('layouts.app', ['activePage' => 'horarios', 'titlePage' => 'Horarios'])

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Horario Personal Fijo</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card card-primary">
                                <br>
                                <form action="{{ route('horarios.store') }}" method="POST" class="form-horizontal">
                                    @csrf
                                    <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="usuario_id">Seleccione el Usuario<span class="required">*</span></label>
                                            <div class="selectric-hide-select">
                                                <select name="usuario_id" class="form-control selectric">
                                                    @foreach($usuarios as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sucursal_id">Asigne la Sucursal<span
                                                        class="required">*</span></label>
                                                <div class="selectric-hide-select">
                                                    <select name="sucursal_id" id="_sucursal"
                                                        class="form-control selectric">
                                                        @foreach ($sucursales as $sucursal)
                                                            <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="horario_ingreso">Horario Entrada Fijo<span
                                                        class="required">*</span></label>
                                                <input type="time"
                                                    class="form-control  @error('horario_ingreso') is-invalid @enderror"
                                                    name="horario_ingreso">
                                                @error('horario_ingreso')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="hora_salida_fija">Horario Salida Fijo<span
                                                        class="required">*</span></label>
                                                <input type="time"
                                                    class="form-control  @error('hora_salida_fija') is-invalid @enderror"
                                                    name="hora_salida_fija">
                                                @error('hora_salida_fija')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="turno">Turno<span class="required">*</span></label>
                                                <div class="selectric-hide-select">
                                                    <select name="turno" class="form-control selectric">
                                                        <option value="am">AM</option>
                                                        <option value="pm">PM</option>
                                                        <option value="pm">AMBOS</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                   
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <a class="btn btn-danger" href="{{ route('horarios.index') }}">Volver</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
            document.getElementById('_sucursal').addEventListener('change', (e) => {
                fetch( '{{route("sucursal.funcionarios")}}', {
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
                    for (let i in data.lista) {
                        opciones += '<option value="' + data.lista[i].id + '">' + data.lista[i].name +
                            '</option>';
                    }
                    document.getElementById("_funcionarios").innerHTML = opciones;
                }).catch(error => console.error(error));
            })
        </script>
    </section>
@endsection