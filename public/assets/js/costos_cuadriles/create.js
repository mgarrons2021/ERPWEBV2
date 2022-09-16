const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;
let peso_inicial = document.getElementById("peso_inicial");
let nombre_usuario = document.getElementById("nombre_usuario");
let cantidad_lomo = document.getElementById("cantidad_lomo");
let cantidad_cuadril = document.getElementById("cantidad_cuadril");
let cantidad_ideal_cuadril = document.getElementById("cantidad_ideal_cuadril");
let cantidad_eliminado = document.getElementById("cantidad_eliminado");
let cantidad_recortado = document.getElementById("cantidad_recortado");
let agregar_detalle = document.getElementById("agregar_detalle");
let registrar_corte_cuadril = document.getElementById("registrar_corte_cuadril");
let cancelar = document.getElementById("cancelar");

cantidad_lomo.addEventListener("keyup",function(){
    cantidad_ideal_cuadril.value = Math.round(cantidad_lomo.value/0.250);
});

cancelar.addEventListener("click", (e) => {
    window.location.href = ruta_costoscuadriles_index;
});

registrar_corte_cuadril.addEventListener("click", function () {
    fetch(ruta_registrarCostoCuadril, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": csrfToken,
        },

        body: JSON.stringify({
            "peso_inicial":  peso_inicial.value,
            "nombre_usuario" : nombre_usuario.value,

        })
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
                        window.location.href = ruta_costoscuadriles_index;
                    },
                });
            }
        })
        .catch((error) => console.error(error));
});

/*AGREGAR DETALLE DE CAJA CHICA CON FETCH*/
agregar_detalle.addEventListener("click", (e) => {
    fetch(ruta_agregarDetalle, {
        method: "POST",
        body: JSON.stringify({
            detalleCostoCuadril: {
                cantidad_lomo: cantidad_lomo.value,
                cantidad_cuadril: cantidad_cuadril.value,
                cantidad_ideal_cuadril: cantidad_ideal_cuadril.value,
                cantidad_eliminado: cantidad_eliminado.value,
                cantidad_recorte: cantidad_recortado.value,
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
            total_cantidad_lomo = 0;
            total_cantidad_eliminado = 0;
            total_cantidad_recorte = 0;
            total_cantidad_cuadril = 0;
            var opciones = "";
            for (let i in data.lista_costo_cuadril) {
                total_cantidad_lomo += parseFloat(
                    data.lista_costo_cuadril[i].cantidad_lomo
                );
                total_cantidad_eliminado += parseFloat(
                    data.lista_costo_cuadril[i].cantidad_eliminado
                );
                total_cantidad_recorte += parseFloat(
                    data.lista_costo_cuadril[i].cantidad_recorte
                );
                total_cantidad_cuadril += parseFloat(
                    data.lista_costo_cuadril[i].cantidad_cuadril
                );
                opciones += "<tr>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_costo_cuadril[i].cantidad_lomo +
                    " kg";
                ("</td>");
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_costo_cuadril[i].cantidad_eliminado +
                    " kg";
                ("</td>");
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_costo_cuadril[i].cantidad_recorte +
                    " kg";
                ("</td>");
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_costo_cuadril[i].cantidad_cuadril +
                    " Und";
                ("</td>");
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
                '<td  style="text-align: center;" class="table-danger" class="table-danger">' +
                total_cantidad_lomo +
                " Kg" +
                "</td>" +
                '<td  style="text-align: center;" class="table-danger" class="table-danger">' +
                total_cantidad_eliminado +
                " Kg" +
                "</td>" +
                '<td  style="text-align: center;" class="table-danger" class="table-danger">' +
                total_cantidad_recorte +
                " Kg" +
                "</td>" +
                '<td  style="text-align: center;" class="table-danger" class="table-danger">' +
                total_cantidad_cuadril +
                " Und" +
                "</td>" +
                '<td  style="text-align: center;" class="table-danger" class="table-danger">' +
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
            total_cantidad_lomo = 0;
            total_cantidad_eliminado = 0;
            total_cantidad_recorte = 0;
            total_cantidad_cuadril = 0;
            var opciones = "";
            for (let i in data.lista_costo_cuadril) {
                total_cantidad_lomo += parseFloat(
                    data.lista_costo_cuadril[i].cantidad_lomo
                );
                total_cantidad_eliminado += parseFloat(
                    data.lista_costo_cuadril[i].cantidad_eliminado
                );
                total_cantidad_recorte += parseFloat(
                    data.lista_costo_cuadril[i].cantidad_recorte
                );
                total_cantidad_cuadril += parseFloat(
                    data.lista_costo_cuadril[i].cantidad_cuadril
                );
                opciones += "<tr>";
                opciones +=
                    '<td style="text-align: center;" >' +
                    data.lista_costo_cuadril[i].cantidad_lomo +
                    " kg";
                ("</td>");
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_costo_cuadril[i].cantidad_eliminado +
                    " kg";
                ("</td>");
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_costo_cuadril[i].cantidad_recorte +
                    " kg";
                ("</td>");
                opciones +=
                    '<td style="text-align: center;">' +
                    data.lista_costo_cuadril[i].cantidad_cuadril +
                    " Und";
                ("</td>");
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
                '<td  style="text-align: center;" class="table-danger">' +
                total_cantidad_lomo +
                " Kg" +
                "</td>" +
                '<td  style="text-align: center;" class="table-danger">' +
                total_cantidad_eliminado +
                " Kg" +
                "</td>" +
                '<td  style="text-align: center;" class="table-danger">' +
                total_cantidad_recorte +
                " Kg" +
                "</td>" +
                '<td  style="text-align: center;" class="table-danger">' +
                total_cantidad_cuadril +
                " Und" +
                "</td>" +
                '<td  style="text-align: center;" class="table-danger" class="table-danger">' +
                "</td>" +
                "</tr>";

            document.getElementById("tbody").innerHTML = opciones;
        })
        .catch((error) => console.error(error));
}
