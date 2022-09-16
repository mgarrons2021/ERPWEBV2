let categoria_insumo = document.getElementById("categoria_insumo");
let producto = document.getElementById("producto");
let producto_prod=document.getElementById('producto_prod');
let agregar_insumo = document.getElementById("agregar_insumo");

let unidad_medida_compra_id = document.getElementById(
    "unidad_medida_compra_id"
);

let registrar_inventario = document.getElementById("registrar_inventario");
let tipo_inventario = document.getElementById("tipo_inventario");
let turno = document.getElementById("turno");
var total_inventario = 0;
let stock = document.getElementById("stock");
let rol = document.getElementById("idrol");

let categoria_producto = document.getElementById("categoria_producto");


const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;

/*AGREGAR DETALLE DE INVENTARIO CON FETCH*/
agregar_insumo.addEventListener("click", (e) => {

    if (rol.value == "3") {
        if (turno.value != "") {
            $("#errorturno").removeClass("d-none");
        } else {
            $("#errorturno").addClass("d-none");
        }
    }

    if (Number(producto.value) <= 0) {
        $("#errorproducto").removeClass("d-none");
    } else {
        $("#errorproducto").addClass("d-none");
    }

    if (stock.value == "") {
        $("#errorstock").removeClass("d-none");
    } else {
        $("#errorstock").addClass("d-none");
    }

    if (
        Number(producto.value) > 0 &&
        stock.value != "" /*  &&
        (rol.value == "2" || rol.value == "1" || rol.value == "5") */
    ) {
        fetch(ruta_guardarDetalleInventario, {
            method: "POST",
            body: JSON.stringify({
                detalleInventario: {
                    stock: stock.value,
                    unidad_medida_id: unidad_medida_compra_id.value,
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
                total_inventario = 0;
                var opciones = "";
                for (let i in data.lista_inventario) {
                    total_inventario += parseFloat(
                        data.lista_inventario[i].subtotal
                    );
                    opciones += "<tr>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        data.lista_inventario[i].producto_nombre +
                        "</td>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        data.lista_inventario[i].unidad_medida_nombre +
                        "</td>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        data.lista_inventario[i].stock +
                        "</td>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        data.lista_inventario[i].costo +
                        "</td>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        data.lista_inventario[i].subtotal +
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
                    total_inventario +
                    "</td>" +
                    "</tr>";

                document.getElementById("tbody").innerHTML = opciones;
            })
            .catch((error) => console.error(error));
    }else{
        iziToast.warning({
            title: "AVISO",
            message: "Debe rellenar los campos faltantes",
            position: "topCenter",
            timeout: 1500,
            
        });
    }
});

/*ELIMINAR UN DETALLE DE INVENTARIO CON FETCH*/
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
            total_inventario = 0;
            var opciones = "";
            for (let i in data.lista_inventario) {
                total_inventario += parseFloat(
                    data.lista_inventario[i].subtotal
                );
                opciones += "<tr>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_inventario[i].producto_nombre +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_inventario[i].unidad_medida_nombre +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_inventario[i].stock +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_inventario[i].costo +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_inventario[i].subtotal +
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
                total_inventario +
                "</td>" +
                "</tr>";

            document.getElementById("tbody").innerHTML = opciones;
        });
}

$(document).ready(function () {
    $("#producto")
        .select2({
            placeholder: "Seleccione una opcion",
        })
        .on("change", function (e) {
            fetch(ruta_obtenerUM, {
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
                    console.log(
                        data
                    );
                    if(data.success!=true){
                        iziToast.warning({
                            title: "WARNING",
                            message: "No se pudo obtener el stock actual del Producto. Detalle "+error,
                            position: "topCenter",
                            timeout: 1500,  
                            onClosed: function() {
                                $("#stock_actual").val('');
                            },
                        });

                    }else {
                         //console.log(data.unidad_medida_venta_id[0].unidad_medida_venta_id);
                    let um_venta_id = data.unidad_medida_compra_id;
                    document.getElementById("unidad_medida_compra_id").value =
                        data.unidad_medida_compra_id[0].unidad_medida_compra_id;
                    }
                })
                .catch((error) => console.error(error));

        });

    $("#producto_prod")
        .select2({
            placeholder: "Seleccione una opcion",
        })
        .on("change", function (e) {
            console.log(e);
            /* fetch(ruta_obtenerUM, {
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
                    console.log(
                        data
                    );
                    if(data.success!=true){
                        iziToast.warning({
                            title: "WARNING",
                            message: "No se pudo obtener el stock actual del Producto. Detalle "+error,
                            position: "topCenter",
                            timeout: 1500,  
                            onClosed: function() {
                                $("#stock_actual").val('');
                            },
                        });

                    }else {
                         //console.log(data.unidad_medida_venta_id[0].unidad_medida_venta_id);
                    let um_venta_id = data.unidad_medida_compra_id;
                    document.getElementById("unidad_medida_compra_id").value =
                        data.unidad_medida_compra_id[0].unidad_medida_compra_id;
                    }
                })
                .catch((error) => console.error(error)); */

        });

});


/*REGISTRAR INVENTARIO CON FETCH*/
registrar_inventario.addEventListener("click", (e) => {    
    if (tipo_inventario.value == "Seleccione un turno") {
        $("#errorinventario").removeClass("d-none");
        iziToast.warning({
            title: "AVISO",
            message: "Debe seleccionar un turno",
            position: "topCenter",
            timeout: 1500,
            
        });
    } else {
        if (turno != null) {
            fetch(ruta_registrarInventario, {
                method: "POST",
                body: JSON.stringify({
                    tipo_inventario: tipo_inventario.value,
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
                                window.location.href = ruta_inventarios_index;
                            },
                        });
                    }
                })
                .catch((error) => console.error(error));
        } else {
            fetch(ruta_registrarInventario, {
                method: "POST",
                body: JSON.stringify({
                    tipo_inventario: tipo_inventario.value,
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
                                window.location.href = ruta_inventarios_index;
                            },
                        });
                    }
                })
                .catch((error) => console.error(error));
        }
    }
});
