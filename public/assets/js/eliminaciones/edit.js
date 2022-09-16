const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;

let table = document.getElementById("table");
let actualizar_eliminacion = document.getElementById("actualizar_eliminacion");
let checboxs_editar = document.getElementsByClassName("checkbox-editar");
let checboxs_eliminar = document.getElementsByClassName("checkbox-eliminar");
let stocks_input = document.getElementsByClassName("form-control stock");
let precios = document.getElementsByClassName("precio");

let td_subtotales = document.getElementsByClassName("td_subtotal");
let td_total_eliminacion = document.getElementById("total_eliminacion");
let eliminacion_id = document.getElementById("eliminacion_id");
let agregar_nueva_eliminacion = document.getElementById(
    "agregar_nueva_eliminacion"
);

let observacion = document.getElementById("observacion");
let stock_actual = document.getElementById("stock_actual");
let cantidad_eliminar = document.getElementById("cantidad_eliminar");
let nuevo_stock = document.getElementById("nuevo_stock");

let estado = document.getElementById("estado");
let turno = document.getElementById("turno");

/* VECTORES PARA GUARDAR LA INFORMACION CAPTURADA DE LOS STOCKS, SUBTOTALES Y ID'S DE LOS DETALLES DEL INVENTARIO*/
let array_stocks = [];
let array_subtotales = [];
let array_detalle_eliminacion_id_a_editar = [];
let array_detalle_eliminacion_id_a_eliminar = [];
let array_detalle_reciclaje_a_agregar= [];


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
            let precio = precios[i];
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
        td_total_eliminacion.innerHTML = total;
    });
});

actualizar_eliminacion.addEventListener("click", function () {
    detallesAEditar();
    detallesAEliminar();
    /* ACTUALIZAR INVENTARIO CON FETCH */
    fetch(ruta_actualizarEliminacion, {
        method: "POST",
        body: JSON.stringify({
            eliminacion_id: eliminacion_id.value,
            total_eliminacion: td_total_eliminacion.innerHTML,
            stocks: array_stocks,
            subtotales: array_subtotales,
            detallesAEditar_id: array_detalle_eliminacion_id_a_editar,
            detallesAEliminar_id: array_detalle_eliminacion_id_a_eliminar,
            detallesAEliminar_id: array_detalle_eliminacion_id_a_eliminar,
            detallesAAgregar_datos:array_detalle_reciclaje_a_agregar,
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
                    message: "Registro agregado exitosamente",
                    position: "topRight",
                    timeout: 1500,
                    onClosed: function () {
                        window.location.href = ruta_eliminaciones_index;
                    },
                });
            }
        })
        .catch((error) => console.error(error));
    array_stocks = [];
    array_subtotales = [];
    array_detalle_eliminacion_id_a_editar = [];
    array_detalle_eliminacion_id_a_eliminar = [];
});

function detallesAEditar() {
    for (let i in checboxs_editar) {
        let checkbox_editar = checboxs_editar[i];
        if (checkbox_editar.value != undefined) {
            if (checkbox_editar.checked) {
                array_stocks.push(stocks_input[i].value);
                array_subtotales.push(td_subtotales[i].innerHTML);
                array_detalle_eliminacion_id_a_editar.push(
                    checkbox_editar.value
                );
            }
        }
    }
}

function detallesAEliminar() {
    for (let i in checboxs_eliminar) {
        let checkbox_eliminar = checboxs_eliminar[i];
        if (checkbox_eliminar.value != undefined) {
            if (checkbox_eliminar.checked) {
                array_detalle_eliminacion_id_a_eliminar.push(
                    checkbox_eliminar.value
                );
            }
        }
    }
}

cantidad_eliminar.addEventListener("keyup", function () {
    stock_nuevo.value = stock_actual.value - cantidad_eliminar.value;
});

//OBTENER DATOS DEL PRODUCTO//
$(document).ready(function () {
    $("#producto")
        .select2({
            placeholder: "Seleccione una opcion",
        })
        .on("change", function (e) {
            fetch(ruta_obtenerDatosProducto, {
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
                    if (data.status) {
                        let precio = data.precio;
                        let unidad_medida = data.unidad_medida;
                        let stock_actual = data.stock;
                        inventario_id = data.inventario_id;
                        document.getElementById("stock_actual").value =
                            stock_actual;
                        document.getElementById("precio").value = precio;
                        document.getElementById("unidad_medida").value =
                            unidad_medida;
                    } else {
                        iziToast.warning({
                            title: "WARNING",
                            message: data.msj,
                            position: "topCenter",
                            timeout: 1800,
                            onClosed() {
                                $("#producto")
                                    .val("sin_seleccionar")
                                    .trigger("change.select2");
                                document.getElementById("stock_actual").value =
                                    "";
                            },
                        });
                    }
                })
                .catch((error) => console.error(error));
        });
});

//AGREGA UNA NUEVA ELIMINACION//
agregar_nueva_eliminacion.addEventListener("click", function () {
    if (producto.value == "sin_seleccionar") {
        $("#errorproducto").removeClass("d-none");
    } else if (producto.value != "sin_seleccionar") {
        $("#errorproducto").addClass("d-none");
    }

    if (observacion.value == "") {
        $("#errorobservacion").removeClass("d-none");
    } else if (observacion.value != "") {
        $("#errorobservacion").addClass("d-none");
    }

    if (cantidad_eliminar.value == "") {
        $("#errorcantidad").removeClass("d-none");
    } else if (cantidad_eliminar.value != "") {
        $("#errorcantidad").addClass("d-none");
    }

    if ( producto.value != "sin_seleccionar" && observacion.value != "" && cantidad_eliminar.value != "") {
        let nombre = producto[producto.selectedIndex].text;
        let medida=document.getElementById("unidad_medida").value;
        let precio = document.getElementById("precio").value;
        
        array_detalle_reciclaje_a_agregar.push({
            idProducto: producto.value,
            stock: cantidad_eliminar.value,
            precio: precio,
            observacion : observacion.value
        });               

        let fila ='<tr>'+
               ' <td style="text-align:center ;">'+                    
                    '<label class="switch">'+
                       ' <input type="checkbox" class="checkbox-editar" value="0" disabled="disable">'+
                       ' <span class="slider round"></span>'+
                    '</label>'+
               ' </td>'+
               ' <td style="text-align:center ;">'+
                  '  <label class="switch">'+
                     '   <input type="checkbox" class="checkbox-eliminar" value="0" disabled="disable">'+
                      '  <span class="slider round"></span>'+
                   ' </label>'+
               ' </td>'+
               ' <td style="text-align: center;">'+nombre+'</td>'+
               ' <td style="text-align: center;">'+medida+'</td>'+
               ' <td style="text-align: center;">'+
                   ' <input type="number" class="form-control stock" id="stock-0" style="text-align:center" value="'+cantidad_eliminar.value+'" step="any" readonly>'+
               ' </td>'+
               ' <td style="text-align: center;" class="precio" id="precio-0"> '+precio+' </td>'+
               ' <td style="text-align: center;" class="td_observacion" id="observaciones-0"> '+observacion.value+' </td>'+
               ' <td style="text-align: center;" class="td_subtotal" id="subtotal-0"> '+(precio * cantidad_eliminar.value)+' </td>'+
            '</tr>';
            cuerpo_tabla.innerHTML += fila;               
            td_total_eliminacion.innerText =
            parseFloat(td_total_eliminacion.innerText) +
            parseFloat(precio) * parseFloat(cantidad_eliminar.value); 
    }
});
