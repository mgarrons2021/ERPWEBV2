@extends('layouts.app', ['activePage' => 'Observaciones', 'titlePage' => 'Observaciones'])

@section('content')

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Actualizar Observacion</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div align="center">
                            <img  id="imagenPrevisualizacion" src="{{url($observacion->foto) }}"  width="150" height="130"/>
                        </div
                        <div class="card card-primary">
                            <br>
                            <form action="{{ route('observaciones.update',$observacion->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row ">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="usuario">Nombre del Funcionario <span
                                                    class="required">*</span></label>
                                            <select name="usuario" id="" class="form-control">
                                                @foreach($usuarios as $user)
                                                    @if($user->id == $observacion->user_id)
                                                        <option value="{{$user->id}}" selected>{{$user->name}}</option>
                                                    @else
                                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="usuario">Funcionario Observado <span
                                                    class="required">*</span></label>
                                            <select name="usuario_observado" id="" class="form-control">
                                                @foreach($usuarios as $user)
                                                    @if($user->id == $observacion->detalleObservacion->user->id)
                                                        <option value="{{$user->id}}" selected>{{$user->name}}</option>
                                                    @else
                                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6><label for="exampleFormControlInput1" class="form-label">Respaldo</label></h6>
                                        <input type="file"  id="seleccionArchivos" class="form-control @error('descripcion') is-invalid @enderror" name="foto">
                                        @error('foto')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha_observacion">Fecha de observacion<span class="required">*</span></label>
                                            <input type="date" class="form-control  @error('fecha_observacion') is-invalid @enderror" name="fecha_observacion" value="{{$observacion->fecha_observacion}}">
                                            @error('fecha_observacion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="descripcion">Descripcion<span class="required">*</span></label>
                                            <textarea name="descripcion" id="descripcion" cols="30" rows="10" class="form-control  @error('descripcion') is-invalid @enderror" value="{{$observacion->descripcion}}">{{$observacion->descripcion}}</textarea>
                                            @error('descripcion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary" tabindex="7">Guardar</button>
                                    <a href="{{route('observaciones.index')}}" class="btn btn-danger" tabindex="8">Cancelar</a>
                                </div>
                                <br>
                            </form>
                        </div>
                    </div>
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
@section('page_js')
    <script>
        const $seleccionArchivos = document.querySelector("#seleccionArchivos"),
            $imagenPrevisualizacion = document.querySelector("#imagenPrevisualizacion");
        $seleccionArchivos.addEventListener("change", () => {
            const archivos = $seleccionArchivos.files;
            if (!archivos || !archivos.length) {
                $imagenPrevisualizacion.src = "";
                return;
            }
            const primerArchivo = archivos[0];
            const objectURL = URL.createObjectURL(primerArchivo);
            $imagenPrevisualizacion.src = objectURL;
        });
    </script>
@endsection