let agregar_insumo = document.getElementById("agregar_insumo");
let guardar_pedido = document.getElementById("guardar_pedido");
let cancelar = document.getElementById("cancelar");

let producto = document.getElementById("producto");
let producto_nombre = document.getElementById("producto_nombre");
let precio = document.getElementById("precio");
let sucursal = document.getElementById("sucursal");
let cantidad_solicitada = document.getElementById("cantidad_solicitada");
let subtotal_solicitado = document.getElementById("subtotal_solicitado");
let sucursal_id = document.getElementById("sucursal_id");

let fecha = document.getElementById("fecha_pedido");
let producto_id;
const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;

cancelar.addEventListener("click", (e) => {
    window.location.href = ruta_pedidos;
});

/* Guardar Los Platos Agregados */

guardar_pedido.addEventListener("click", (e) => {
    if (fecha.value == "") {
        $("#errorfecha").removeClass("d-none");
    }

    if (fecha.value != "") {
        fetch(ruta_guardar_pedido, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": csrfToken,
            },
            body: JSON.stringify({
                fecha_pedido: fecha_pedido.value,
            }),
        })
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                console.log(data);
                if (data.success == true) {
                    iziToast.success({
                        title: "SUCCESS",
                        message: "Pedido agregado exitosamente",
                        position: "topRight",
                        timeout: 1500,
                        onClosed: function () {
                            window.location.href = ruta_pedidos;
                        },
                    });
                }
            })
            .catch((error) => {
                iziToast.warning({
                    title: "AVISO",
                    message: "Problemas al guardar el pedido",
                    position: "topCenter",
                    timeout: 1500,
                    
                });
            });
    }else{
        iziToast.warning({
            title: "AVISO",
            message: "Debe seleccionar la fecha",
            position: "topCenter",
            timeout: 1500,
        });

    }
});

/*AGREGAR INSUMO DE PEDIDO*/

