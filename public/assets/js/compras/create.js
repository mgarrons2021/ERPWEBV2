let tipo_comprobante = document.getElementById("tipo_comprobante");
$("#div_nro_recibo").hide();
$("#div_nro_factura").hide();
tipo_comprobante.addEventListener("change", (e) => {
    if (tipo_comprobante.value === "R") {
        $("#div_nro_factura").hide();
        $("#div_nro_recibo").show();
    } else if (tipo_comprobante.value === "F") {
        $("#div_nro_recibo").hide();
        $("#div_nro_factura").show();
    } else if (tipo_comprobante.value === "S") {
        $("#div_nro_recibo").hide();
        $("#div_nro_factura").hide();
    }
});

const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;
let proveedor = document.getElementById("proveedor");
let nombre_producto = document.getElementById("nombre_producto");
let cantidad = document.getElementById("cantidad");
let subtotal = document.getElementById("subtotal");
let precio = document.getElementById("precio");
let glosa = document.getElementById("glosa");
var total_compra = 0;
let agregar_detalle = document.getElementById("agregar_detalle");
let producto = document.getElementById("producto");

let registrar_compra = document.getElementById("registrar_compra");
let registrar_compra2 = document.getElementById("registrar_compra2");
let proveedorid = document.getElementById("proveedor");
let sucursalid = document.getElementById("sucursal");
let cancelar = document.getElementById("cancelar");
let nro_recibo = document.getElementById("nro_recibo");
let nro_factura = document.getElementById("nro_factura");
let nro_autorizacion = document.getElementById("nro_autorizacion");
let cod_control = document.getElementById("cod_control");

let banco = document.getElementById("banco");
let nro_cuenta = document.getElementById("nro_cuenta");
let nro_cheque = document.getElementById("nro_cheque");

