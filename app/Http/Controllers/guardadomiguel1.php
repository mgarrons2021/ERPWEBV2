
 <html>
	<head>
		<title>Eliminacion</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="../js/jquery.js"></script>
   <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">	
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="../data/librerias/calendario2/css/bootstrap-datepicker.min.css">

  </head>
<body class="body">
<?php include"../menu/menu.php"; 
$usuario =$_SESSION['usuario'];
$sucur=$usuario['sucursal_id']; 

?>

 <div class="container">
  <div class="left-sidebar">
   <h2>listado de eliminaciones</h2>

<div class="table-responsive">
<script src="../js/jquery.js"></script>
<script src="../data/librerias/calendario2/js/bootstrap-datepicker.min.js"></script>
<script src="../data/librerias/calendario2/locales/bootstrap-datepicker.es.min.js"></script>
<script type="text/javascript">
  $(function(){
  $('.input-daterange').datepicker({
    format: "yyyy-mm-dd",
    language: "es",
    orientation: "bottom auto",
    todayHighlight: true
});
  })
  </script>

 
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
       $(document).ready(function(){$("#usuario").DataTable({language:{sProcessing:"Procesando...",sLengthMenu:"Mostrar _MENU_ registros",sZeroRecords:"No se encontraron resultados",sEmptyTable:"Ningun dato disponible en esta tabla",sInfo:"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",sInfoEmpty:"Mostrando registros del 0 al 0 de un total de 0 registros",sInfoFiltered:"(filtrado de un total de _MAX_ registros)",sInfoPostFix:"",sSearch:"Buscar:",sUrl:"",sInfoThousands:",",sLoadingRecords:"Cargando...",oPaginate:{sFirst:"Primero",sLast:"Ãšltimo",sNext:"Siguiente",sPrevious:"Anterior"},oAria:{sSortAscending:": Activar para ordenar la columna de manera ascendente",sSortDescending:": Activar para ordenar la columna de manera descendente"}}})});
      </script>
  <form action="">  
<div class="row"> 
<div class="col-md-6">  
<div class="input-daterange input-group" id="datepicker">  
    <span class="input-group-addon"><strong>Fecha De:</strong> </span>
    <input type="text" id="fechaini" class="input-sm form-control" name="fechaini" />
    <span class="input-group-addon">A</span>
    <input type="text" id="fechamax" class="input-sm form-control" name="fechamax" />  
    <input  type = "hidden" id = "form_sent" name = "form_sent" value = "true" >
</div>
</div>
<div class="col-md-2">
<input class="form-control" type="submit" value="filtrar" id="filtrar" name="filtrar">
</div>
</div>
</form>  

<br>

<?php if (isset($_GET['form_sent']) && $_GET['form_sent'] == "true") {
$min=$_GET["fechaini"];
$max=$_GET["fechamax"];
$query = $db->GetAll("select t.*, t.fecha, u.nombre as usuario,t.total
from eliminacion t,usuario u
where t.usuario_id=u.idusuario and t.sucursal_id ='$sucur' and t.Fecha between '$min' and '$max'");
}
else{
  $query= $db->GetAll("select t.*, t.fecha, u.nombre as usuario, t.total
from eliminacion t,usuario u
where t.usuario_id=u.idusuario and t.sucursal_id ='$sucur'");
}
  ?>
    <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nro</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>De Sucursal</th>
                 <th>observacion</th>
                <th>Total</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
<?php $nro=0; $total=0; foreach ($query as $r){$nro=$nro+1; $total=$total+$r["total"]?>
<tr   class=warning>
  <td><?php echo $nro; ?></td>
  <td><?php echo $r["fecha"]; ?></td>
    <td><?php echo $r["usuario"]; ?></td>
     <td><?php echo $db->GetOne('SELECT nombre FROM sucursal where idsucursal = '.$r['sucursal_id']); ?></td>
     <td><?php  if($r["descripcion"]=="2"){echo "Sin Eliminacion";}else{echo "Eliminacion";}; ?></td>
    <td><?php echo number_format($r["total"],2)." bs"; ?></td>  
  <td style="width:210px;">
    <a href="#" data-toggle="modal"
                  data-target="#ver<?php echo $r["nro"];?>"><img src="../images/ver.png" alt="" title="ver detalle">Ver Detalle</a>
   <a href="editar.php?nro=<?php echo $r["nro"];?>&inventario=<?php echo $r["inventario_id"];?>"><img src="../images/edit.png" alt="" title="Modificar">Edit</a>
  </td>
  </tr>
 <div class="modal fade" id="ver<?php echo $r["nro"];?>"
                 data-backdrop="static" data-keyboard="false"
                 draggable="modal-header"
                 tabindex="-1" role="dialog" 
                 aria-labelledby="myModalLabel" 
                 aria-hidden="true">
                 <div class="modal-dialog">
                 <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Detalle eliminacion <?php echo $r["nro"]; ?></h4>
                  </div>
                 <div class="modal-body">
                  <div class="row panel panel-primary">
                     <!-- <div class="col-md-2">
                        codigo
                      </div>   -->                 
                      <div class="col-md-2">
                        producto
                      </div>
                       <div class="col-md-4">
                        observacion
                      </div>
                      <div class="col-md-2">
                        cant
                      </div>     
                      <div class="col-md-2">
                        precio
                      </div>                    
                      <div class="col-md-2">
                        subtotal
                      </div>
                  </div>
                  <?php 
$consul = $db->GetAll("
select p.idproducto, p.codigo_producto,p.nombre,dt.cantidad,p.precio_compra,dt.subtotal,u.nombre as umedida, dt.observacion
from detalleeliminacion dt,producto p ,unidad_medida u
where  dt.nro = $r[nro] and p.idunidad_medida=u.idunidad_medida and p.idproducto = dt.producto_id and dt.sucursal_id=".$usuario['sucursal_id']);
                    foreach ($consul as $key) { ?>
                     <div class="row" >
                       <!--<div class="col-md-2">
                         <?php //echo $key["codigo_producto"]; ?>
                       </div>-->
                       <div class="col-md-2">
                         <?php echo $key["nombre"];?>
                       </div>
                       <div class="col-md-4">
                         <?php echo $key["observacion"];?>
                       </div>
                       <div class="col-md-2" >
                         <?php echo $key["cantidad"]." ".$key["umedida"]; ?>
                       </div>
                     
                       <div class="col-md-2">
                         <?php echo $key["precio_compra"]. PHP_EOL ."Bs";?>
                       </div>
                       <div class="col-md-2">
                         <?php echo $key["precio_compra"]*["cantidad"]. PHP_EOL . "Bs";?>
                       </div>
                     </div>
                    <?php } ?>
                    <br>
                    <div class="row panel panel-primary" >
                    <div class="col-md-10">TOTAL</div>
                    <div class="col-md-2">
                      <?php echo number_format($r["total"],2). PHP_EOL ."Bs"; ?>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
             </div>
 <?php }?>
  </table>
   <table id="usuario" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
   <tr>
   <td><h4>Total Eliminacion</h4></td><td><h4> <?php echo number_format($total,2)." bs"; ?></h4>
   </td></tr>
   </table>
  </div>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
  </div>
</div>  <!-- Start WOWSlider.com BODY section -->
<!-- End WOWSlider.com 
  BODY section -->
  </body>
</html>
<script type="text/javascript">
$("#filtrar").on("click",function(){
fechainicio=document.getElementById("fechaini").value;
fechamax=document.getElementById("fechamax").value;
console.log("esta es la fecha:"+fechainicio+" y la fecha max:"+fechamax);
});
</script>