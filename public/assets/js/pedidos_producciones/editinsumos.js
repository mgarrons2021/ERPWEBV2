const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;

let actualizar_pedido_enviado = document.getElementById("actualizar_pedido_enviado");

let agregar_producto = document.getElementById('agregar_nuevo_producto');

let agregar_insumo = document.getElementById("agregar_insumo");
let checboxs_editar = document.getElementsByClassName("checkbox-editar");
let checboxs_eliminar = document.getElementsByClassName("checkbox-eliminar");
let stocks_input = document.getElementsByClassName("form-control stock");

let preciosos = document.getElementsByClassName('precios');

let td_subtotales = document.getElementsByClassName("td_subtotal");
let td_total_pedido = document.getElementById("total_pedido");
let pedido_id = document.getElementById("pedido_id");
let producto = document.getElementById("producto");

let cantidad_solicitada = document.getElementById("cantidad_solicitada");
let costo = document.getElementById("costo");
let cuerpotabla = document.getElementById('cuerpotabla');

let productonombre = document.getElementById("producto_nombre");
let unidad_medida = document.getElementById("unidad_medida");
let precios = document.getElementById("precio");

/* VECTORES PARA GUARDAR LA INFORMACION CAPTURADA DE LOS STOCKS, SUBTOTALES Y ID'S DE LOS DETALLES DEL INVENTARIO*/
let array_stocks = [];
let array_subtotales = [];
let array_detalle_pedido_id_a_editar = [];
let array_detalle_pedido_id_a_eliminar = [];
let array_detalle_inventario_id_a_agregar= [];

$(document).ready(function () {
    /*DESBLOQUEA LOS INPUTS DE LOS STOCKS*/
    $("body").on("change", ".checkbox-editar", function () {
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
    });
    /*ACTUALIZA LOS SUBTOTALES Y EL TOTAL INVENTARIO*/
    $("body").on("keyup", ".stock", function () {
        for (let i in stocks_input) {
            let stock = stocks_input[i];
            let precio = preciosos[i];
            
            let td_subtotal = td_subtotales[i];
            td_subtotal.innerHTML = stock.value * precio.innerHTML;
        }
        let total = 0;
        for (let j in td_subtotales) { 
            if (
                td_subtotales[j].innerHTML !== undefined &&
                !isNaN(td_subtotales[j].innerHTML)
            ) {
                total += parseFloat(td_subtotales[j].innerHTML);
            }
        }
        td_total_pedido.innerHTML = total;
    });

    $("#producto")
    .select2({
        placeholder: "Seleccione una opcion",
    })
    .on("change", function (e) {
        fetch(ruta_obtener_precios, {
            method: "POST",
            body: JSON.stringify({
                id: e.target.value,
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
            if(data.plato.costo_plato != null){            
                precios.value= data.plato.costo_plato;
                productonombre.value=data.plato.nombre;
                console.log(precios.value)
                unidad_medida.value = data.um;
            }else{
                $("#producto")
                .val("sin_seleccionar")
                .trigger("change.select2");
                iziToast.warning({
                    title: "WARNING",
                    message:
                        "El producto no cuenta con un precio especifico . . . ",
                    position: "topCenter",
                    timeout: 1100
                });
            }
        })
        .catch((error) => console.error(error));
    });                               

});



/* Actualizar Pedidos Enviados */

/* actualizar_pedido_enviado.addEventListener("click", function () {
   
   detallesAEditar();

   console.log(array_stocks);
   console.log( array_subtotales);
   console.log( array_detalle_pedido_id_a_editar); */

   /*  
    fetch(ruta_actualizar_pedido_enviado, {
        method: "POST",
        body: JSON.stringify({
            pedido_id: pedido_id.value,
            total_pedido: td_total_pedido.innerHTML,
            stocks: array_stocks,
            subtotales: array_subtotales,
            detallesAEditar_id: array_detalle_pedido_id_a_editar,
            detalleAgregar : array_detalle_inventario_id_a_agregar
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
    array_detalle_pedido_id_a_eliminar = [];  */

/* });
 */

/* Actualizar Pedidos Enviados */

agregar_producto.addEventListener('click',function () {
    
    if (producto.value == "sin_seleccionar") {
        $("#errorproducto").removeClass("d-none");
    } else {
        $("#errorproducto").addClass("d-none");
    }

    console.log(precios.value);

    if(producto.value!= 'sin_seleccionar'){
        let tr = '<tr class="nuevos_items" id="'+producto.value+'"> '+
            '<td style="text-align: center;"> '+ productonombre.value +' </td>'+
            '<td style="text-align: center;"> 0  </td>'+
            '<td style="text-align: center;"> '+unidad_medida.value+' </td>'+
           ' <td style="text-align: center;">'+
            '    <input type="number" class="form-control stock" id="stock-'+producto.value+'" style="text-align:center" name="" value="0" step="any">'+
            '</td>'+
            '<td style="text-align: center;" class="precios" id="precio-'+producto.value+'">' + precios.value +'   </td>'+
            '<td style="text-align: center;" class="td_subtotal" name="subtotal_enviado" id="subtotal-'+producto.value+'" > 0  </td>'+
        ' </tr> ';
        cuerpotabla.innerHTML+= tr;
    }
});

actualizar_pedido_enviado.addEventListener("click", function () {
    let nuevos = document.getElementsByClassName('nuevos_items');
    for (let index = 0; index < nuevos.length; index++) {
        array_detalle_inventario_id_a_agregar.push({
            'precio': nuevos[index].children[4].innerText ,
            'cantidad_solicitada':0,
            'cantidad_enviada': nuevos[index].children[3].children[0].value ,
            'subtotal_solicitado':0,
            'subtotal_enviado': ( Number( nuevos[index].children[4].innerText) * Number(nuevos[index].children[3].children[0].value ) ),
            'pedido_produccion_id':pedido_id.value,
            'plato_id': nuevos[index].id
         });    
    }

    //console.log(array_detalle_inventario_id_a_agregar);
     for (let index = 0; index < td_subtotales.length; index++) {
        array_detalle_pedido_id_a_editar.push( stocks_input[index].id.substr(stocks_input[index].id.search('-')+1) );
        array_subtotales.push( td_subtotales[index].innerText );
        array_stocks.push( stocks_input[index].value );
    }
    //console.log( array_detalle_pedido_id_a_editar);
   /* console.log(array_stocks);
    console.log( array_subtotales);
    console.log( array_detalle_pedido_id_a_editar);
    console.log( pedido_id.value);
    console.log( td_total_pedido.innerHTML); */

    fetch(ruta_actualizar_pedido_enviado, {
        method: "POST",
        body: JSON.stringify({
            pedido_id: pedido_id.value,
            total_pedido: td_total_pedido.innerHTML,
            stocks: array_stocks,
            subtotales: array_subtotales,
            detallesAEditar_id: array_detalle_pedido_id_a_editar,
            agregarItems:array_detalle_inventario_id_a_agregar
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
                        window.location.href = ruta_pedidos_producciones_index;
                    },
                });
            }else{
                iziToast.warning({
                    title: "WARNING",
                    message: "Fallo al actualizar el pedido",
                    position: "topRight",
                    timeout: 1500,
                    onClosed: function () {
                        window.location.href = ruta_pedidos_producciones_index;
                    },
                });

            }
        })
        .catch((error) => console.error(error)); 
    array_stocks = [];
    array_subtotales = [];
    array_detalle_pedido_id_a_editar = [];
    array_detalle_pedido_id_a_eliminar = [];  

});

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
