@extends('layouts.app', ['activePage' => 'pagos', 'titlePage' => 'Pagos'])

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Registrar Pago</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('pagos.store') }}" method="POST" class="form-horizontal">
                                @csrf
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_actual">Fecha de Pago</label>
                                        <input type="date" class="form-control" name="fecha_actual"  readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_actual"> Vencimiento de Pago</label>
                                        <input type="date" class="form-control" name="fecha_actual" readonly >
                                    </div>
                                </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="banco"> Banco* </label>
                                            <input type="text" class="form-control" name="banco"
                                             placeholder="Nombre del Banco">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="nro_cuenta"> Nro de Cuenta* </label>
                                            <input type="number" class="form-control" name="nro_cuenta"
                                                 >
                                        </div>
                                    </div>
                                   
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tipo_pago">Tipo de Pago*</label>
                                            <select name="tipo_pago"   class="form-select" readonly>
                                                <option >Cheque</option>     
                                            </select>
                                        </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nro_comprobante">Nro de Comprobante</label>
                                                <input type="number" name="nro_comprobante" class="form-control" value=""
                                                    placeholder="Nro de Comprobante...">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="compra_id">Compra ID<span
                                                        class="required">*</span></label>
                                                <div class="selectric-hide-select">
                                                    <select name="compra_id" id="_sucursal"
                                                        class="form-control selectric">
                                                        @foreach ($compras as $compra)
                                                            <option value="{{ $compra->id }}">{{ $compra->id }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="nro_cheque">Nro Cheque </label>
                                                <input type="number" name="nro_cheque" class="form-control" value=""
                                                    placeholder="Nro de Cheque...">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="estado">Estado<span class="required">*</span></label>
                                                <div class="selectric-hide-select">
                                                    <select name="estado" class="form-control selectric">
                                                        <option value="1">Por Pagar</option>
                                                        <option value="0">Pagado</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-success ">Guardar</button>
                                        <a class="btn btn-info" href="{{route('pagos.index')}}">Volver</a>
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
