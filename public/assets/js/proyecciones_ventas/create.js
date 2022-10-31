const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;

let actualizar_pedido_enviado = document.getElementById("actualizar_pedido");
let nuevo_producto = document.getElementById('agregar_nuevo_producto');
let agregar_insumo = document.getElementById("agregar_insumo");
let stocks_input = document.getElementsByClassName("form-control stock");
let stocks_input2 = document.getElementsByClassName("form-control stock");

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

$(document).ready(function () {
    /*DESBLOQUEA LOS INPUTS DE LOS STOCKS*/
/*     $("body").on("change", ".checkbox-editar", function () {
        for (let i in checboxs_editar) {
            let checkbox_editar = checboxs_editar[i];
            if (checkbox_editar.value != undefined) {
                if (checkbox_editar.checked) {
                    stocks_input[i].removeAttribute("readonly");
                } else {
                    stocks_input[i].setAttribute("readonly", true);
                }
            }
        }
    }); */

    /*ACTUALIZA LOS SUBTOTALES Y EL TOTAL INVENTARIO*/
    $("body").on( ".stock", function () {
        
        for (let i in stocks_input || stocks_input2) 
        {
            let stock = stocks_input[i];
            let stock2 = stocks_input2[i];
            
            let td_subtotales = td_subtotales[i];
            venta_proyeccion_subtotal.value= stock.value + stock2;
        }
        
        let venta_proyeccion_subtotal = 0;
        
    /*      for (let j in td_subtotales) 
        {
            if (
                td_subtotales[j].innerHTML !== undefined &&
                !isNaN(td_subtotales[j].innerHTML)
            ) {
                venta_proyeccion_subtotal += parseFloat(td_subtotales[j].innerHTML);
            }
        }

        td_total_pedido.innerHTML = total; */
 
    });

    
});

/* agregar_insumo.addEventListener('click',function(){

    if (producto.value == "sin_seleccionar") {
        $("#errorproducto").removeClass("d-none");
    } else {
        $("#errorproducto").addClass("d-none");
    }

    if(producto.value != "sin_seleccionar")
    {    
    

        let tr = '<tr class="news" id="'+producto.value+'">'+
            '<td style="text-align: center;">'+productonombre.value+'</td>'+
            '<td style="text-align: center;">'+unidad_medida.value+'</td>'+
            '<td style="text-align: center;">0</td>'+
            '<td style="text-align: center;">'+
                ' <input type="number" class="form-control stock" id="stock-'+producto.value+'" style="text-align:center" name="cantidad_enviada" value="0" step="any">'+
            ' </td>'+

            '<td style="text-align: center;" class="precios" id="precio-'+producto.value+'"> '+precios.value+'</td>'+
            ' <td style="text-align: center;" class="td_subtotal" name="subtotal_enviado" id="subtotal-'+producto.value+'"> 0 </td>'+
            '</tr>';         
        cuerpotabla.innerHTML+=tr;
    }

});
 */
/* Actualizar Pedidos Enviados */

actualizar_pedido_enviado.addEventListener("click", function () {
    
    let id = 0;
    let cantidad = 0;
    let subtotal = 0;
    let precio = 0;
    for (let index = 0; index < nuevos.length; index++) {
        id= nuevos[index].id;
        cantidad = nuevos[index].children[3].children[0];
        subtotal = nuevos[index].children[5].innerText;
        precio = nuevos[index].children[4].innerText;
        array_detalle_inventario_id_a_agregar.push({
            'cantidad_solicitada':0,
            'cantidad_enviada':cantidad.value,
            'precio':precio,
            'subtotal_solicitado':0,
            'subtotal_enviado':subtotal,
            'pedido_id':0,
            'producto_id':id
        });        
    }

    console.log(array_detalle_inventario_id_a_agregar);

    for (let index = 0; index < td_subtotales.length; index++) {
        array_detalle_pedido_id_a_editar.push( (stocks_input[index].id).substr(stocks_input[index].id.search('-')+1) );
        array_subtotales.push( td_subtotales[index].innerText );
        array_stocks.push( stocks_input[index].value );
    }
                                                        
    console.log(array_detalle_pedido_id_a_editar);
    console.log(array_detalle_inventario_id_a_agregar);

    fetch(ruta_actualizar_pedido_enviado, {
        method: "POST",
        body: JSON.stringify({
            pedido_id: pedido_id.value,
            total_pedido: td_total_pedido.innerHTML,
            stocks: array_stocks,
            subtotales: array_subtotales,
            detallesAEditar_id: array_detalle_pedido_id_a_editar,
            agregarNuevos:array_detalle_inventario_id_a_agregar
        }),             
        headers: {              
            "Content-Type": "application/json",
            "X-CSRF-Token": csrfToken,
        },
    })
    .then((response) => {
        return response.json();
    })
    .then((data) => {
        console.log(data);
        if (data.success == true) {
            iziToast.success({
                title: "SUCCESS",
                message: "Pedido Actualizado exitosamente",
                position: "topRight",
                timeout: 1500,
                onClosed: function () {
                    window.location.href = ruta_pedidos_index;
                },     
            });
        }
    })
    .catch((error) => console.error(error));

    array_stocks = [];
    array_subtotales = [];
    array_detalle_pedido_id_a_editar = [];
    array_detalle_pedido_id_a_eliminar = []; 
    array_detalle_inventario_id_a_agregar=[]; 
});

/* 
function detallesAEditar() {
    for (let i in checboxs_editar) {
        let checkbox_editar = checboxs_editar[i];
        if (checkbox_editar.value != undefined) {
            if (checkbox_editar.checked) {
                array_stocks.push(stocks_input[i].value);
                array_subtotales.push(td_subtotales[i].innerHTML);
                array_detalle_pedido_id_a_editar.push(checkbox_editar.value);
            }
        }
    }
}

function detallesAEliminar() {
    for (let i in checboxs_eliminar) {
        let checkbox_eliminar = checboxs_eliminar[i];
        if (checkbox_eliminar.value != undefined) {
            if (checkbox_eliminar.checked) {
                array_detalle_pedido_id_a_eliminar.push(
                    checkbox_eliminar.value
                );
            }
        }
    }
}
 */