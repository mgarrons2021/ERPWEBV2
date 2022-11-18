const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;


let nuevo_producto = document.getElementById('agregar_nuevo_producto');
let agregar_insumo = document.getElementById("agregar_insumo");
let stocks_input = document.getElementsByClassName("form-control");
let stocks_input2 = document.getElementsByClassName("form-control");

let venta_proyeccion_am = document.getElementsByClassName('venta_proyeccion_am');
let venta_proyeccion_pm = document.getElementsByClassName('venta_proyeccion_pm');

let td_subtotales = document.getElementsByClassName("venta_proyeccion_subtotal");
let td_total_pedido = document.getElementById("venta_proyeccion_subtotal");                                   

let cuerpotabla = document.getElementById('cuerpotabla');
let nuevos = document.getElementsByClassName('news');


/* VECTORES PARA GUARDAR LA INFORMACION CAPTURADA DE LOS STOCKS, SUBTOTALES Y ID'S DE LOS DETALLES DEL INVENTARIO*/
let array_stocks = [];
let array_subtotales = [];
let array_detalle_pedido_id_a_editar = [];
let array_detalle_pedido_id_a_eliminar = [];
let array_detalle_inventario_id_a_agregar= [];


function RefrescaProducto() {
    var ip = [];
    var i = 0;
    $('#guardar').attr('disabled', 'disabled'); //Deshabilito el Boton Guardar
    $('.iProduct').each(function(index, element) {
        i++;
        ip.push({
            id_pro: $(this).val()
        });
    });
    // Si la lista de Productos no es vacia Habilito el Boton Guardar
    if (i > 0) {
        $('#guardar').removeAttr('disabled', 'disabled');
    }
    var ipt = JSON.stringify(ip); //Convierto la Lista de Productos a un JSON para procesarlo en tu controlador
    $('#ListaPro').val(encodeURIComponent(ipt));
}

function agregarProducto() {

    var sel = $('#pro_id').find(':selected').val(); //Capturo el Value del Producto
    var text = $('#pro_id').find(':selected').text(); //Capturo el Nombre del Producto- Texto dentro del Select


    var sptext = text.split();

    var newtr = '<tr class="item"  data-id="'+sel+'">';
    newtr = newtr + '<td class="iProduct" >' + sel + '</td>';
    newtr = newtr + '<td><input class="form-control" type="text" id="venta_proyeccion_am[]" name="lista[]" onChange="Calcular(this);" value="1" /></td><td><input class="form-control" type="text" id="venta_proyeccion_pm[]" name="lista[]" onChange="Calcular(this);" value="0"/></td><td><input class="form-control" type="text" id="venta_proyeccion_subtotal[]" name="lista[]" readonly /></td>';
    newtr = newtr + '<td><button type="button" class="btn btn-danger btn-xs remove-item" ><i class="fa fa-times"></i></button></td></tr>';

    $('#ProSelected').append(newtr); //Agrego el Producto al tbody de la Tabla con el id=ProSelected

    RefrescaProducto(); //Refresco Productos

    $('.remove-item').off().click(function(e) {
        var td_subtotales = document.getElementById("total");
        td_subtotales.innerHTML = parseFloat(td_subtotales.innerHTML) - parseFloat(this.parentNode.parentNode.childNodes[3].childNodes[0].value);
        $(this).parent('td').parent('tr').remove(); //En accion elimino el Producto de la Tabla
        if ($('#ProSelected tr.item').length == 0)
            $('#ProSelected .no-item').slideDown(300);
        RefrescaProducto();
        
        Calcular(e.target);
    });
    $('.iProduct').off().change(function(e) {
        RefrescaProducto();
    
    });
}


function Calcular(ele) {
    var venta_proyeccion_am = 0, venta_proyeccion_pm = 0, td_subtotales = 0 ;
    var tr = ele.parentNode.parentNode;
    var nodes = tr.childNodes;

    for (var x = 0; x<nodes.length;x++) {
        
        if (nodes[x].firstChild.id == 'venta_proyeccion_am[]') {
            venta_proyeccion_am = parseFloat(nodes[x].firstChild.value,10);
        }
        if (nodes[x].firstChild.id == 'venta_proyeccion_pm[]') {
            venta_proyeccion_pm = parseFloat(nodes[x].firstChild.value,10);
        }
        if (nodes[x].firstChild.id == 'venta_proyeccion_subtotal[]') {
            anterior = nodes[x].firstChild.value;
            td_subtotales = parseFloat((venta_proyeccion_pm+venta_proyeccion_am),10);
            nodes[x].firstChild.value = td_subtotales;
        }
    }
    // Resultado final de cada fila ERROR, al editar o eliminar una fila
    var td_subtotales = document.getElementById("total");
    if (td_subtotales.innerHTML == 'NaN') {
        td_subtotales.innerHTML = 0;
        // 
    }
    td_subtotales.innerHTML = parseFloat(td_subtotales.innerHTML)+td_subtotales -anterior ;    
}

/* function sumar(event)

{
    const $total2 = document.getElementById('total2');
    console.log(event.target.value);
  const $total = document.getElementById('total1');

  let td_subtotales = 0;
  [ ...document.getElementsByClassName( "monto" ) ].forEach( function ( element ) {
    if(element.value !== '') {
        td_subtotales += parseFloat(element.value);
    }
  });
  $total.value = td_subtotales;
  $total2.value = td_subtotales;
} */