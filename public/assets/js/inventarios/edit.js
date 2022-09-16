const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;

let actualizar_inventario = document.getElementById("actualizar_inventario");
let checboxs_editar = document.getElementsByClassName("checkbox-editar");
let checboxs_eliminar = document.getElementsByClassName("checkbox-eliminar");
let stocks_input = document.getElementsByClassName("form-control stock");
let precios = document.getElementsByClassName("precio");

let td_subtotales = document.getElementsByClassName("td_subtotal");
let td_total_inventario = document.getElementById("total_inventario");
let inventario_id = document.getElementById("inventario_id");

let agregar_inventario = document.getElementById("agregar_producto");
let producto = document.getElementById("producto");
let cantidad = document.getElementById("cantidad");
let cuerpotabla = document.getElementById("cuerpoTabla");
let proveedor = document.getElementById("proveedorl");

/* VECTORES PARA GUARDAR LA INFORMACION CAPTURADA DE LOS STOCKS, SUBTOTALES Y ID'S DE LOS DETALLES DEL INVENTARIO*/
let array_stocks = [];
let array_subtotales = [];
let array_detalle_inventario_id_a_editar = [];
let array_detalle_inventario_id_a_eliminar = [];
let array_detalle_inventario_id_a_agregar = [];

$(document).ready(function () {
    /*DESBLOQUEA LOS INPUTS DE LOS STOCKS*/
    $("body").on("change",".checkbox-editar", function () {
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
        td_total_inventario.innerHTML = total;
    });
});
        
actualizar_inventario.addEventListener("click", function () {
    detallesAEditar();
    detallesAEliminar();
    /* ACTUALIZAR INVENTARIO CON FETCH */
    fetch(ruta_actualizarInventario, {
        method: "POST",
        body: JSON.stringify({
            inventario_id: inventario_id.value,
            total_inventario: td_total_inventario.innerHTML,
            stocks: array_stocks,
            subtotales: array_subtotales,
            detallesAEditar_id: array_detalle_inventario_id_a_editar,
            detallesAEliminar_id: array_detalle_inventario_id_a_eliminar,
            detallesAAgregar_datos: array_detalle_inventario_id_a_agregar,
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
                    message: "Registro agregado exitosamente",
                    position: "topRight",
                    timeout: 1500,
                    onClosed: function () {
                        window.location.href = ruta_inventarios_index;
                    },
                });
            }
        })
        .catch((error) => console.error(error));
    array_stocks = [];
    array_subtotales = [];
    array_detalle_inventario_id_a_editar = [];
    array_detalle_inventario_id_a_eliminar = [];
    array_detalle_inventario_id_a_agregar = [];
});

//FALTA AGREGAR A LA BASE DE DATOS LOS NUEVOS INSUMOS

agregar_inventario.addEventListener("click", function () {
    if (producto.value == "") {
        $("#errorproducto").removeClass("d-none");
    } else {
        $("#errorproducto").addClass("d-none");
    }

    if (cantidad.value == "") {
        $("#errorstock").removeClass("d-none");
    } else {
        $("#errorstock").addClass("d-none");
    }

    if (producto.value != "" && cantidad.value != "") {
        fetch(ruta_obtener_precio, {
            method: "POST",
            body: JSON.stringify({
                producto_id: producto.value,
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
                var nombre = producto[producto.selectedIndex].text;
                array_detalle_inventario_id_a_agregar.push({
                    idInsumo: producto.value,
                    stock: cantidad.value,
                    precio: data.precio,
                });

                console.log(data);
                //console.log(array_detalle_inventario_id_a_agregar);

                var fila =
                    "<tr>" +
                    '<td style="text-align:center ;">' +
                    '<label class="switch">' +
                    '<input type="checkbox" class="checkbox-editar" value="0" disabled="disable">' +
                    ' <span class="slider round"></span>' +
                    " </label>" +
                    "</td>" +
                    '<td style="text-align:center ;">' +
                    '<label class="switch">' +
                    '<input type="checkbox" class="checkbox-eliminar"  value="0" disabled="disable">' +
                    '<span class="slider round"></span>' +
                    "</label>" +
                    "</td>" +
                    '<td style="text-align: center;">' +
                    nombre +
                    "</td>" +
                    '<td style="text-align: center;">' +
                    data.unidad_medida +
                    "</td>" +
                    '<td style="text-align: center;">' +
                    '<input type="number" class="form-control stock" id="0" style="text-align:center" value="' +
                    cantidad.value +
                    '" step="any" readonly>' +
                    "</td>" +
                    '<td style="text-align: center;" class="precio" id="0"> ' +
                    data.precio +
                    "</td>" +
                    '<td style="text-align: center;" class="td_subtotal" id="0"> ' +
                    data.precio * cantidad.value +
                    "</td>" +
                    "</tr>";
                cuerpotabla.innerHTML += fila;
                console.log(td_total_inventario.innerText)
                console.log(stringToHTML(td_total_inventario.innerText))
                td_total_inventario.innerText =
                    parseFloat(td_total_inventario.innerText) +
                    parseFloat(data.precio) * parseFloat(cantidad.value);
            })
            .catch((error) => console.error(error));
    }
});

function stringToHTML(str) {
    var parser = new DOMParser();
    var doc = parser.parseFromString(str, "text/html");
    return doc.body;
}

/* FUNCION INTERMEDIARIA PARA OBTENER EL PRODUCTO DE UN PROVEEDOR */
function seleecionadoSelect(e) {
    var idProveedor = Number(e.value);
    obtenerProductosXProveedor(idProveedor);
}

/*FUNCION PARA OBTENER LOS PRODUCTOS DE UN PROVEEDOR , RECIBE COMO PARAMETRO EL ID DEL PROVEEDOR */
function obtenerProductosXProveedor(idP) {
    fetch(ruta_producto_categoria, {
        method: "POST",
        body: JSON.stringify({
            id: idP,
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
            producto.innerHTML =
                ' <option value="" disabled>Seleccione un producto</option>';
            data.lista_productos.forEach((elent) => {
                console.log(elent.producto);
                producto.innerHTML +=
                    ' <option value="' +
                    elent.producto.codigo +
                    '">' +
                    elent.producto.nombre +
                    "</option>";
            });
        })
        .catch((error) => console.error(error));
}

function detallesAEditar() {
    for (let i in checboxs_editar) {
        let checkbox_editar = checboxs_editar[i];
        if (checkbox_editar.value != undefined) {
            if (checkbox_editar.checked) {
                array_stocks.push(stocks_input[i].value);
                array_subtotales.push(td_subtotales[i].innerHTML);
                array_detalle_inventario_id_a_editar.push(
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
                array_detalle_inventario_id_a_eliminar.push(
                    checkbox_eliminar.value
                );
            }
        }
    }
}
