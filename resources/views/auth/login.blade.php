@extends('layouts.auth_app')
@section('title')
Inicia Sesion
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card card-primary">
    <div class="card-header">
        <h5 class="titulo">Te damos la bienvenida al sistema DONESCO SRL.</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('login_nuevo') }}">
            @csrf

            <!-- <input aria-describedby="emailHelpBlock" id="email" type="hidden" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Enter Email" tabindex="1" value="{{ (Cookie::get('email') !== null) ? Cookie::get('email') : old('email') }}" autofocus>
            <div class="invalid-feedback">
                {{ old('email') }}
            </div> -->
            <label class="label" for="codigo">Codigo de usuario *</label><br><br>
            <input aria-describedby="emailHelpBlock" id="codigo" type="password" class="form-control{{ $errors->has('codigo') ? ' is-invalid' : '' }}" name="codigo" placeholder="Ingresa tu codigo" tabindex="1" value="{{ (Cookie::get('codigo') !== null) ? Cookie::get('codigo') : old('codigo') }}" autofocus>
           <!--  <div class="invalid-feedback">
                {{ $errors->first('email') }}
            </div><br> -->
           <!--  <div class="form-group">
                <div class="d-block">
                </div>
                <input aria-describedby="passwordHelpBlock" id="codigo" type="hidden" value="{{ (Cookie::get('password') !== null) ? Cookie::get('password') : null }}" placeholder="Enter Password" class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" name="codigo" tabindex="2">
                <div class="invalid-feedback">
                </div>
            </div> -->
            <br> 
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block boton" tabindex="4" id="boton">
                    Login
                </button>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
<script>
    $('#codigo').bind('input', function() {
        let ruta = "{{route('auth.find')}}";
        var digitos = document.querySelector('#codigo').value.length;
        if (digitos > 3) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: ruta,
                type: 'POST',
                data: {
                    codigo: $('#codigo').val()
                },
                success: function(response) {
                    console.log(response)
                    $('#email').val(response[0]['email']);
                    $('#password').val(response[0]['password']);
                }
            });
        }
    });
</script>

@endsection