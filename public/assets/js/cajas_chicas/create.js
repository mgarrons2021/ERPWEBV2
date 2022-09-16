const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;
let egreso = document.getElementById('egreso');
let tipo_egreso = document.getElementById('tipo_egreso');
let glosa = document.getElementById('glosa');
let tipo_comprobante = document.getElementById('tipo_comprobante');
let nro = document.getElementById('nro');
let registrar_caja_chica = document.getElementById('registrar_caja_chica');

/*AGREGAR DETALLE DE CAJA CHICA CON FETCH*/
agregar_detalle.addEventListener("click", (e) => {
    fetch(ruta_agregarDetalle, {
            method: "POST",
            body: JSON.stringify({
                detalleCajaChica: {
                    egreso: egreso.value,
                    tipo_egreso: tipo_egreso.value,
                    glosa: glosa.value,
                    tipo_comprobante: tipo_comprobante.value,
                    nro: nro.value,
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
            total_egreso = 0;
            var opciones = "";
            for (let i in data.lista_egreso) {
                total_egreso += parseFloat(
                    data.lista_egreso[i].egreso
                );
                opciones += "<tr>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_egreso[i].nro +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_egreso[i].tipo_egreso_nombre +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_egreso[i].glosa +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_egreso[i].egreso +
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
                '<td colspan="2" style="text-align: center;">TOTAL CAJA CHICA</td>' +
                '<td colspan="1" style="text-align: center;">Bs.' +
                total_egreso +
                "</td>" +
                "</tr>";

            document.getElementById("tbody").innerHTML = opciones;
        })
        .catch((error) => console.error(error));
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
            total_egreso = 0;
            var opciones = "";
            for (let i in data.lista_egreso) {
                total_egreso += parseFloat(
                    data.lista_egreso[i].egreso
                );
                opciones += "<tr>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_egreso[i].nro +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_egreso[i].tipo_egreso_nombre +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_egreso[i].glosa +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_egreso[i].egreso +
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
                '<td colspan="2" style="text-align: center;">TOTAL CAJA CHICA</td>' +
                '<td colspan="1" style="text-align: center;">Bs.' +
                total_egreso +
                "</td>" +
                "</tr>";

            document.getElementById("tbody").innerHTML = opciones;
        });
}

registrar_caja_chica.addEventListener('click', function() {
    fetch(ruta_registrarCajaChica, {
            method: "POST",
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
                    onClosed: function() {
                        window.location.href = ruta_cajaschicas_index;
                    },
                });
            }
        })
        .catch((error) => console.error(error));
});