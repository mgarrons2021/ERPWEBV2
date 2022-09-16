@extends('layouts.app', ['activePage' => 'productos', 'titlePage' => 'Productos'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Asignar Bono</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card card-primary">
                            <br>
                            <form action="{{ route('bonos.store') }}" method="POST" class="form-horizontal">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_id">Seleccione al usuario <span class="required">*</span></label>
                                            <div class="selectric-hide-select">
                                                <select name="user_id" class="form-control selectric">
                                                    @foreach($usuarios as $usuario)
                                                    <option value="{{$usuario->id}}">{{$usuario->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="monto">Monto<span class="required">*</span></label>
                                                <div class="selectric-hide-select">
                                                    <select name="monto" class="form-control select">

                                                        <option>300</option>
                                                        <option>500</option>
                                                        <option>1000</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                   

                            
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha">Fecha Asignada<span class="required">*</span></label>
                                            <input type="date" class="form-control  @error('fecha') is-invalid @enderror" name="fecha">
                                            @error('fecha')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                    </div>
                                    

                                
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="motivo">Motivo<span class="required">*</span></label>
                                                <div class="selectric-hide-select">
                                                    <select name="motivo" class="form-control selectric">

                                                        <option>Buen Desempeño</option>
                                                        <option>Antiguedad</option>
                                                        <option>Permanencia</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                      

                                  
                                   
                                </div> 
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary toastrDefaultSuccess" id=toastr-1>Guardar</button>
                                    <a class="btn btn-danger" href="{{route('personales.index')}}">Volver</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
@if(session('bono')=='registrado')
<script>
    let ruta_personales = "{{ route('bonos.index') }}";
    iziToast.success({
                title: 'SUCCESS',
                message: "Registro agregado exitosamente",
                position: 'topRight',
                timeout: 1000 ,
                onClosed: function () {
                    window.location.href = ruta_personales;
                }

            });
</script>
@endif
@endsection