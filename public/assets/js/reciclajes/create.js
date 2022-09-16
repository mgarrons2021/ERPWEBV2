let stock_actual = 0;
let cantidad = 0;
let producto = document.getElementById("producto");
let producto_prod = document.getElementById("producto_prod");
/* Token CSRFD */
const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;
/* Variables */
let agregar_detalle = document.getElementById("agregar_detalle");
let registrar_detalle = document.getElementById("registrar_reciclaje");
let inventario_id = 0;

/* Rutas */
let categoria_producto = document.getElementById("categoria_producto");
$("#prodpp").hide();

document
    .getElementById("categoria_producto")
    .addEventListener("change", (e) => {
        if (categoria_producto.value === "I") {
            console.log("entro a insumo");
            $("#prodpp").hide();
            $("#prod").show();
        } else if (categoria_producto.value === "P") {
            console.log("entro a produccion");
            $("#prodpp").show();
            $("#prod").hide();
        }
});


$("#cantidad").keyup(function () {
    //console.log(1);
    stock_actual = $("#stock_actual").val();
    cantidad = $("#cantidad").val();
    let stock_nuevo = stock_actual - cantidad;
    $("#stock_nuevo").val(stock_nuevo);
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
                if(data.status){
                    let precio = data.precio;
                let unidad_medida = data.unidad_medida;
                let stock_actual = data.stock;
                document.getElementById("stock_actual").value = stock_actual;
                document.getElementById("precio").value = precio;
                document.getElementById("unidad_medida").value = unidad_medida;

                }else{

                    iziToast.warning({
                        title: "WARNING",
                        message:
                            " Detalle " +
                            data.msj,
                        position: "topCenter",
                        timeout: 1500,
                        onClosed: function () {
                            $("#stock_actual").val("");
                        },
                    });
                    

                }
                
            })
            .catch((error) => {
                iziToast.warning({
                    title: "WARNING",
                    message:
                        "No se pudo obtener el stock actual del Producto. Detalle " +
                        error,
                    position: "topCenter",
                    timeout: 1500,
                    onClosed: function () {
                        $("#stock_actual").val("");
                    },
                });
            });
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
                tipo:'Plato'
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
            if(data.status){
                let precio = data.precio;
            let unidad_medida = data.unidad_medida;
            let stock_actual = data.stock;
            document.getElementById("stock_actual").value = stock_actual;
            document.getElementById("precio").value = precio;
            document.getElementById("unidad_medida").value = unidad_medida;

            }else{
                iziToast.warning({
                    title: "WARNING",
                    message:
                        " Detalle " +
                        data.msj,
                    position: "topCenter",
                    timeout: 1500,
                    onClosed: function () {
                        $("#stock_actual").val("");
                    },
                });

            }
            
        })
        .catch((error) => {
            iziToast.warning({
                title: "WARNING",
                message:
                    "No se pudo obtener el stock actual del Producto. Detalle " +
                    error,
                position: "topCenter",
                timeout: 1500,
                onClosed: function () {
                    $("#stock_actual").val("");
                },
            });
        });
    });

})


