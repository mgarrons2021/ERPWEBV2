let agregar = document.getElementById("agregar");
let registrar_eliminacion = document.getElementById("registrar_eliminacion");
let producto = document.getElementById("producto");
let produccion = document.getElementById("producto_prod");
let observacion = document.getElementById("observacion");
let stock_actual = document.getElementById("stock_actual");
let cantidad_eliminar = document.getElementById("cantidad_eliminar");
let stock_nuevo = document.getElementById("stock_nuevo");
let inventario_id = 0;

let precio = document.getElementById("precio");
let unidad_medida = document.getElementById("unidad_medida");

let sin_seleccionar = document.getElementById("sin_seleccionar");
let estado = document.getElementById("estado");
let turno = document.getElementById("turno");

const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;

cantidad_eliminar.addEventListener("keyup", function () {
    stock_nuevo.value = stock_actual.value - cantidad_eliminar.value;
});

$("#proddd").hide();

document
    .getElementById("categoria_producto")
    .addEventListener("change", (e) => {
        console.log("entro");
        if (categoria_producto.value === "I") {
            $("#proddd").hide();
            $("#prod").show();
        } else if (categoria_producto.value === "P") {
            $("#proddd").show();
            $("#prod").hide();
        }
    });

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
                    console.log(data);
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

    $("#producto_prod")
        .select2({
            placeholder: "Seleccione una opcion",
        })
        .on("change", function (e) {
            fetch(ruta_obtenerDatosProducto, {
                method: "POST",
                body: JSON.stringify({
                    plato_id: e.target.value,
                    tipo: "Plato",
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

/*AGREGAR DETALLE DE ELIMINACION CON FETCH*/
agregar.addEventListener("click", (e) => {
    let idplato = "";
    let idproducto = "";

    if (categoria_producto.value === "I") {
        if (producto.value == "sin_seleccionar") {
            $("#errorproducto").removeClass("d-none");
        } else if (producto.value != "sin_seleccionar") {
            $("#errorproducto").addClass("d-none");
        }
        idplato = null;
        idproducto = producto.value;
    } else if (categoria_producto.value === "P") {
        if (produccion.value == "sin_seleccionar") {
            $("#errorproducto").removeClass("d-none");
        } else if (produccion != "sin_seleccionar") {
            $("#errorproducto").addClass("d-none");
        }
        idplato = produccion.value;
        idproducto = null;
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

    if (observacion.value != "" && cantidad_eliminar.value != "") {
        fetch(ruta_agregarDetalle, {
            method: "POST",
            body: JSON.stringify({
                detalleEliminacion: {
                    cantidad_eliminar: cantidad_eliminar.value,
                    unidad_medida: unidad_medida.value,
                    precio: precio.value,
                    observacion: observacion.value,
                    producto_id: idproducto,
                    plato_id: idplato,
                    unidad_medida: $("#unidad_medida").val(),
                },
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
                console.log("llego la peticion");
                total_eliminacion = 0;
                var opciones = "";
                for (let i in data.lista_eliminacion) {
                    total_eliminacion += parseFloat(
                        data.lista_eliminacion[i].subtotal
                    );
                    opciones += "<tr>";
                    if (categoria_producto.value == "I") {
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_eliminacion[i].producto_nombre +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_eliminacion[i].unidad_medida +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_eliminacion[i].cantidad +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_eliminacion[i].precio +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_eliminacion[i].subtotal +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_eliminacion[i].observacion +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            '<button class="btn btn-danger" onclick="eliminar(' +
                            i +
                            ');"><i class="fas fa-trash"></i></button>' +
                            "</td>";
                        opciones += "</tr>";
                    }
                    if (categoria_producto.value == "P") {
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_eliminacion[i].plato_nombre +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_eliminacion[i].unidad_medida +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_eliminacion[i].cantidad +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_eliminacion[i].precio +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_eliminacion[i].subtotal +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_eliminacion[i].observacion +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            '<button class="btn btn-danger" onclick="eliminar(' +
                            i +
                            ');"><i class="fas fa-trash"></i></button>' +
                            "</td>";
                        opciones += "</tr>";
                    }
                }
                opciones +=
                    "<tr>" +
                    '<td colspan="1" style="text-align: center;">TOTAL INVENTARIO</td>' +
                    '<td colspan="4" style="text-align: center;">Bs.' +
                    total_eliminacion +
                    "</td>" +
                    "</tr>";
                document.getElementById("tbody").innerHTML = opciones;
            })
            .catch((error) => console.error(error));
    }
});

/*ELIMINAR UN DETALLE DE UNA ELIMINACION CON FETCH*/
function eliminar(i) {
    fetch(ruta_eliminardetalle, {
        method: "POST",
        body: JSON.stringify({
            data: i,
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
            console.log("llego la peticion");
            total_eliminacion = 0;
            var opciones = "";
            for (let i in data.lista_eliminacion) {
                total_eliminacion += parseFloat(
                    data.lista_eliminacion[i].subtotal
                );
                opciones += "<tr>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_eliminacion[i].producto_nombre +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_eliminacion[i].unidad_medida +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_eliminacion[i].cantidad +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_eliminacion[i].precio +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_eliminacion[i].subtotal +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_eliminacion[i].observacion +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    '<button class="btn btn-danger" onclick="eliminar(' +
                    i +
                    ');"><i class="fas fa-trash"></i></button>' +
                    "</td>";
                opciones += "</tr>";
            }
            opciones +=
                "<tr>" +
                '<td colspan="1" style="text-align: center;">TOTAL INVENTARIO</td>' +
                '<td colspan="4" style="text-align: center;">Bs.' +
                total_eliminacion +
                "</td>" +
                "</tr>";

            document.getElementById("tbody").innerHTML = opciones;
        })
        .catch((error) => console.error(error));
}

/*OBTENER U. M. DE PRODUCTO CON FETCH*/
producto.addEventListener("change", (e) => {
    console.log("entro a productos");
});

/*REGISTRAR ELIMINACION CON FETCH*/
registrar_eliminacion.addEventListener("click", (e) => {
    if (estado.value == "") {
        $("#erroreliminacion").removeClass("d-none");
    } else if (estado.value != "") {
        $("#erroreliminacion").addClass("d-none");
    }

    if (turno.value == "") {
        $("#errorturno").removeClass("d-none");
    } else if (turno.value != "") {
        $("#errorturno").addClass("d-none");
    }

    if (estado.value != "" && turno.value != "") {
        fetch(ruta_registrarEliminacion, {
            method: "POST",
            body: JSON.stringify({
                inventario_id: inventario_id,
                estado: estado.value,
                turno: turno.value,
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
    }
});