/* registrar_compra.disabled = true; */
/*OBTENER PRODUCTOS CON FETCH*/
proveedor.addEventListener("change", (e) => {
    fetch(ruta_obtenerproductos, {
        method: "POST",
        body: JSON.stringify({
            proveedor_id: e.target.value,
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
            var opciones = "<option value='x'> Seleccionar Producto</option>";
            for (let i in data.lista) {
                opciones +=
                    '<option value="' +
                    data.lista[i].id +
                    '">' +
                    data.lista[i].nombre +
                    "</option>";
            }

            document.getElementById("producto").innerHTML = opciones;
        })
        .catch((error) => console.error(error));
    proveedor.disabled = "readonly";
});

/*OBTENER PRECIO DE PRODUCTO CON FETCH*/
producto.addEventListener("change", (e) => {
    //console.log("sfsdf");
    fetch(ruta_obtenerprecios, {
        method: "POST",
        body: JSON.stringify({
            producto_id: e.target.value,
            proveedor_id: proveedor.value,
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
            var opciones = "";
            console.log(data);
            if (data.success) {
                for (let i in data.lista) {
                    opciones +=
                        '<option value="' +
                        data.lista[i].id +
                        '">' +
                        data.lista[i].nombre +
                        "</option>";
                }
                let precio_pro = data.precio.precio;
                document.getElementById("precio").value = precio_pro;
            } else {
                iziToast.warning({
                    title: "WARNING",
                    message: "El producto no cuenta con precio habilitado. ",
                    position: "topCenter",
                    timeout: 1200,
                    onClosed() {
                        $("#producto").val("x");
                    },
                });
            }
        })
        .catch((error) => console.error(error));
});

cantidad.addEventListener("keyup", (e) => {
    subtotal.value = (cantidad.value * precio.value).toFixed(4);
});

/*AGREGAR DETALLE DE COMPRA CON FETCH*/
agregar_detalle.addEventListener("click", (e) => {
    fetch(ruta_guardardetalle, {
        method: "POST",
        body: JSON.stringify({
            detalleCompra: {
                cantidad: cantidad.value,
                subtotal: subtotal.value,
                precio: precio.value,
                producto_id: producto.value,
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
            total_compra = 0;
            var opciones = "";
            for (let i in data.lista_compra) {
                total_compra += parseFloat(data.lista_compra[i].subtotal);
                opciones += "<tr>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_compra[i].producto_nombre["nombre"] +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_compra[i].precio +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_compra[i].cantidad +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_compra[i].subtotal +
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
                '<td colspan="1" style="text-align: center;">TOTAL A PAGAR </td>' +
                '<td colspan="4" style="text-align: center;">Bs.' +
                total_compra +
                "</td>" +
                "</tr>";

            document.getElementById("tbody").innerHTML = opciones;
            cantidad.value = "";
            subtotal.value = "";
        })
        .catch((error) => console.error(error));
});
/*REGISTRAR COMPRA CON FETCH*/
if (usuario_rol.value == "Contabilidad") {
    registrar_compra.addEventListener("click", (e) => {
        $("#exampleModal1").modal("show"); // abrir
        registrar_compra2.addEventListener("click", (e) => {
            if (
                banco.value != "" &&
                nro_cuenta.value != "" &&
                nro_cheque.value != ""
            ) {
                registrar_compra2.disabled = true;
                if (tipo_comprobante.value === "R") {
                    fetch(ruta_registrarCompra, {
                        method: "POST",
                        body: JSON.stringify({
                            proveedor_id: proveedorid.value,
                            compra_total: total_compra,
                            t_comprobante: tipo_comprobante.value,
                            recibo: nro_recibo.value,
                            sucursal_id: sucursalid.value,
                            banco:banco.value,
                            glosa: glosa.value,
                            nro_cuenta:nro_cuenta.value,
                            nro_cheque:nro_cheque.value,
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
                                        window.location.href =
                                            ruta_compras_index;
                                    },
                                });
                            } else {
                                iziToast.error({
                                    title: "ERROR",
                                    message: "No se pudo completar el registro",
                                    position: "topRight",
                                    timeout: 1200,
                                    onClosed: function () {
                                        registrar_compra2.disabled = false;
                                    },
                                });
                            }
                        })
                        .catch((error) => console.error(error));
                } else if (tipo_comprobante.value === "F") {
                    fetch(ruta_registrarCompra, {
                        method: "POST",
                        body: JSON.stringify({
                            proveedor_id: proveedorid.value,
                            compra_total: total_compra,
                            t_comprobante: tipo_comprobante.value,
                            factura: nro_factura.value,
                            autorizacion: nro_autorizacion.value,
                            control: cod_control.value,
                            sucursal_id: sucursalid.value,
                            glosa: glosa.value,
                            banco:banco.value,
                            nro_cuenta:nro_cuenta.value,
                            nro_cheque:nro_cheque.value,
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
                                registrar_compra.disabled = true;
                                iziToast.success({
                                    title: "SUCCESS",
                                    message: "Registro agregado exitosamente",
                                    position: "topRight",
                                    timeout: 1500,
                                    onClosed: function () {
                                        window.location.href =
                                            ruta_compras_index;
                                    },
                                });
                            } else {
                                iziToast.error({
                                    title: "ERROR",
                                    message: "No se pudo completar el registro",
                                    position: "topRight",
                                    timeout: 1200,
                                    onClosed: function () {
                                        registrar_compra2.disabled = false;
                                        console.log(data.msg);
                                    },
                                });
                            }
                        })
                        .catch((error) => console.error(error));
                } else if (tipo_comprobante.value === "S") {
                    fetch(ruta_registrarCompra, {
                        method: "POST",
                        body: JSON.stringify({
                            proveedor_id: proveedorid.value,
                            compra_total: total_compra,
                            t_comprobante: tipo_comprobante.value,
                            sucursal_id: sucursalid.value,
                            banco:banco.value,
                            glosa:glosa.value,
                            nro_cuenta:nro_cuenta.value,
                            nro_cheque:nro_cheque.value,
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
                                registrar_compra.disabled = true;
                                iziToast.success({
                                    title: "SUCCESS",
                                    message: "Registro agregado exitosamente",
                                    position: "topRight",
                                    timeout: 1500,
                                    onClosed: function () {
                                        window.location.href =
                                            ruta_compras_index;
                                    },
                                });
                            } else {
                                iziToast.error({
                                    title: "ERROR",
                                    message: "No se pudo completar el registro",
                                    position: "topRight",
                                    timeout: 1200,
                                    onClosed: function () {
                                        registrar_compra2.disabled = false;
                                        console.log(data.msg);
                                    },
                                });
                            }
                        })
                        .catch((error) => console.error(error));
                }
            }
        });
    });
} else {
    registrar_compra.addEventListener("click", (e) => {
        registrar_compra.disabled = true;
        if (tipo_comprobante.value === "R") {
            fetch(ruta_registrarCompra, {
                method: "POST",
                body: JSON.stringify({
                    proveedor_id: proveedorid.value,
                    compra_total: total_compra,
                    t_comprobante: tipo_comprobante.value,
                    recibo: nro_recibo.value,
                    glosa: glosa.value,
                    sucursal_id: sucursalid.value,
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
                                window.location.href = ruta_compras_index;
                            },
                        });
                    } else {
                        iziToast.error({
                            title: "ERROR",
                            message: "No se pudo completar el registro",
                            position: "topRight",
                            timeout: 1200,
                            onClosed: function () {
                                console.log(data.msg);
                                registrar_compra.disabled = false;
                            },
                        });
                    }
                })
                .catch((error) => console.error(error));
        } else if (tipo_comprobante.value === "F") {
            fetch(ruta_registrarCompra, {
                method: "POST",
                body: JSON.stringify({
                    proveedor_id: proveedorid.value,
                    compra_total: total_compra,
                    t_comprobante: tipo_comprobante.value,
                    factura: nro_factura.value,
                    golsa: glosa.value,
                    autorizacion: nro_autorizacion.value,
                    control: cod_control.value,
                    sucursal_id: sucursalid.value,
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
                       /*  registrar_compra.disabled = true; */
                        iziToast.success({
                            title: "SUCCESS",
                            message: "Registro agregado exitosamente",
                            position: "topRight",
                            timeout: 1500,
                            onClosed: function () {
                                window.location.href = ruta_compras_index;
                            },
                        });
                    } else {
                        iziToast.error({
                            title: "ERROR",
                            message: "No se pudo completar el registro",
                            position: "topRight",
                            timeout: 1200,
                            onClosed: function () {
                                console.log(data.msg);
                                registrar_compra.disabled = false;
                            },
                        });
                    }
                })
                .catch((error) => console.error(error));
        } else if (tipo_comprobante.value === "S") {
            fetch(ruta_registrarCompra, {
                method: "POST",
                body: JSON.stringify({
                    proveedor_id: proveedorid.value,
                    glosa: glosa.value,
                    compra_total: total_compra,
                    t_comprobante: tipo_comprobante.value,
                    sucursal_id: sucursalid.value,
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
                        registrar_compra.disabled = true;
                        iziToast.success({
                            title: "SUCCESS",
                            message: "Registro agregado exitosamente",
                            position: "topRight",
                            timeout: 1500,
                            onClosed: function () {
                                window.location.href = ruta_compras_index;
                            },
                        });
                    } else {
                        iziToast.error({
                            title: "ERROR",
                            message: "No se pudo completar el registro",
                            position: "topRight",
                            timeout: 1200,
                            onClosed: function () {
                                console.log(data.msg);
                                registrar_compra.disabled = false;
                            },
                        });
                    }
                })
                .catch((error) => console.error(error));
        }
    });
}

/*ELIMINAR UN DETALLE DE COMPRA CON FETCH*/
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
            total_compra = 0;
            var opciones = "";
            for (let i in data.lista_compra) {
                total_compra += parseFloat(data.lista_compra[i].subtotal);
                opciones += "<tr>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_compra[i].producto_nombre["nombre"] +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_compra[i].precio +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_compra[i].cantidad +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_compra[i].subtotal +
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
                '<td colspan="1" style="text-align: center;">TOTAL A PAGAR </td>' +
                '<td colspan="4" style="text-align: center;">Bs.' +
                total_compra +
                "</td>" +
                "</tr>";

            document.getElementById("tbody").innerHTML = opciones;
        });
}

cancelar.addEventListener("click", (e) => {
    window.location.href = ruta_compras_index;
});