agregar_insumo.addEventListener("click", (e) => {
    if (cantidad_solicitada.value == "") {
        $("#errorcantidad").removeClass("d-none");
    } else {
        $("#errorcantidad").addClass("d-none");
    }

    if (producto.value == "x") {
        $("#errorproducto").removeClass("d-none");
    } else {
        $("#errorproducto").addClass("d-none");
    }

    if (cantidad_solicitada.value.length > 0 && producto.value != "x") {
        /*FILETES*/
        let nueva_cantidad = cantidad_solicitada.value;
        let nueva_subtotal = subtotal_solicitado.value;
        let nuevo_precio = precio.value;
        if (producto_id == 3) {
            let filete_en_unidades = cantidad_solicitada.value / 0.18;
            let precio_por_unidad_filete =
                subtotal_solicitado.value / filete_en_unidades;
            console.log("precio filete/unidad: ", precio_por_unidad_filete);
            nuevo_precio = precio_por_unidad_filete;
            nueva_cantidad = cantidad_solicitada.value;
            nueva_subtotal = nuevo_precio * nueva_cantidad;
        }
        /*CHORIZOS*/

        if (producto_id == 195 || producto_id == 240) {
            let chorizo_en_unidades = 10 * cantidad_solicitada.value;
            let precio_por_unidad_chorizo =
                subtotal_solicitado.value / chorizo_en_unidades;
            nuevo_precio = precio_por_unidad_chorizo;
            nueva_cantidad = cantidad_solicitada.value;

            nueva_subtotal = nuevo_precio * nueva_cantidad;
        }
        /*ALITAS DE POLLO*/

        if (producto_id == 201) {
            let pieza_en_unidades = cantidad_solicitada.value * 8;
            let precio_por_unidad_pieza =
                subtotal_solicitado.value / pieza_en_unidades;
            console.log("precio alitas/unidad: ", precio_por_unidad_pieza);
            nuevo_precio = precio_por_unidad_pieza+1.8;
            nueva_cantidad = cantidad_solicitada.value;
            nueva_subtotal = nuevo_precio * nueva_cantidad;
        }

        /*POLLO BRASA*/

        if (producto_id == 200) {
            let pieza_en_unidades = cantidad_solicitada.value * 8;
            let precio_por_unidad_pieza =
                subtotal_solicitado.value / pieza_en_unidades;
            console.log("precio alitas/unidad: ", precio_por_unidad_pieza);
            nuevo_precio = 26.49;
            nueva_cantidad = cantidad_solicitada.value;
            nueva_subtotal = nuevo_precio * nueva_cantidad;
        }

        

        /*ENVASE TECNOPOR*/
        /*if (producto_id == 165) {
            let pieza_en_unidades = cantidad_solicitada.value * 400;
            let precio_por_unidad_pieza =
                subtotal_solicitado.value / pieza_en_unidades;
            console.log("precio alitas/unidad: ", precio_por_unidad_pieza);
            nuevo_precio = precio_por_unidad_pieza;
            nueva_cantidad = cantidad_solicitada.value;
            nueva_subtotal = nuevo_precio * nueva_cantidad;
        }*/

        /*CHULETA DE CERDO*/
        if (producto_id == 21) {
            console.log(precio.value);
            let pieza_en_unidades = cantidad_solicitada.value / 0.6;
            let precio_por_unidad_pieza = 6;
            console.log("precio alitas/unidad: ", precio_por_unidad_pieza);
            nuevo_precio = precio_por_unidad_pieza;
            nueva_cantidad = cantidad_solicitada.value;
            nueva_subtotal = nuevo_precio * nueva_cantidad;
        }

        /*PLATANO*/
        if (producto_id == 45) {
            let pieza_en_unidades = cantidad_solicitada.value * 64;
            let precio_por_unidad_pieza =
                subtotal_solicitado.value / pieza_en_unidades;
            console.log("precio alitas/unidad: ", precio_por_unidad_pieza);
            nuevo_precio = precio_por_unidad_pieza;
            nueva_cantidad = cantidad_solicitada.value;
            nueva_subtotal = nuevo_precio * nueva_cantidad;
        }

        fetch(ruta_agregar_insumo, {
            method: "POST",
            body: JSON.stringify({
                detallePedido: {
                    producto: producto.value,
                    producto_nombre: producto_nombre.value,
                    cantidad_solicitada: nueva_cantidad,
                    subtotal_solicitado: nueva_subtotal,
                    precio: nuevo_precio,
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
                /* console.log("precio chorizo/unidad: ",precio_por_unidad_chorizo) */

                let total = 0;
                var opciones = "";
                for (let i in data.pedidos_sucursales) {
                    total += parseFloat(
                        data.pedidos_sucursales[i].subtotal_solicitado
                    );
                    opciones += "<tr>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        data.pedidos_sucursales[i].producto_nombre +
                        "</td>";

                    opciones +=
                        '<td style="text-align: center;">' +
                        data.pedidos_sucursales[i].cantidad_solicitada +
                        "</td>";

                    opciones +=
                        '<td style="text-align: center;">' +
                        data.pedidos_sucursales[i].unidad_medida +
                        "</td>";

                    opciones +=
                        '<td style="text-align: center;">' +
                        data.pedidos_sucursales[i].precio +
                        "</td>";

                    opciones +=
                        '<td style="text-align: center;">' +
                        data.pedidos_sucursales[i].subtotal_solicitado +
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
                    "</td>" +
                    '<td colspan="6" style="text-align: center;" class="table-info">' +
                    total +
                    " Bs" +
                    "</tr>";
                document.getElementById("tbody").innerHTML = opciones;
            })
            .catch((error) => {
                iziToast.warning({
                    title: "AVISO",
                    message: "Problemas al guardar el producto",
                    position: "topCenter",
                    timeout: 1500,
                    
                });          
            });
    }else{

        iziToast.warning({
            title: "AVISO",
            message: "Debe rellenar los campos faltantes",
            position: "topCenter",
            timeout: 1500,
            
        });

    }
});

/*OBTENER PRECIO DE PRODUCTO */
$(document).ready(function () {
    $("#producto")
        .select2({
            placeholder: "Seleccione una opcion",
        })
        .on("change", function (e) {
            fetch(ruta_obtener_precios, {
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
                    if (data.precio != null) {
                        producto_id = data.producto_id;
                        console.log(data.precio);
                        producto_nombre.value = data.producto_nombre;
                        document.getElementById("precio").value = data.precio;
                    } else {
                        producto.selectedIndex = 0;
                        iziToast.warning({
                            title: "WARNING",
                            message:
                                "El producto no cuenta con un precio a registrar",
                            position: "topRight",
                            timeout: 1500,
                        });
                        $("#producto")
                            .val("x")
                            .trigger("change.select2");

                    }
                })
                .catch((error) => console.error(error));
        });
});

/* Calculo el sub total segun precio */
cantidad_solicitada.addEventListener("keyup", (e) => {
    subtotal_solicitado.value = (
        cantidad_solicitada.value * precio.value
    ).toFixed(4);
});

/*Eliminar Insumo Agregado*/
function eliminar(i) {
    fetch(ruta_eliminar_insumo, {
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
            let total = 0;
            var opciones = "";
            for (let i in data.pedidos_sucursales) {
                total += parseFloat(
                    data.pedidos_sucursales[i].subtotal_solicitado
                );
                opciones += "<tr>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.pedidos_sucursales[i].producto_nombre +
                    "</td>";

                opciones +=
                    '<td style="text-align: center;">' +
                    data.pedidos_sucursales[i].cantidad_solicitada +
                    "</td>";

                opciones +=
                    '<td style="text-align: center;">' +
                    data.pedidos_sucursales[i].unidad_medida +
                    "</td>";

                opciones +=
                    '<td style="text-align: center;">' +
                    data.pedidos_sucursales[i].precio +
                    "</td>";

                opciones +=
                    '<td style="text-align: center;">' +
                    data.pedidos_sucursales[i].subtotal_solicitado +
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
                "</td>" +
                '<td colspan="6" style="text-align: center;" class="table-danger" class="table-danger">' +
                total +
                " Bs" +
                "</tr>";

            document.getElementById("tbody").innerHTML = opciones;
        });
}
