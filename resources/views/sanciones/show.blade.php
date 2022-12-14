@extends('layouts.app', ['activePage' => 'sucursales', 'titlePage' => 'Sucursales'])

@section('content')

@section('css')

@endsection

<section class="section">
  <div class="section-header">
    <h3 class="page__heading">Vista detallada de la sanción</h3>
  </div>
  <div class="section-body">
    <div class="row">
      <div class="col-lg-12">
        <div class="card-body">
          <table class="table table-striped table-hover">
            <tbody>
              <tr>
                <th>Personal sancionado</th>
                <td>{{ $sancion->user->name }}&nbsp{{ $sancion->user->apellido }}</td>
              </tr>
              <tr>
                <th>Respaldo</th>
                <td>
                  <p>&nbsp</p>
                  @if($sancion->imagen!=null && $sancion->imagen!='')
                  <img id="myImg" src="{{url($sancion->imagen) }}" alt="" style="width:100%;max-width:150px">
                  @else
                  <img id="myImg" src="{isset(img/no-image.jpeg) }}" alt="" style="width:100%;max-width:150px">
                  @endif
                  <p>&nbsp</p>
                </td>
              </tr>
              <tr>
                <th>Fecha sancion</th>
                <td>{{ $sancion->fecha }}</td>
              </tr>
              <tr>
                <th>Descripcion</th>
                <td><span class="">{{ $sancion->descripcion }}</span></td>
              </tr>
              <tr>
                <th>Sucursal</th>
                <td>{{$sancion->sucursal->nombre}}</td>
              </tr>
              <tr>
                <th>Tipo sancion</th>
                <td>{{ $sancion->categoriaSancion->nombre }}</td>
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
            <a href="{{ route('sanciones.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
            <a href="{{route('sanciones.edit', $sancion->id)}}" class="btn btn-info btn-twitter"> Editar </a>
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