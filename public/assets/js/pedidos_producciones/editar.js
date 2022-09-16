let actualizar_pedido_enviado = document.getElementById("actualizar_pedido");
let nuevo_producto = document.getElementById('agregar_insumo');

let checboxs_editar = document.getElementsByClassName("checkbox-editar");
let checboxs_eliminar = document.getElementsByClassName("checkbox-eliminar");
let stocks_input = document.getElementsByClassName("form-control stock");
let precios = document.getElementById("precio");
let preciosos = document.getElementsByClassName('precios');

let td_subtotales = document.getElementsByClassName("td_subtotal");
let td_total_pedido = document.getElementById("total_pedido");
let pedido_id = document.getElementById("pedido_id");
let producto = document.getElementById("plato");
let productonombre = document.getElementById("producto_nombre");
let unidad_medida = document.getElementById("unidad_medida");
let cantidad_solicitada = document.getElementById("cantidad_solicitada");
let costo = document.getElementById("costo");
let cuerpotabla = document.getElementById('cuerpotabla');

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




    $("#plato")
    .select2({
        placeholder: "Seleccione una opcion",
    })
    .on("change", function (e) {
        console.log( e.target.value );
        fetch( ruta_obtener_costo , {
            method: "POST",
            body: JSON.stringify({
                plato_id: e.target.value,
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
                unidad_medida.value = data.plato.um;               
            }else{          
                $("#plato")
                .val("x")
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



nuevo_producto.addEventListener('click',function(){
    if (producto.value == "x") {
        $("#errorproducto").removeClass("d-none");
    } else {
        $("#errorproducto").addClass("d-none");
    }

    if ( cantidad_solicitada.value  == " ") {
        $("#errorcantidad").removeClass("d-none");
    } else {
        $("#errorcantidad").addClass("d-none");
    }

    if(producto.value != "x" && $('#errorcantidad').val()  != ""){

        let tr = '<tr>'+
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
        array_detalle_inventario_id_a_agregar.push({
            'cantidad_solicitada':0,
            'cantidad_enviada':0,
            'precio':precios.value,
            'subtotal_solicitado':0,
            'subtotal_enviado':0,
            'pedido_id':0,
            'producto_id':producto.value
        })
    }

});





actualizar_pedido_enviado.addEventListener("click", function () {

    for (let index = 0; index < td_subtotales.length; index++) {
        array_detalle_pedido_id_a_editar.push( stocks_input[index].id.substr(stocks_input[index].id.search('-')+1) );
        array_subtotales.push( td_subtotales[index].innerText );
        array_stocks.push( stocks_input[index].value );
    }
                                                        
    console.log( array_detalle_pedido_id_a_editar);
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


