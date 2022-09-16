const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;
let egreso = document.getElementById("egreso");
let tipo_egreso = document.getElementById("tipo_egreso");
let glosa = document.getElementById("glosa");
let img = document.getElementById("img");
let registrar_caja_chica = document.getElementById("registrar_caja_chica");

$(function () {
    $avatarInput = $("#avatarInput");
    $avatarForm = $("#avatarForm");
    $avatarImagen = $("#avatarImagen");

    /*   $avatarImagen.on */
});
/* avatarUrl = $avatarForm.attr('action'); */

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
                total_egreso += parseFloat(data.lista_egreso[i].egreso);
                opciones += "<tr>";
                opciones +=
                    '<td style="text-align: center"> <img src="' +
                    asset_global +
                    data.lista_egreso[i].imagen +
                    '" alt="" width="80px" style="border-radius:50px" height="85px"> </td>';
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_egreso[i].categoria_nombre +
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

registrar_caja_chica.addEventListener("click", function () {
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
                    onClosed: function () {
                        window.location.href = ruta_cajaschicas_index;
                    },
                });
            }
        })
        .catch((error) => console.error(error));
});

/*AGREGAR DETALLE DE CAJA CHICA CON FETCH*/
agregar_detalle.addEventListener("click", (e) => {
    let formData = new FormData();
    formData.append("imagen", $avatarInput[0].files[0]);
    formData.append("egreso", egreso.value);
    formData.append("tipo_egreso_id", tipo_egreso.value);
    formData.append("tipo_egreso_nombre", tipo_egreso.options[tipo_egreso.selectedIndex].text);
    formData.append("glosa", glosa.value);
    $.ajax({
        url: $avatarForm.attr("action") + "?" + $avatarForm.serialize(),
        method: $avatarForm.attr("method"),
        data: formData,
        processData: false,
        contentType: false,
    })
        .done(function (data) {
            total_egreso = 0;
            var opciones = "";

            for (let i in data.lista_egreso) {
                total_egreso += parseFloat(data.lista_egreso[i].egreso);
                opciones += "<tr>";
                opciones +=
                    '<td style="text-align: center"> <img src="' +
                    asset_global +
                    data.lista_egreso[i].imagen +
                    '" alt="" width="80px" style="border-radius:50px" height="85px"> </td>';
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_egreso[i].categoria_nombre +
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
        .fail(function () {
            alert("La imagen subida no tiene un formato correcto");
        });
});
