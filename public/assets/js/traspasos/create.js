let agregar = document.getElementById("agregar");
let registrar_traspaso = document.getElementById("registrar_traspaso");
let producto = document.getElementById("producto");
let stock_actual = document.getElementById("stock_actual");
let cantidad_traspaso = document.getElementById("cantidad_traspaso");
let stock_nuevo = document.getElementById("stock_nuevo");
let inventario_id = 0;

let precio = document.getElementById("precio");
let unidad_medida = document.getElementById("unidad_medida");

let sin_seleccionar = document.getElementById("sin_seleccionar");

let sucursal = document.getElementById("sucursal");

const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;

cantidad_traspaso.addEventListener("keyup", function () {
    stock_nuevo.value = stock_actual.value - cantidad_traspaso.value;
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
                    if (data.status == false) {
                        iziToast.warning({
                            title: "WARNING",
                            message:
                                "El producto no cuenta con inventario . . . ",
                            position: "topCenter",
                            timeout: 1200,
                            onClosed() {
                                $("#producto")
                                    .val("sin_seleccionar")
                                    .trigger("change.select2");
                            },
                        });
                    } else {
                        let precio = data.precio;
                        let unidad_medida = data.unidad_medida;
                        let stock_actual = data.stock; 
                        inventario_id = data.inventario_id;

                        document.getElementById("stock_actual").value =
                            stock_actual;
                        document.getElementById("precio").value = precio;
                        document.getElementById("unidad_medida").value =
                            unidad_medida; 
                    }
                })
                .catch((error) => console.error(error));
        });
});

/*AGREGAR DETALLE DE TRASPASO CON FETCH*/
agregar.addEventListener("click", (e) => {
    if (Number(cantidad_traspaso.value) == "") {
        $("#errorcantidad").removeClass("d-none");
    }

    if (producto.value == "sin_seleccionar") {
        $("#errorproducto").removeClass("d-none");
    }

    if (
        Number(cantidad_traspaso.value) != "" &&
        producto.value != "sin_seleccionar"
    ) {
        fetch(ruta_agregarDetalle, {
            method: "POST",
            body: JSON.stringify({
                detalleTraspaso: {
                    cantidad_traspaso: cantidad_traspaso.value,
                    unidad_medida: unidad_medida.value,
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
                console.log("llego la peticion");
                total_eliminacion = 0;
                var opciones = "";
                for (let i in data.lista_traspaso) {
                    total_eliminacion += parseFloat(
                        data.lista_traspaso[i].subtotal
                    );
                    opciones += "<tr>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        data.lista_traspaso[i].producto_nombre +
                        "</td>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        data.lista_traspaso[i].unidad_medida +
                        "</td>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        data.lista_traspaso[i].cantidad +
                        "</td>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        data.lista_traspaso[i].precio +
                        "</td>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        data.lista_traspaso[i].subtotal +
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
                    '<td colspan="1" style="text-align: center;">TOTAL TRASPASO</td>' +
                    '<td colspan="4" style="text-align: center;">Bs.' +
                    total_eliminacion +
                    "</td>" +
                    "</tr>";

                document.getElementById("tbody").innerHTML = opciones;
            })
            .catch((error) => console.error(error));
    }
});

/*ELIMINAR UN DETALLE DE UN TRASPASO CON FETCH */
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
            for (let i in data.lista_traspaso) {
                total_eliminacion += parseFloat(
                    data.lista_traspaso[i].subtotal
                );
                opciones += "<tr>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_traspaso[i].producto_nombre +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_traspaso[i].unidad_medida +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_traspaso[i].cantidad +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_traspaso[i].precio +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_traspaso[i].subtotal +
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
                '<td colspan="1" style="text-align: center;">TOTAL TRASPASO</td>' +
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

/*REGISTRAR TRASPASO CON FETCH*/
registrar_traspaso.addEventListener("click", (e) => {
    if (sucursal.value == "sin_sucursal") {
        $("#errorsucursal").removeClass("d-none");
    } else {
        
        fetch(ruta_registrarTraspaso, {
            method: "POST",
            body: JSON.stringify({
                sucursal: Number(sucursal.value),
                inventario_id: inventario_id,
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
                            window.location.href = ruta_traspasos_index;
                        },
                    });
                }
        })
        .catch((error) => console.error(error));
        
    }
});
