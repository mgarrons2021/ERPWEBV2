let agregar_plato = document.getElementById("agregar_plato");
let plato = document.getElementById("plato");
let sucursal = document.getElementById("sucursal");
let categoria_plato = document.getElementById("categoria_plato");
let precio = document.getElementById("precio");
let precio_delivery = document.getElementById("precio_delivery");
let guardar_plato = document.getElementById("guardar_plato");
let sucursal_id = document.getElementById("sucursal_id");
let cancelar = document.getElementById("cancelar");

const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;

cancelar.addEventListener("click", (e) => {
    window.location.href = ruta_platos_sucursales_index;
});

/* Guardar Los Platos Agregados */

guardar_plato.addEventListener("click", (e) => {
    fetch(ruta_guardar_plato, {
        method: "POST",
        body: JSON.stringify({
            categoria_plato_id: categoria_plato.value,
            categoria_plato_nombre:
                categoria_plato.options[categoria_plato.selectedIndex].text,
            plato: plato.value,
            precio: precio.value,
            precio_delivery: precio_delivery.value,
            sucursal: sucursal.value,
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
                    message: "Plato agregado exitosamente",
                    position: "topRight",
                    timeout: 1500,
                    onClosed: function () {
                        window.location.href = ruta_platos_sucursales_index;
                    },
                });
            }
        })
        .catch((error) => console.error(error));
});

/*Agregar Platos*/

agregar_plato.addEventListener("click", (e) => {
    fetch(ruta_agregar_plato, {
        method: "POST",
        body: JSON.stringify({
            platosucursal: {
                categoria_plato_id: categoria_plato.value,
                categoria_plato_nombre:
                    categoria_plato.options[categoria_plato.selectedIndex].text,
                plato: plato.value,
                precio: precio.value,
                precio_delivery: precio_delivery.value,
                sucursal: sucursal.value,
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
            var opciones = "";
            for (let i in data.platos_sucursales) {
                opciones += "<tr>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.platos_sucursales[i].categoria_plato_nombre +
                    "</td>";

                opciones +=
                    '<td style="text-align: center;">' +
                    data.platos_sucursales[i].plato_nombre +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.platos_sucursales[i].precio +
                    "</td>";

                opciones +=
                    '<td style="text-align: center;">' +
                    data.platos_sucursales[i].precio_delivery +
                    "</td>";

                opciones +=
                    '<td style="text-align: center;">' +
                    data.platos_sucursales[i].sucursal +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    '<button class="btn btn-danger" onclick="eliminar(' +
                    i +
                    ');"><i class="fas fa-trash"></i></button>' +
                    "</td>";
                opciones += "</tr>";
            }
            document.getElementById("tbody").innerHTML = opciones;
        })
        .catch((error) => console.error(error));
});

/*Obtener Platos*/
categoria_plato.addEventListener("change", (e) => {
    fetch(ruta_obtener_plato, {
        method: "POST",
        body: JSON.stringify({
            plato: e.target.value,
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
            var opciones = "<option> Seleccionar Plato</option>";
            for (let i in data.lista) {
                opciones +=
                    '<option value="' +
                    data.lista[i].id +
                    '">' +
                    data.lista[i].nombre +
                    "</option>";
            }

            document.getElementById("plato").innerHTML = opciones;
        })
        .catch((error) => console.error(error));
    /*  categoria_plato.disabled = "readonly"; */
});

/*Eliminar Plato Agregado*/
function eliminar(i) {
    fetch(ruta_eliminar_plato, {
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
            var opciones = "";
            for (let i in data.platos_sucursales) {
                opciones += "<tr>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.platos_sucursales[i].categoria_plato_nombre +
                    "</td>";

                opciones +=
                    '<td style="text-align: center;">' +
                    data.platos_sucursales[i].plato_nombre +
                    "</td>";

                opciones +=
                    '<td style="text-align: center;">' +
                    data.platos_sucursales[i].precio +
                    "</td>";

                opciones +=
                    '<td style="text-align: center;">' +
                    data.platos_sucursales[i].precio_delivery +
                    "</td>";

                opciones +=
                    '<td style="text-align: center;">' +
                    data.platos_sucursales[i].sucursal +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    '<button class="btn btn-danger" onclick="eliminar(' +
                    i +
                    ');"><i class="fas fa-trash"></i></button>' +
                    "</td>";
                opciones += "</tr>";
            }

            document.getElementById("tbody").innerHTML = opciones;
        });
}
