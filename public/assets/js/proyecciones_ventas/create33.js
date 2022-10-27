const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;

let agregar_detalle = document.getElementById("agregar_detalle");
let producto = document.getElementById("producto");
let cancelar = document.getElementById("cancelar");
let cantidad = document.getElementById("cantidad");
let registrar_Stock = document.getElementById("registrar_Stock");
let sucursal =  document.getElementById('sucursal');

registrar_Stock.addEventListener("click", (e)=>{ 
    fetch(ruta_registrar_Stock,{
        method: "POST",
        body: JSON.stringify({
            
            sucursal: sucursal.value,
        }),
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": csrfToken,
        },
    }).then((response) => {
        return response.json();
    }).then((data) => {
        if (data.success == true) {
            iziToast.success({
                title: 'SUCCESS',
                message: "Registro agregado exitosamente",
                position: 'topRight',
                timeout: 1500 ,
                onClosed: function () {
                    window.location.href = ruta_registrar_Stock_index;
                }

            });
        }

    }) 
    .catch((error) => console.error(error));
/*     proveedor.disabled = "readonly"; */
})

/*AGREGAR DETALLE DE COMPRA CON FETCH*/
agregar_detalle.addEventListener("click", (e) => {
    fetch(ruta_guardardetalle, {
        method: "POST",
        body: JSON.stringify({
            detalleAsignacion: {
                producto: producto.value,
                cantidad: cantidad.value,
                sucursal:sucursal.value,
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
            for (let i in data.asignar_stock) {
                opciones += "<tr>";
                opciones +=
                '<td style="text-align: center;">' +
                data.asignar_stock[i].sucursal_nombre+
                "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.asignar_stock[i].producto_nombre+
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.asignar_stock[i].cantidad +
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
            var opciones = "";
            for (let i in data.asignar_stock) {
                opciones += "<tr>";
                opciones +=
                '<td style="text-align: center;">' +
                data.asignar_stock[i].sucursal_nombre +
                "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.asignar_stock[i].producto_nombre["nombre"] +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.asignar_stock[i].cantidad +
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
cancelar.addEventListener("click", (e) => {
    window.location.href = ruta_asignar_stock_index;
});
