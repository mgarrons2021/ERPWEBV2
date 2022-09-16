const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;

let actualizar_pedido_enviado = document.getElementById("actualizarStock");
let nuevo_producto = document.getElementById('agregar_nuevo_producto');
let agregar_insumo = document.getElementById("agregar_insumo");
let checboxs_editar = document.getElementsByClassName("checkbox-editar");
let checboxs_eliminar = document.getElementsByClassName("checkbox-eliminar");
let stocks_input = document.getElementsByClassName("form-control stock");
let asignar__stock_id = document.getElementById("asignar__stock_id");
let producto = document.getElementById("producto");
let productonombre = document.getElementById("producto_nombre");
let cantidad = document.getElementById("cantidad");
let cuerpotabla = document.getElementById('cuerpotabla');

/* VECTORES PARA GUARDAR LA INFORMACION CAPTURADA DE LOS STOCKS, SUBTOTALES Y ID'S DE LOS DETALLES DEL INVENTARIO*/
let array_stocks = [];
let array_detalle_pedido_id_a_editar = [];
let array_detalle_pedido_id_a_eliminar = [];


/*OBTENER PRECIO DE PRODUCTO */

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

  
    $("#producto")
    .select2({
        placeholder: "Seleccione una opcion",
    })
    .on("change", function (e) {
        console.log( e.target.value );
        fetch( ruta_obtener_precios , {
            method: "POST",
            body: JSON.stringify({
                producto_id: e.target.value,
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
            if(data.precio != null){            

           
                productonombre.value=data.producto_nombre;
                          

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

agregar_insumo.addEventListener('click',function(){
    if (producto.value == "sin_seleccionar") {
        $("#errorproducto").removeClass("d-none");
    } else {
        $("#errorproducto").addClass("d-none");
    }

    if(producto.value != "sin_seleccionar"){
        
        let tr = '<tr>'+
        '<td> <label class="switch">'+
        '<input type="checkbox" class="checkbox-editar" value="'+producto.value+'">'+
        '<span class="slider round"></span>'+
        '</label></td>'+
        '<td>'+
        '<label class="switch">'+
        '<input type="checkbox" class="checkbox-eliminar" value="'+producto.value+'">'+
        '<span class="slider round"></span>'+
        '</label>'+
        '</td>'+
        '<td style="text-align: center;">'+productonombre.value+'</td>'+
        '<td style="text-align: center;">'+          
        ' <input type="number" class="form-control stock" id="stock-'+producto.value+'" style="text-align:center" name="cantidad" value="0" step="any">' +
        ' </td>'+
        '</tr>'; 

        cuerpotabla.innerHTML+=tr;
        /*   array_detalle_pedido_id_a_editar.push({
            'cantidad':0,
            'producto_id':producto.value
        })   */
    }

});

/* Actualizar Pedidos Enviados */
actualizar_pedido_enviado.addEventListener("click", function () {

    for (let index = 0; index < asignar__stock_id.length; index++) {
        array_detalle_pedido_id_a_editar.push( stocks_input[index].id.substr(stocks_input[index].id.search('-')+1) );
      /*   array_subtotales.push( asignar__stock_id[index].innerText ); */
        array_stocks.push( stocks_input[index].value );
    }
    detallesAEditar();
    detallesAEliminar();
                                                        
    console.log( array_detalle_pedido_id_a_editar);
   

    fetch(ruta_actualizarPedido, {
        method: "POST",
        body: JSON.stringify({
            asignar__stock_id: asignar__stock_id.value,
            stocks: array_stocks,
            detallesAEditar_id: array_detalle_pedido_id_a_editar,
            agregarNuevos:array_detalle_pedido_id_a_editar,
            detallesAEliminar_id:array_detalle_pedido_id_a_eliminar
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
                    window.location.href = ruta_asignar_stock_index;
                },
            });
        }
    })
    .catch((error) => console.error(error));

    array_stocks = [];
    array_detalle_pedido_id_a_editar = [];
    array_detalle_pedido_id_a_eliminar = [];  

});



function detallesAEditar() {
    for (let i in checboxs_editar) {
        let checkbox_editar = checboxs_editar[i];
        if (checkbox_editar.value != undefined) {
            if (checkbox_editar.checked) {
                array_stocks.push(stocks_input[i].value);
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
