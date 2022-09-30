@extends('layouts.app', ['activePage' => 'cufd', 'titlePage' => 'Cufd'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nuevo Cufd</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card card-primary">
                            <br>
                            <form action="{{ route('cufd.store') }}" method="POST" class="form-horizontal">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sucursal_id">Sucursal</label>
                                            <select name="sucursal_id" id="sucursal" class="form-select">
                                                @foreach($sucursales as $sucursal)
                                                <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">Generar Cuis</button>
                                    <a class="btn btn-danger" href="{{route('cufd.index')}}">Volver</a>
                                </div>
                                <br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection