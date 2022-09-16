@extends('layouts.app', ['activePage' => 'roles', 'titlePage' => 'Roles'])

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar Role</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                           @if ($errors->any())
                           <div class="alert alert-info alert-dismissible fade show" role="alert">
                               <strong>Revise sus datos</strong>
                               @foreach ($errors->all() as $error)
                                   <span class="badge badge-success">{{$error}}</span>
                               @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                           </div>

                           @endif

                           {!! Form::model($role, ['route'=>['roles.update',$role],'method'=>'put']) !!}
                                <div class="form-group">
                                    {!! Form::label('name', 'nombre') !!}
                                    {!! Form::text('name',null, ['class'=>'form-control','placeholder'=>'Ingrese el nombre del rol']) !!}
                                </div>

                            <h2 class="h3">Lista de Permisos</h2>
                            @foreach ($permissions as $permission)
                                    <div>
                                        <label >
                                            {!! Form::checkbox('permissions[]', $permission->id, null, ['class'=>'mr-1']) !!}
                                            {{$permission->description}}
                                        </label>
                                    </div>
                            @endforeach

                           <button type="submit" class="btn btn-primary">Guardar</button>
                           <a class="btn btn-warning" href="{{route('roles.index')}}">Volver</a>

                        </div>
                        {!! Form::close()!!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

