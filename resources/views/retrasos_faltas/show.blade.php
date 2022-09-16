@extends('layouts.app', ['activePage' => 'sucursales', 'titlePage' => 'Sucursales'])

@section('content')

@section('css')

@endsection

<section class="section">
  <div class="section-header">
    <h3 class="page__heading">Detalles del registro</h3>
  </div>
  <div class="section-body">
    <div class="row">
      <div class="col-lg-12">
        <div class="card-body">
          <table class="table table-striped table-hover">
            <tbody>
            <tr>
                <th>Fecha </th>
                @php $fecha_formateada = date('d-m-Y', strtotime($retrasos->fecha)); @endphp
                <td>{{ $fecha_formateada }}</td>
              </tr>
              <tr>
                <th>Hora </th>
                @if(isset($retrasos->hora))
                    <td>{{$retrasos->hora}} </td>
                @else
                    <td> No aplica </td>
                @endif
              </tr>
              <tr>
                <th>Funcionario </th>
                <td>{{ $retrasos->user->name }}&nbsp{{ $retrasos->user->apellido }}</td>
              </tr>
              <tr>
                <th>Respaldo</th>
                <td>
                  <p>&nbsp</p>
                  @if($retrasos->imagen!=null && $retrasos->imagen!='')
                  <img id="myImg" src="{{url($retrasos->imagen) }}" alt="" style="width:100%;max-width:150px">
                  @else
                  Sin respaldo   
                  @endif
                  <p>&nbsp</p>
                </td>
              </tr>
              <tr>
                <th>Tipo de registro </th>
                @if($retrasos->tipo_registro === 0)
                    <td> <div class="badge badge-pill badge-warning "> Retraso </div> </td>
                @else
                    <td> <div class="badge badge-pill badge-danger "> Falta</div> </td>
                @endif     
              </tr> 
              <tr>
                  <th> Registrado por </th>
                  <td>
                  {{$retrasos->detalleRetrasoFalta->user->name }}&nbsp{{$retrasos->detalleRetrasoFalta->user->apellido }}
                  </td>
              </tr> 
              <tr>
                  <th> Sucursal </th>
                  <td>
                  {{$retrasos->sucursal->nombre }}
                  </td>
              </tr> 

            </tbody>
          </table>
          <!-- Modal -->
          <div id="myModal" class="modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="img01">
            <div id="caption"></div>
          </div>
          <div class="button-container ">
            <a href="{{ route('retrasosFaltas.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
            <a href="" class="btn btn-info btn-twitter" id="editar"> Editar </a>
          </div>
        </div>
        <div>

        </div>
      </div>
    </div>
</section>

@endsection
@section('page_js')
<script>
$("#editar").click(function(){
   alert('Porfavor solicite el cambio al departamento de sistemas');
});
</script>
<script>
  var modal = document.getElementById("myModal");
  var img = document.getElementById("myImg");
  var modalImg = document.getElementById("img01");
  var captionText = document.getElementById("caption");
  img.onclick = function() {
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
  }

  var span = document.getElementsByClassName("close")[0];
  span.onclick = function() {
    modal.style.display = "none";
  }
</script>
@endsection
@section('page_css')
<style>
  #myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
  }

  #myImg:hover {
    opacity: 0.7;
  }

  .modal {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 100px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.9);
  }

  .modal-content {
    margin: auto;
    display: block;
    width: 50%;
    left: 12%;
    max-width: 300px;
  }

  #caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
  }

  .modal-content,
  #caption {
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
  }

  @-webkit-keyframes zoom {
    from {
      -webkit-transform: scale(0)
    }

    to {
      -webkit-transform: scale(1)
    }
  }

  @keyframes zoom {
    from {
      transform: scale(0)
    }

    to {
      transform: scale(1)
    }
  }

  .close {
    position: absolute;
    top: 50px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
  }

  .close:hover,
  .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
  }

  @media only screen and (max-width: 700px) {
    .modal-content {
      width: 100%;
    }
  }
</style>
@endsection