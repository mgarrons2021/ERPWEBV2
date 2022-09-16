const csrfToken = document.head.querySelector(
    "[name~=csrf-token][content]"
).content;

let agregar_detalle = document.getElementById("agregar_detalle");
let producto = document.getElementById("producto");
let cancelar = document.getElementById("cancelar");
let precio = document.getElementById("precio");
let proveedor_id= document.getElementById("proveedor");
let registrar_precios = document.getElementById("registrar_precios");

registrar_precios.addEventListener("click", (e)=>{ 
    fetch(ruta_registrar_precios,{
        method: "POST",
        body: JSON.stringify({
            proveedor_id: proveedor.value,
            
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
                    window.location.href = ruta_productos_proveedores_index;
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
                precio: precio.value,
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
            for (let i in data.productos_proveedores) {
                opciones += "<tr>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.productos_proveedores[i].producto_nombre["nombre"] +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.productos_proveedores[i].precio +
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
            for (let i in data.productos_proveedores) {
                opciones += "<tr>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.productos_proveedores[i].producto_nombre["nombre"] +
                    "</td>";
                opciones +=
                    '<td style="text-align: center;">' +
                    data.productos_proveedores[i].precio +
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
    window.location.href = ruta_productos_proveedores_index;
});
