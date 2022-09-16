@extends('layouts.app', ['activePage' => 'platos', 'titlePage' => 'Platos'])

@section('content')

@section('css')

@endsection

<section class="section">
  <div class="section-header">
    <h4 class="page__heading">Detalle del Plato</h4>
  </div>
  <div class="section-body">
    <div class="row">
      <div class="col-lg-12" align="center">
        <div class="card ">
          <div class="card-header">
            <h4>Datos Generales del Plato</h4>
          </div>
          <div class="card-body">
            <div class="col-md-9 contenedor">
              @if($plato->imagen!=null && $plato->imagen!='')
              <img id="myImg" src="{{url($plato->imagen) }}" alt="" class="imagen">
              @else
              <h3 style="color: #b1b8bf"> Sin imagen </h3>
              @endif
            </div>
            <h5 class="card-title">Nombre del Plato: {{$plato->nombre}}</h5>
            <p class="card-text">Categoria plato : {{ $plato->categoria_plato->nombre }}</p>
            <p class="card-text">UMC: {{ $plato->unidad_medida_compra->nombre }} - UMV : {{ $plato->unidad_medida_venta->nombre }} </p>
            
            <p class="card-text"><small class="text-muted">@if($plato->estado == 1)
                <td> <span class="badge badge-success"> Ofertado</span></td>
                @else
                <td> <span class="badge badge-warning">De Baja</span></td>
                @endif
              </small>
             

          </div>
        </div>
      </div>

      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4>Receta del Plato : {{$plato->nombre}}</h4>
            <div class="col-xl-8 text-right">
              <a href="{{ route('platos.showPdf', $plato->id) }}" class="btn btn-danger btn-sm">Exportar Receta a PDF</a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <th class="text-center"> Producto </th>
                  <th class="text-center"> Precio </th>
                  <th class="text-center"> U.M. </th>
                  <th class="text-center"> Cantidad </th>
                  <th class="text-center"> Subtotal </th>
                </thead>
                <tbody>
                  @if(isset($recetas[0]))
                  @foreach($recetas as $receta )
                  <tr>
                    <td class="text-center table-light"> {{$receta->productoProveedor->producto->nombre}} </td>
                    <td class="text-center"> {{$receta->productoProveedor->precio}} </td>
                    <td class="text-center table-light">
                      @if(isset($receta->productoProveedor->producto->unidad_medida_compra->nombre))
                      {{$receta->productoProveedor->producto->unidad_medida_compra->nombre}}
                      @else
                      Sin U.M.
                      @endif
                    </td>
                    <td class="text-center"> {{$receta->cantidad}} </td>
                    <td class="text-center"> Bs. {{$receta->subtotal}} </td>
                  </tr>
                  @endforeach
                  <tr>
                    <td colspan="4" class="text-center text-primary">
                      <h6> Costo del plato: </h6>
                    </td>
                    <td class="text-center text-primary">
                      <h6> Bs. {{$plato->costo_plato}} </h6>
                    </td>
                  </tr>
                  @else
                  <tr>
                    <td class="text-center"> Sin datos </td>
                    <td class="text-center"> Sin datos </td>
                    <td class="text-center"> Sin datos </td>
                    <td class="text-center"> Sin datos </td>
                  </tr>
                  @endif
                </tbody>

              </table>
            </div>

          </div>


        </div>
      </div>
    </div>
    <!-- Modal -->
    <div id="myModal" class="modal">
      <span class="close">&times;</span>
      <img class="modal-content" id="img01">
      <div id="caption"></div>
    </div>
  </div>
  <div class="button-container" align="center">
    <a href="{{ route('platos.create') }}" class="btn btn-primary  btn-twitter mr-2"> Agregar plato </a>
    <a href="{{ route('platos.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
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
    border-radius: 70px;
    padding-bottom: 25px;
  }

  #myImg:hover {
    opacity: 0.7;
  }

  .card-imagen {
    background-color: white;
    padding: 5%;
    border-radius: 50px;
    width: 100%;

  }

  .card-receta {
    background-color: white;
    padding: 5%;
    border-radius: 17px;
    width: 100%;
  }

  .imagen {
    padding: 3%;
    border-radius: 50px;
    width: 100%;
    height: 100%
  }

  .contenedor {
    width: 30%;

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