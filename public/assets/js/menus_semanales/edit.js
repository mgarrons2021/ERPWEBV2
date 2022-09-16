const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;
let actualizar_menu = document.getElementById("actualizar_menu");
let checboxs_editar = document.getElementsByClassName("checkbox-editar");
let checboxs_eliminar = document.getElementsByClassName("checkbox-eliminar");
let stocks_input = document.getElementsByClassName("form-control stock");
let precios = document.getElementsByClassName("precio");
let cuerpoTabla = document.getElementById("cuerpoTabla");
let dia = document.getElementById("dia");
let plato = document.getElementById("plato");
let menu_id = document.getElementById("menu_id");

/* VECTORES PARA GUARDAR LA INFORMACION CAPTURADA DE LOS STOCKS, SUBTOTALES Y ID'S DE LOS DETALLES DEL INVENTARIO*/
let array_detalle_menu_id_a_eliminar = [];
let array_detalle_menu_agregar = [];

let plato_nombre;
let plato_id;
let plato_categoria;
let plato_costo;
let plato_estado;

function detallesAEliminar() {
    for (let i in checboxs_eliminar) {
        let checkbox_eliminar = checboxs_eliminar[i];
        if (checkbox_eliminar.value != undefined) {
            if (checkbox_eliminar.checked) {
                array_detalle_menu_id_a_eliminar.push(checkbox_eliminar.value);
            }
        }
    }
}

actualizar_menu.addEventListener("click", function () {
    detallesAEliminar();
    /* ACTUALIZAR INVENTARIO CON FETCH */
    fetch(ruta_actualizarMenu, {
        method: "POST",
        body: JSON.stringify({
            menu_id:menu_id.value,
            detallesAEliminar_id: array_detalle_menu_id_a_eliminar,
            detallesAAgregar_datos: array_detalle_menu_agregar,
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
                        window.location.href = ruta_menus_index;
                    },
                });
            }
        })
        .catch((error) => console.error(error));
    array_detalle_menu_agregar = [];
    array_detalle_menu_id_a_eliminar = [];
});

plato.addEventListener("change", function (e) {
    fetch(ruta_obtenerDatosPlatos, {
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
            if (data.success) {
                console.log(data.datos_platos);

                plato_nombre = data.datos_platos.plato_nombre;
                plato_id = data.datos_platos.plato_id;
                plato_categoria = data.datos_platos.plato_categoria;
                plato_costo = data.datos_platos.plato_costo;
                plato_estado = data.datos_platos.plato_estado;
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
                        document.getElementById("stock_actual").value = "";
                    },
                });
            }
        })
        .catch((error) => console.error(error));
});

agregar_plato.addEventListener("click", (e) => {
    /*     let nombre_plato = plato_id[plato_id.selectedIndex].text;
    let id_plato;
    let precio = document.getElementById("precio").value; */

    array_detalle_menu_agregar.push({
        plato_nombre: plato_nombre,
        plato_id: plato_id,
        plato_categoria: plato_categoria,
        plato_costo: plato_costo,
        plato_estado: plato_estado,
    });

    let fila =
        "<tr>" +
        ' <td style="text-align:center ;">' +
        '  <label class="switch">' +
        '   <input type="checkbox" class="checkbox-eliminar" value="0" disabled="disable">' +
        '  <span class="slider round"></span>' +
        " </label>" +
        " </td>" +
        ' <td style="text-align: center;">' +
        plato_nombre +
        "</td>" +
        ' <td style="text-align: center;">' +
        plato_categoria +
        "</td>" +
        ' <td style="text-align: center;">' +
        ' <span class="badge badge-warning"> Sin Precio Asignado </span>' +
        " </td>" +
        ' <td style="text-align: center;" class="precio" id="precio-0"><span class="badge badge-success"> Ofertado </span>' +
        " </td>" +
        "</tr>";
    cuerpoTabla.innerHTML += fila;
});