/*AGREGAR DETALLE DE RECICLAJES CON FETCH*/
agregar_detalle.addEventListener("click", (e) => {

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
        if (producto_prod.value == "sin_seleccionar") {
            $("#errorproducto").removeClass("d-none");
        } else if (producto_prod != "sin_seleccionar") {
            $("#errorproducto").addClass("d-none");
        }
        idplato = producto_prod.value;
        idproducto = null;
    }

    if ($("#observacion").val() == "") {
        $("#errorobservacion").removeClass("d-none");
    } else {
        $("#errorobservacion").addClass("d-none");
    }

    if ($("#cantidad").val() == "") {
        $("#errorcantidad").removeClass("d-none");
    } else {
        $("#errorcantidad").addClass("d-none");
    }

    if ($("#stock_actual").val() == "") {
        $("#errorstock").removeClass("d-none");
    } else {
        $("#errorstock").addClass("d-none");
    }

    if (
        $("#cantidad").val() != "" &&
        $("#observacion").val() != "" &&
        $("#stock_actual").val() != ""
    ) {
        fetch(ruta_agregarDetalle, {
            method: "POST",
            body: JSON.stringify({
                detalleReciclaje: {
                    cantidad_reciclar: $("#cantidad").val(),
                    unidad_medida: $("#unidad_medida").val(),
                    precio: $("#precio").val(),
                    observacion: $("#observacion").val(),
                    producto_id: idproducto,
                    plato_id: idplato ,
                    categoria_producto:$("#categoria_producto").val()
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
                //console.log(data);
                total_reciclaje = 0;
                var opciones = "";
                limpiar_input();
                for (let i in data.lista_reciclaje) {
                    total_reciclaje += parseFloat(
                        data.lista_reciclaje[i].subtotal
                    );
                    opciones += "<tr>";
                    if (categoria_producto.value == "I") {
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_reciclaje[i].producto_nombre +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_reciclaje[i].unidad_medida +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_reciclaje[i].cantidad +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_reciclaje[i].precio +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_reciclaje[i].subtotal +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_reciclaje[i].observacion +
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
                            data.lista_reciclaje[i].plato_nombre +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_reciclaje[i].unidad_medida +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_reciclaje[i].cantidad +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_reciclaje[i].precio +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_reciclaje[i].subtotal +
                            "</td>";
                        opciones +=
                            '<td style="text-align: center;">' +
                            data.lista_reciclaje[i].observacion +
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
                    '<td colspan="1" style="text-align: center;">TOTAL RECICLAJE</td>' +
                    '<td colspan="4" style="text-align: center;">Bs.' +
                    total_reciclaje.toFixed(4) +
                    "</td>" +
                    "</tr>";

                document.getElementById("tbody").innerHTML = opciones;
            })
            .catch((error) => console.error(error));
    }
});

function limpiar_input() {
    $("#cantidad").val(""),
        $("#observacion").val(""),
        $("#producto").val(""),
        $("#stock_actual").val(""),
        $("#stock_nuevo").val("");
}
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
            //console.log(data);
            total_reciclaje = 0;
            var opciones = "";
            limpiar_input();
            for (let i in data.lista_reciclaje) {
                total_reciclaje += parseFloat(data.lista_reciclaje[i].subtotal);
                opciones += "<tr>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_reciclaje[i].producto_nombre +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_reciclaje[i].unidad_medida +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_reciclaje[i].cantidad +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_reciclaje[i].precio +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_reciclaje[i].subtotal.toFixed(4) +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_reciclaje[i].observacion +
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
                '<td colspan="1" style="text-align: center;">TOTAL RECICLAJE</td>' +
                '<td colspan="4" style="text-align: center;">Bs.' +
                total_reciclaje.toFixed(4) +
                "</td>" +
                "</tr>";

            document.getElementById("tbody").innerHTML = opciones;
        })
        .catch((error) => console.error(error));
}
registrar_detalle.addEventListener("click", (e) => {
    if ($("#estado").val() == "") {
        $("#errorregistro").removeClass("d-none");
    } else {
        $("#errorregistro").addClass("d-none");
    }

    if ($("#turno").val() == "") {
        $("#errorturno").removeClass("d-none");
    } else {
        $("#errorturno").addClass("d-none");
    }

    if ($("#estado").val() != "" && $("#turno").val() != "") {
        fetch(ruta_registrarReciclaje, {
            method: "POST",
            body: JSON.stringify({
                inventario_id: inventario_id,
                estado: $("#estado").val(),
                turno: $("#turno").val(),
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
                            window.location.href = ruta_reciclajes_index;
                        },
                    });
                }
            })
            .catch((error) => console.error(error));
    }
});
